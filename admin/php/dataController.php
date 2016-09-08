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
	$classDBRelatedFunctions->functionListUserData();
}else{
	//echo $row['roomName'];
	$classDBRelatedFunctions->functionReserve($_GET['roomID']);
	$classDBRelatedFunctions->functionListUserData();
	$classDBRelatedFunctions->functionListRoomData();
}

if($_GET['processID'] == "dashboard"){
	$classDBRelatedFunctions->functionListUserData();
	$classDBRelatedFunctions->functionListRoomData();
	$classDBRelatedFunctions->functionTabSession($_GET['processID']);
}elseif($_GET['processID'] == "roomTransactions"){
	$classDBRelatedFunctions->functionListUserData();
	$classDBRelatedFunctions->functionListRoomData();
	$classDBRelatedFunctions->functionTabSession($_GET['processID']);
}
//this(_get) comes from the javascript from the html
//$food = $_GET['food'];
echo '</response>';
?>