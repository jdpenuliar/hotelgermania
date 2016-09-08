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
function process(roomID){
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
			if(roomID == 315131351420){
				var name = $("input#name").val();
				var email = $("input#email").val();
				var phone = $("input#phone").val();
				var message = $("textarea#message").val();
				//alert(roomID + " " + name + " " + email + " " + phone + " " + message);
				alert("Your comment has been recieved! We appreciate your feedback.");
				$("input#name").val("");
				$("input#email").val("");
				$("input#phone").val("");
				$("textarea#message").val("");

			}
			xmlHttp.open("GET","./php/data.php?roomID="+roomID+"&name="+name+"&email="+email+"&phone="+phone+"&message="+message,true);
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
				alert("abmkss" + error.toString());
			}
		}else{
			alert(xmlHttp.statusText);
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
	//alert("ADF");
	setTimeout('process()',1000);
	/*
	var information = "";
	for (i = 0; i < names.length; i++) {
		information += names.item(i).firstChild.data + " - " + ssn.item(i).firstChild.data + "<br>";
	}
	theD = document.getElementById("theD");
	theD.innerHTML = information;
	*/
	document.getElementById("roomVacancyAmountAquaThemeRoom").innerHTML = roomVacancy.item(0).firstChild.data;
	document.getElementById("roomVacancyBhudaThemeRoom").innerHTML = roomVacancy.item(1).firstChild.data;
	document.getElementById("roomVacancyBoracayThemeRoom").innerHTML = roomVacancy.item(2).firstChild.data;
	document.getElementById("roomVacancyRomanticThemeRoom").innerHTML = roomVacancy.item(3).firstChild.data;
	document.getElementById("roomVacancyMermaidThemeRoom").innerHTML = roomVacancy.item(4).firstChild.data;
	document.getElementById("roomVacancyStandardRoom01").innerHTML = roomVacancy.item(5).firstChild.data;
	document.getElementById("roomVacancyStandardRoom02").innerHTML = roomVacancy.item(6).firstChild.data;
	document.getElementById("roomVacancyStandardRoom03").innerHTML = roomVacancy.item(7).firstChild.data;
	document.getElementById("roomVacancyStandardRoom04").innerHTML = roomVacancy.item(8).firstChild.data;
	document.getElementById("roomVacancyStandardRoom05").innerHTML = roomVacancy.item(9).firstChild.data;
	document.getElementById("roomVacancyStandardRoom06").innerHTML = roomVacancy.item(10).firstChild.data;
	document.getElementById("apartmentVacancy1_1").innerHTML = roomVacancy.item(11).firstChild.data;
	document.getElementById("apartmentVacancy1_2").innerHTML = roomVacancy.item(11).firstChild.data;
	document.getElementById("apartmentVacancy1_3").innerHTML = roomVacancy.item(11).firstChild.data;
	document.getElementById("apartmentVacancy1_4").innerHTML = roomVacancy.item(11).firstChild.data;
	document.getElementById("apartmentVacancy2_1").innerHTML = roomVacancy.item(12).firstChild.data;
	document.getElementById("apartmentVacancy2_2").innerHTML = roomVacancy.item(12).firstChild.data;
	document.getElementById("apartmentVacancy2_3").innerHTML = roomVacancy.item(12).firstChild.data;
	document.getElementById("apartmentVacancy3_1").innerHTML = roomVacancy.item(13).firstChild.data;
	document.getElementById("apartmentVacancy3_2").innerHTML = roomVacancy.item(13).firstChild.data;
	document.getElementById("apartmentVacancy3_3").innerHTML = roomVacancy.item(13).firstChild.data;
	document.getElementById("apartmentVacancy4_1").innerHTML = roomVacancy.item(14).firstChild.data;
	document.getElementById("apartmentVacancy4_2").innerHTML = roomVacancy.item(14).firstChild.data;
	document.getElementById("apartmentVacancy4_3").innerHTML = roomVacancy.item(14).firstChild.data;
	document.getElementById("kuboVacancy1_01").innerHTML = roomVacancy.item(15).firstChild.data;
	document.getElementById("kuboVacancy1_02").innerHTML = roomVacancy.item(15).firstChild.data;
	document.getElementById("kuboVacancy1_03").innerHTML = roomVacancy.item(15).firstChild.data;
	document.getElementById("kuboVacancy1_04").innerHTML = roomVacancy.item(15).firstChild.data;
	document.getElementById("kuboVacancy1_05").innerHTML = roomVacancy.item(15).firstChild.data;
	document.getElementById("kuboVacancy1_06").innerHTML = roomVacancy.item(15).firstChild.data;
}