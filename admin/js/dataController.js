// JavaScript Document

//creates xmlhttps object
var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject(){
	var xmlHttp;
	//tests if using ie
	if(window.XMLHttpRequest){
		try{
			xmlHttp = new XMLHttpRequest(); //XMLHttpRequest() is a built in function
		}catch(error){
			xmlHttp = false;
		}
	}else{
		try{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");//XMLHttpRequest() is a built in function
		}catch(error){
			xmlHttp = false;
		}
	}
	if(!xmlHttp){
		alert("xmlHttp error, cant create that object");
	}else{
		//returns to the global xmlHttp since it is equal to this function
		return xmlHttp; //core of ajax that can be able to communicate with the server
	}
}

//communicates with the server or sends request
//sends request to a server
//this function is taking xmlHttp object and sends a request to the server and loads as soon as the page loads
function process(roomID,processID){
	//always tests state of 4 or 0 for server states
	if((xmlHttp.readyState == 4)/*completed*/ || (xmlHttp.readyState == 0)/*uninitialized*/){
		try{
			//parameters: type of request(GET OR POST),address or what is going to be sent to the phpfile(url) + variable,boolean if wanted to handle asychronously or not
			//not connected to server yet
			//this configures connection to server
			/*
			 another example here is when you'll get something or a value from the html file then send it to the php on the server for processing

			 //alert(xmlHttp.readyState);
			 //food is variable
			 food = encodeURIComponent(document.getElementById("userInput").value);
			 //alert(food);
			 //parameters: type of request(GET OR POST),address or what is going to be sent to the phpfile(url) + variable,boolean if wanted to handle asychronously or not
			 xmlHttp.open("GET","./php/foodstore.php?food="+food,true);
			 */
			if(processID == 'dashboard'){
				document.getElementById("dashboardTab").className = "";
				document.getElementById("dashboardTab").className = "active";
				document.getElementById("roomTransactionsTab").className = "";
				xmlHttp.open("GET","./php/dataController.php?roomID="+roomID+"&processID="+processID,true);
			}else if(processID == 'roomTransactions'){
				document.getElementById("roomTransactionsTab").className = "";
				document.getElementById("roomTransactionsTab").className = "active";
				document.getElementById("dashboardTab").className = "";
				xmlHttp.open("GET","./php/dataController.php?roomID="+roomID+"&processID="+processID,true);
			}else{
				xmlHttp.open("GET","./php/dataController.php?roomID="+roomID+"&processID="+processID,true);
			}

			//handles response that the server gives when requested upon; handleServerResponse is another function?
			//this is when a response from the server is recieved
			//response when state is changed
			xmlHttp.onreadystatechange = handleServerResponse;
			//sends the request; why null? because of get. but the parameters will change if _POST is used
			xmlHttp.send(null);
		}catch(error){
			alert(error.toString());
		}
	}else{
		//if the previous object is busy then pauses then waits then tries again
		setTimeout('process()',500);
	}
}
/*
 readyState 	Holds the status of the XMLHttpRequest. Changes from 0 to 4:
 0: request not initialized
 1: server connection established
 2: request received
 3: processing request
 4: request finished and response is ready
 status 	200: "OK"
 404: Page not found
 */

/*
 another example here is when you'll get something or a value from the html file then send it to the php on the server for processing
 this can varry
 //alert(xmlHttp.readyState);
 //food is variable
 food = encodeURIComponent(document.getElementById("userInput").value);
 //alert(food);
 //parameters: type of request(GET OR POST),address or what is going to be sent to the phpfile(url) + variable,boolean if wanted to handle asychronously or not
 xmlHttp.open("GET","./php/foodstore.php?food="+food,true);
 */
