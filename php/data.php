<?php
	include("./DBConfigs.php");
	$classDBRelatedFunctions = new classDBRelatedFunctions;
	//generates xml contents from php
	header("Content-type: text/xml");
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";
	//this displays to the html
	echo '<response>';
		if((!isset($_GET['roomID']))or($_GET['roomID'] == 0)){
			//echo "undefiend or null";
			$classDBRelatedFunctions->functionListRoomData();
		}elseif($_GET['roomID'] == 315131351420) {
			$name = $_GET['name'];
			$email_address = $_GET['email'];
			$phone = $_GET['phone'];
			$message = $_GET['message'];
			$classDBRelatedFunctions->functionComment($name,$email_address,$phone,$message);
			$classDBRelatedFunctions->functionListRoomData();
		}else{
			$classDBRelatedFunctions->functionReserve($_GET['roomID']);
			$classDBRelatedFunctions->functionListRoomData();
		}
	echo '</response>';
?>