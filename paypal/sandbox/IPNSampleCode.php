<?php

// STEP 1: Read POST data

// reading posted data from directly from $_POST causes serialization 
// issues with array data in POST
// reading raw POST data from input stream instead. 
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
     $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
   $get_magic_quotes_exists = true;
} 
foreach ($myPost as $key => $value) {        
   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
        $value = urlencode(stripslashes($value)); 
   } else {
        $value = urlencode($value);
   }
   $req .= "&$key=$value";
}


// STEP 2: Post IPN data back to paypal to validate

$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr'); // change to [...]sandbox.paypal[...] when using sandbox to test
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// In wamp like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
// of the certificate as shown below.
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
if( !($res = curl_exec($ch)) ) {
    // error_log("Got " . curl_error($ch) . " when processing IPN data");
    curl_close($ch);
    exit;
}
curl_close($ch);


// STEP 3: Inspect IPN validation result and act accordingly





// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
if ($_POST['mc_gross'] != NULL)
	echo $payment_amount = $_POST['mc_gross'];
else
	echo $payment_amount = $_POST['mc_gross1'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$custom = $_POST['custom'];

//$payment_amount = mc_gross
//mc_gross=40842.50
if ($_POST['mc_gross'] != NULL){
	$payment_amount = $_POST['mc_gross'];
}else{
	$payment_amount = $_POST['mc_gross1'];
}
$protection_eligibility = $_POST['protection_eligibility'];
$address_status = $_POST['address_status'];
$payer_id = $_POST['payer_id'];
$tax = $_POST['tax'];
$address_street = $_POST['address_street'];
$payment_date = $_POST['payment_date'];
$payment_status = $_POST['payment_status'];
$charset = $_POST['charset'];
$address_zip = $_POST['address_zip'];
$first_name = $_POST['$first_name'];
$option_selection1= $_POST['option_selection1'];
$mc_fee = $_POST['$mc_fee'];

$address_country_code = $_POST['address_country_code'];
$address_name = $_POST['address_name'];
$notify_version = $_POST['notify_version'];
$custom = $_POST['custom'];
$payer_status = $_POST['payer_status'];
$address_country = $_POST['address_country'];
$address_city = $_POST['address_city'];
$quantity = $_POST['quantity'];
$verify_sign = $_POST['verify_sign'];
$payer_email = $_POST['payer_email'];
$option_name1 = $_POST['option_name1'];
//primary key
$txn_id = $_POST['txn_id'];
$payment_type = $_POST['payment_type'];
$btn_id = $_POST['btn_id'];
$last_name = $_POST['last_name'];
$address_state = $_POST['address_state'];
$receiver_email = $_POST['receiver_email'];
$payment_fee = $_POST['payment_fee'];
$shipping_discount = $_POST['shipping_discount'];
$insurance_amount = $_POST['insurance_amount'];
$receiver_id = $_POST['receiver_id'];
$txn_type = $_POST['txn_type'];
$item_name = $_POST['item_name'];
$discount = $_POST['discount'];
$mc_currency = $_POST['mc_currency'];
$item_number = $_POST['item_number'];
$residence_country = $_POST['residence_country'];
$test_ipn = $_POST['test_ipn'];
$shipping_method = $_POST['shipping_method'];
$handling_amount = $_POST['handling_amount'];
$transaction_subject = $_POST['transaction_subject'];
$payment_gross = $_POST['payment_gross'];
$shipping = $_POST['shipping'];
$ipn_track_id = $_POST['ipn_track_id'];



// Insert your actions here
//mew database(transactionID blahblah
include("../../php/DBConfigs.php");
//query
if($payment_status == "Completed"){

	$classDBRelatedFunctions->functionError();
	$classDBRelatedFunctions->functionRoomTransactions($payment_amount,$protection_eligibility,$address_status,$payer_id,$tax,$address_street,$payment_date,$payment_status,$charset,$address_zip,$first_name,$option_selection1,$mc_fee,$address_country_code,$address_name,$notify_version,$custom,$payer_status,$address_country,$address_city,$quantity,$verify_sign,$payer_email,$option_name1,$txn_id,$payment_type,$btn_id,$last_name,$address_state,$receiver_email,$payment_fee,$shipping_discount,$insurance_amount,$receiver_id,$txn_type,$item_name,$discount,$mc_currency,$item_number,$residence_country,$test_ipn,$shipping_method,$handling_amount,$transaction_subject,$payment_gross,$shipping,$ipn_track_id);
}
echo "abmkss";
echo $_POST['item_name'];
if (strcmp ($res, "VERIFIED") == 0) {
    // check whether the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your Primary PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment

	echo "abmkssx";


} else if (strcmp ($res, "INVALID") == 0) {
    // log for manual investigation
}


?>