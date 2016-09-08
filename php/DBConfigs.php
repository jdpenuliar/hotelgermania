<?php
	$classDBRelatedFunctions = new classDBRelatedFunctions;
	class classDBRelatedFunctions{
		private $saltChars;
		public $errorMessage;
		private $passwordFromDB;
		private $saltFromDB;
		function functionError(){
			if(!empty($this->errorMessage)){
				echo $this->errorMessage;
			}elseif(empty($this->errorMessage)){
				return "no error";	
			}
		}
		function functionDBConnect(){
			$host = "localhost";
			$database = "hansotto_hotelgermania";
			$username = "hansotto_hg";
			$password = "9gpfFt_erSe5";
			$DBConnection = mysql_connect("$host","$username","$password");
			$DBSelect = mysql_select_db($database, $DBConnection);
			if(!$DBSelect){
				die("Database selection failed: " . mysql_error());
			}
			return $DBConnection;
		}
		function functionReserve($roomID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblrooms SET roomVacancy = roomVacancy - 1 WHERE roomID='$roomID'") or die(mysql_error());
			mysql_query($SQLQuery);
		}
		function functionListRoomData(){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("SELECT * FROM tblrooms") or die(mysql_error());
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)) {
					echo "<room>";
						echo "<roomID>";
							echo $row['roomID'];
						echo "</roomID>";
						echo "<roomName>";
							echo $row['roomName'];
						echo "</roomName>";
						echo "<roomTotal>";
							echo $row['roomTotal'];
						echo "</roomTotal>";
						echo "<roomVacancy>";
							echo $row['roomVacancy'];
						echo "</roomVacancy>";
						echo "<roomReserved>";
							echo $row['roomReserved'];
						echo "</roomReserved>";
					echo "</room>";
				}
			}
		}
		function functionRoomTransactions($payment_amount,$protection_eligibility,$address_status,$payer_id,$tax,$address_street,$payment_date,$payment_status,$charset,$address_zip,$first_name,$option_selection1,$mc_fee,$address_country_code,$address_name,$notify_version,$custom,$payer_status,$address_country,$address_city,$quantity,$verify_sign,$payer_email,$option_name1,$txn_id,$payment_type,$btn_id,$last_name,$address_state,$receiver_email,$payment_fee,$shipping_discount,$insurance_amount,$receiver_id,$txn_type,$item_name,$discount,$mc_currency,$item_number,$residence_country,$test_ipn,$shipping_method,$handling_amount,$transaction_subject,$payment_gross,$shipping,$ipn_track_id){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("INSERT INTO  tblroomtransactions
			(mc_gross,protection_eligibility,address_status,payer_id,tax,address_street,payment_date,payment_status,charset,address_zip,first_name,option_selection1,mc_fee,address_country_code,address_name,notify_version,custom,payer_status,address_country,address_city,quantity,verify_sign,payer_email,option_name1,txn_id,payment_type,btn_id,last_name,address_state,receiver_email,payment_fee,shipping_discount,insurance_amount,receiver_id,txn_type,item_name,discount,mc_currency,item_number,residence_country,test_ipn,shipping_method,handling_amount,transaction_subject,payment_gross,shipping,ipn_track_id)
			VALUES('$payment_amount','$protection_eligibility','$address_status','$payer_id','$tax','$address_street','$payment_date','$payment_status','$charset','$address_zip','$first_name','$option_selection1','$mc_fee','$address_country_code','$address_name','$notify_version','$custom','$payer_status','$address_country','$address_city','$quantity','$verify_sign','$payer_email','$option_name1','$txn_id','$payment_type','$btn_id','$last_name','$address_state','$receiver_email','$payment_fee','$shipping_discount','$insurance_amount','$receiver_id','$txn_type','$item_name','$discount','$mc_currency','$item_number','$residence_country','$test_ipn','$shipping_method','$handling_amount','$transaction_subject','$payment_gross','$shipping','$ipn_track_id')") or die(mysql_error());
			mysql_query($SQLQuery);
		}
		function functionComment($name,$email_address,$phone,$message){
			$this->functionDBConnect();
			$dateToday = date('Y') . "-" . date('m') . "-" . date('d');
			$timeToday = date('h') . ":" . date('i') . ":" . date('s');
			$sql = "INSERT INTO tblcomments(
										commenterName,
										commenterEmail,
										commenterPhoneNumber,
										comment,
										commentDate,
										commentTime
										) VALUES(
												'$name',
												'$email_address',
												'$phone',
												'$message',
												'$dateToday',
												'$timeToday')";
			mysql_query($sql);
		}
	}
?>