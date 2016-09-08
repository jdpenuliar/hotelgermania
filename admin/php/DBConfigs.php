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
		function functionDBDisconnect(){
			mysql_close($this->functionDBConnect());
		}
		function functionGenerateSalt(){
			return dechex(mt_rand(0,2147483647)).(mt_rand(0,2147483647));
		}
		function functionGenerateConfirmCode(){
			return dechex(mt_rand(0,2147483647)).(mt_rand(0,2147483647));
		}
		function functionCheckUserName($userName){
			$codeResult = mysql_query("SELECT * FROM tbluser WHERE username='$userName'" );
			return mysql_num_rows($codeResult)? 1 : 0;
		}
		function functionCheckFileID($checkFileID){
			$codeResult = mysql_query("SELECT * FROM tblfile WHERE fileID='$checkFileID'" );
			return mysql_num_rows($codeResult)? 1 : 0;
		}
		function functionCheckUserID($userID){
			$codeResult = mysql_query("SELECT * FROM tbluser WHERE userID='$userID'" );
			return mysql_num_rows($codeResult)? 1 : 0;
		}
		function functionCheckPasswordSignUp($passWord1,$passWord2){
			if($passWord1 == $passWord2){
				return true;
			}else{
				return false;
			}
		}
		function functionEncryptPassword($password,$salt){
			$hashedPassword = hash('sha256',$password.$salt);
			for($round = 0; $round < 65536; $round++ ){
				$hashedPassword = hash('sha256',$hashedPassword.$salt);
			}
			return $hashedPassword;
		}
		function functionUserSignup($userID, $userName, $userPassword, $userPasswordReType, $userLevel, $userAccountStatus, $userFirstName,$userLastName){
			$this->functionDBConnect();
			$salt = $this->functionGenerateSalt();
			if($this->functionCheckUserID($userID) == 1){
				$this->errorMessage = "UserID Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckUserName($userName) == 1){
				$this->errorMessage = "Username Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckPasswordSignUp($userPassword,$userPasswordReType) == false){
				$this->errorMessage = "Password Unmatch!";
				$this->functionError();
			}else{
				$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
			}



			$dateToday = date('Y') . "-" . date('m')  . "-" . date('d');
			$SQLQuery = "INSERT INTO tbluser
			(userID, userName, userPassword, salt, userFirstName, userLastName, userLevel, userAccountStatus, userRegistrationDate, userStorageCapacity)			VALUES('$userID', '$userName', '$encryptedPassword', '$salt', '$userFirstName', '$userLastName', '$userLevel', '$userAccountStatus', '$dateToday', '$userStorageCapacity')";
			if (!mysql_query($SQLQuery,$this->functionDBConnect()))
			{
				die ('Error: ' . mysql_error());
			}

		}
		function functionGetPasswordFromDB($userName){
			$result = mysql_query("SELECT * FROM tbluser WHERE username='$userName'");
			while($row=mysql_fetch_array($result)){
				$this->saltFromDB	= $row['salt'];
				$this->passwordFromDB = $row['userPassword'];
			}
		}
		function functionUserAuthentication($username,$password){
			$this->functionDBConnect();
			if($this->functionCheckUserName($username) == 0){
				$this->errorMessage = "Username Unavailable!";
				$this->functionError();
				echo "<script>
						alert(\"$this->errorMessage\");
					</script>";
			}
			$this->functionGetPasswordFromDB($username);
			$loginSalt = $this->saltFromDB;
			$newEncryptedPassword = $this->functionEncryptPassword($password,$loginSalt);
			$encrypt = $this->passwordFromDB;
			if($this->functionCheckPasswordSignUp($encrypt,$newEncryptedPassword) == true){

				$result = mysql_query("SELECT * FROM tbluser WHERE userName='$username' and userPassword='$newEncryptedPassword'");
				while($row = mysql_fetch_array($result))
				{
					$userID = $row['userID'];
					$userName = $row['userName'];
					$userPassword = $row['userPassword'];
					$userLevel = $row['userLevel'];
					$userFirstName = $row['userFirstName'];
					$userLasttName = $row['userLastName'];
				}
				if(!empty($userID)){
					$_SESSION['userID'] = $userID;
					$_SESSION['userName'] = $userName;
					$_SESSION['userPassword'] = $userPassword;
					$_SESSION['userLevel'] = $userLevel;
					$_SESSION['userFirstName'] = $userFirstName;
					$_SESSION['userLastName'] = $userLasttName;
					$_SESSION['pagePasser'] = 1;
					$_SESSION['counter'] = "0";

					//header("Location: ../");
				}else{
					$this->errorMessage = "UserName and password does not match!";
					$this->functionError();
					echo "
						<script>
							alert(\"$this->errorMessage\");
						</script>
					";
				}
			}else{
				$this->errorMessage = "UserName and password does not match!";
				$this->functionError();
				echo "
					<script>
						alert(\"$this->errorMessage\");
					</script>
				";
			}
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
		function functionListUserData(){
			session_start();
			$userID = $_SESSION['userID'];
			$this->functionDBConnect();
			$SQLQuery = mysql_query("SELECT * FROM tbluser WHERE userID = '$userID'") or die(mysql_error());
			if (mysql_num_rows($SQLQuery) > 0) {
				while ($row = mysql_fetch_array($SQLQuery)) {
					echo "<userData>";
						echo "<userID>";
							echo $row['userID'];
						echo "</userID>";
						echo "<userName>";
							echo $row['userName'];
						echo "</userName>";
						echo "<userFirstName>";
							echo $row['userFirstName'];
						echo "</userFirstName>";
						echo "<userLastName>";
							echo $row['userLastName'];
						echo "</userLastName>";
						echo "<userLevel>";
							echo $row['userLevel'];
						echo "</userLevel>";
					echo "</userData>";
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

		function functionOccupyRoom($roomID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblrooms SET roomVacancy = '0' WHERE roomID='$roomID'") or die(mysql_error());
			mysql_query($SQLQuery);
			$SQLQuery = mysql_query("UPDATE tblrooms SET roomUse = roomUse + 1 WHERE roomID='$roomID'") or die(mysql_error());
			mysql_query($SQLQuery);

		}
		function functionVacantRoom($roomID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblrooms SET roomVacancy = '1' WHERE roomID='$roomID'") or die(mysql_error());
			mysql_query($SQLQuery);
		}

		function functionTabSession($tab){
			session_start();
			$_SESSION['tabPage'] = $tab;
		}
		function functionUpdateUser($userID, $userName, $userPassword, $userFirstName, $userLastName, $userLevel, $userAccountStatus, $userRegistrationDate){

			/*$_SESSION['userIDx'] = $row['userID']; //license number
			$_SESSION['userNamex'] = $row['userName'];
			$_SESSION['userPasswordx'] = $row['userPassword'];
			$_SESSION['saltx'] = $row['salt'];
			$_SESSION['userLevelx'] = $row['userLevel'];
			$_SESSION['userAccountStatusx'] = $row['userAccountStatus'];
			$_SESSION['userRegistrationDatex'] = $row['userRegistrationDate'];
			$_SESSION['userFirstNamex'] = $row['userFirstName'];
			$_SESSION['userMiddleNamex'] = $row['userMiddleName'];
			$_SESSION['userLastNamex'] = $row['userLastName'];
			$_SESSION['DOBx'] = $row['DOB'];
			$_SESSION['genderx'] = $row['gender'];
			$_SESSION['addressx'] = $row['address'];
			$_SESSION['contactNumberx'] = $row['contactNumber'];*/
			$this->functionDBConnect();
			if(empty($userPassword) or $userPassword == " "){
				$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userLevel='$userLevel',
								userAccountStatus='$userAccountStatus',
								userRegistrationDate='$userRegistrationDate',
								userFirstName='$userFirstName',
								userLastName='$userLastName'
							WHERE userID='$userID'";
				if (!mysql_query($SQLQuery,$this->functionDBConnect()))
				{
					die ('Error: ' . mysql_error());
				}
				/*$SQLQuery = "UPDATE tbluser
				(userID, userName, userPassword, salt, userLevel, userAccountStatus, userRegistrationDate, userFirstName, userMiddleName, userLastName, DOB, gender, address, contactNumber)
				VALUES
				('$userID','$userName','$encryptedPassword','$salt','$userLevel','$userAccountStatus','$dateToday','$userFirstName','$userMiddleName','$userLastName','$DOBx','$gender','$address','$contactNumber')";*/

			}else{
				$salt = $this->functionGenerateSalt();
				$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);

				$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userPassword = '$encryptedPassword',
								salt = '$salt',
								userLevel='$userLevel',
								userAccountStatus='$userAccountStatus',
								userRegistrationDate='$userRegistrationDate',
								userFirstName='$userFirstName',
								userLastName='$userLastName'
							WHERE userID='$userID'";
				if (!mysql_query($SQLQuery,$this->functionDBConnect()))
				{
					die ('Error: ' . mysql_error());
				}
			}
		}
		function functionUpdateUserEditProfile($userID, $userName, $userPassword, $userReTypePassword, $userFirstName, $userLastName){

			/*$_SESSION['userIDx'] = $row['userID']; //license number
			$_SESSION['userNamex'] = $row['userName'];
			$_SESSION['userPasswordx'] = $row['userPassword'];
			$_SESSION['saltx'] = $row['salt'];
			$_SESSION['userLevelx'] = $row['userLevel'];
			$_SESSION['userAccountStatusx'] = $row['userAccountStatus'];
			$_SESSION['userRegistrationDatex'] = $row['userRegistrationDate'];
			$_SESSION['userFirstNamex'] = $row['userFirstName'];
			$_SESSION['userMiddleNamex'] = $row['userMiddleName'];
			$_SESSION['userLastNamex'] = $row['userLastName'];
			$_SESSION['DOBx'] = $row['DOB'];
			$_SESSION['genderx'] = $row['gender'];
			$_SESSION['addressx'] = $row['address'];
			$_SESSION['contactNumberx'] = $row['contactNumber'];*/
			$this->functionDBConnect();
			if(empty($userPassword) or $userPassword == " "){
				$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userFirstName='$userFirstName',
								userLastName='$userLastName'
							WHERE userID='$userID'";
				if (!mysql_query($SQLQuery,$this->functionDBConnect()))
				{
					die ('Error: ' . mysql_error());
				}
				/*$SQLQuery = "UPDATE tbluser
				(userID, userName, userPassword, salt, userLevel, userAccountStatus, userRegistrationDate, userFirstName, userMiddleName, userLastName, DOB, gender, address, contactNumber)
				VALUES
				('$userID','$userName','$encryptedPassword','$salt','$userLevel','$userAccountStatus','$dateToday','$userFirstName','$userMiddleName','$userLastName','$DOBx','$gender','$address','$contactNumber')";*/

			}else{
				$salt = $this->functionGenerateSalt();
				if($this->functionCheckPasswordSignUp($userPassword,$userReTypePassword) == false){
					$this->errorMessage = "Password Unmatch!";
					$this->functionError();
					exit;
				}else{
					$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
					$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userPassword = '$encryptedPassword',
								salt = '$salt',
								userFirstName='$userFirstName',
								userLastName='$userLastName'
							WHERE userID='$userID'";
					if (!mysql_query($SQLQuery,$this->functionDBConnect()))
					{
						die ('Error: ' . mysql_error());
					}
				}
			}

		}
		function functionAddUser($userID, $userName, $userPassword, $userPasswordReType, $userLevel, $userAccountStatus, $userFirstName,$userLastName){
			//echo $userID, $userName, $userPassword, $userPasswordReType, $userLevel, $userAccountStatus, $userFirstName, $userMiddleName,$userLastName,$DOBx,$gender,$address,$contactNumber;
			$this->functionDBConnect();
			$salt = $this->functionGenerateSalt();
			if($this->functionCheckUserID($userID) == 1){
				$this->errorMessage = "UserID Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckUserName($userName) == 1){
				$this->errorMessage = "Username Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckPasswordSignUp($userPassword,$userPasswordReType) == false){
				$this->errorMessage = "Password Unmatch!";
				$this->functionError();
			}else{
				$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
			}
			$dateToday = date('Y') . "-" . date('m')  . "-" . date('d'). " " . date('h')  . ":" . date('i'). ":" . date('s');
			$SQLQuery = "INSERT INTO tbluser
			(userID, userName, userPassword, salt, userFirstName, userLastName, userLevel, userAccountStatus, userRegistrationDate)
		VALUES
		('$userID','$userName','$encryptedPassword','$salt','$userFirstName','$userLastName','$userLevel','$userAccountStatus','$dateToday')";
			if (!mysql_query($SQLQuery,$this->functionDBConnect()))
			{
				die ('Error: ' . mysql_error());
			}


		}
	}
?>