function handleServerResponse(){
	//google chrome ignores state 1
	/*
	 if(xmlHttp.readyState == 1){
	 theD.innerHTML += "Status 1: server connection established<br>";
	 }else if(xmlHttp.readyState == 2){
	 theD.innerHTML += "Status 2: server recieved the request<br>";
	 }else if(xmlHttp.readyState == 3){
	 theD.innerHTML += "Status 3: server is processing the request<br>";
	 }else if(xmlHttp.readyState == 4){
	 if(xmlHttp.status==200){
	 //checks status of the object for communication is 200 then communication went okay
	 try{
	 text = xmlHttp.responseText;
	 theD.innerHTML += "Status 4: request finished and response is ready<br>";
	 theD.innerHTML += text;
	 }catch(error){
	 alert(error.toString());
	 }
	 }else{
	 alert(xmlHttp.statusText);
	 }
	 }else{
	 alert("something went wrong");

	 }
	 */
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status==200){
			//checks status of the object for communication is 200 then communication went okay
			try{
				handleResponse();
			}catch(error){
				//alert("abmkss" + error.toString());
			}
		}else{
			//alert(xmlHttp.statusText);
		}
	}else{
		//alert("something went wrong, ready state = " + xmlHttp.readyState);

	}
}

//handles the response from the server
function handleResponse(){
	var xmlResponse = xmlHttp.responseXML;
	root = xmlResponse.documentElement;
	roomID = root.getElementsByTagName("roomID");
	roomName = root.getElementsByTagName("roomName");
	roomTotal = root.getElementsByTagName("roomTotal");
	roomVacancy = root.getElementsByTagName("roomVacancy");
	roomOccupied = root.getElementsByTagName("roomOccupied");
	roomReserved = root.getElementsByTagName("roomReserved");
	userID = root.getElementsByTagName("userID");
	userName = root.getElementsByTagName("userName");
	userFirstName = root.getElementsByTagName("userFirstName");
	userLastName = root.getElementsByTagName("userLastName");
	userLevel = root.getElementsByTagName("userLevel");
	//alert("ADF");
	/*
	 var information = "";
	 for (i = 0; i < names.length; i++) {
	 information += names.item(i).firstChild.data + " - " + ssn.item(i).firstChild.data + "<br>";
	 }
	 theD = document.getElementById("theD");
	 theD.innerHTML = information;
	 */

	setTimeout('process()',10000);
	var roomdatax = "";
	for (i = 0; i < roomID.length; i++) {
		if(roomVacancy.item(i).firstChild.data == 1){
			var roomVacancyx = "Vacant";
		}else{
			var roomVacancyx = "Occupied";
		}

		if(roomReserved.item(i).firstChild.data == 1){
			var roomReservedx = "Reserved";
		}else{
			var roomReservedx = "Available";
		}

		//roomdatax += "<tr>" + "<td>" + "<input type='checkbox' value='roomID.item(i).firstChild.data'/>" + "</td>" + "<td>" + roomID.item(i).firstChild.data + "</td>" + "<td>" + roomName.item(i).firstChild.data + "</td>" + "<td>" + roomVacancyx + "</td>"  + "<td>" + roomReservedx + "</td>"  + "</tr>";
	}

	//var tableBodyStart = '<table id="example1" class="table table-bordered table-hover table-striped table-mailbox"><thead><tr><th><input type="checkbox" id="check-all"/></th><th>Room ID</th><th>Room Name</th><th>Room Vacany</th><th>Room Reservation</th></tr></thead><tbody>';
	//var tableBodyEnd = '</table>';



	//document.getElementById("mainContent").innerHTML = tableBodyStart + roomdatax + tableBodyEnd;


	document.getElementById("userFirstLastName").innerHTML = userFirstName.item(0).firstChild.data + " " + userLastName.item(0).firstChild.data;
	document.getElementById("userFirstLastNameLeft").innerHTML = userFirstName.item(0).firstChild.data + " " + userLastName.item(0).firstChild.data;
	document.getElementById("userFirstLastNameDropDown").innerHTML = userFirstName.item(0).firstChild.data + " " + userLastName.item(0).firstChild.data;

	if(userLevel.item(0).firstChild.data == 1){
		document.getElementById("userLevelDropDown").innerHTML = "Admin";
	}


}