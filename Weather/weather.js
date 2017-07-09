// Luke Seo
// CSE 154 AO
// HW 5
// This file is the javascript file that handles the weather.html
// webpage which displays weather for a specific city the user
// types in

(function() {
	"use strict";
	var days;

	window.onload = function() {
		document.getElementById("citiesinput").disabled = true;
		document.getElementById("graph").style.display = "none";
		document.getElementById("resultsarea").style.display = "none";
		document.getElementById("search").onclick = cityInfo;
		document.getElementById("temp").onclick = tempClick;
		document.getElementById("precip").onclick = precipClick;
		document.getElementById("slider").onchange = changeTemp;
		getCities();
	};

	// This function takes in two parameters for the URL extension
	// and city. It calls an ajax request and calls a function
	// depending on the extend
	function sendRequest(extend, city) {
		var ajax = new XMLHttpRequest();
		if (extend == "cities") {
			ajax.onload = fetchCities;
		} else if (extend == "oneday&city=") {
			ajax.onload = printInfo;
		} else if (extend == "week&city=") {
			ajax.onload = printForecast;
		}
		ajax.open("GET", "https://webster.cs.washington.edu/cse154/weather.php?mode=" + extend + city, true);
		ajax.send();
	}

	// This function checks for errors generates the date, location, temperature, 
	// description and precipitation table.
	function printInfo() {

		// Generates the date, location and city description
		checkError(this);
		days = this.responseXML.querySelectorAll("time");
		var locationDiv = document.getElementById("location");
		var location = 	this.responseXML.querySelector("name").textContent;
		var description = days[document.getElementById("slider").value].
			querySelector("symbol").getAttribute("description");
		var insertData = [location, Date(), description];
		for (var i = 0; i < insertData.length; i++) {
			var insert = document.createElement("p");
			insert.innerHTML = insertData[i];
			if (insertData[i] == location) {
				insert.className = "title";
			}
			locationDiv.appendChild(insert);
		}
		document.getElementById("loadinglocation").style.display = "none";

		// Generates the precipitation table
		var parentTable = document.getElementById("graph");
		var table = document.createElement("tr");
		parentTable.appendChild(table);
		for (var i = 0; i < days.length; i++) {
			var addRow = document.createElement("td");
			var addDiv = document.createElement("div");
			var chanceRain = days[i].querySelector("clouds").getAttribute("chance");
			addDiv.innerHTML = chanceRain;
			addDiv.style.height = chanceRain + "px";
			addRow.appendChild(addDiv);
			table.appendChild(addRow);
		}
		document.getElementById("loadinggraph").style.display = "none";

		changeTemp();
	}

	// This function generates the seven day forecast
	// and also checks for errors
	function printForecast() {
		checkError(this);
		var data = JSON.parse(this.responseText);
		var forecast = document.getElementById("forecast");
		for (var i = 0; i < 2; i++) {
			var table = document.createElement("tr");
			forecast.appendChild(table);
			for (var j = 0; j < data.weather.length; j++) {
				var row = document.createElement("td");
				table.appendChild(row);
				if (i == 0) {
					var weatherIcon = document.createElement("img");
					weatherIcon.src = "https://openweathermap.org/img/w/" + data.weather[j].icon + ".png";
					row.appendChild(weatherIcon);
				} else {
					var temperature = document.createElement("div");
					temperature.innerHTML = Math.round(data.weather[j].temperature) + "&#176";
					row.appendChild(temperature);
				}
			}
		}
		document.getElementById("loadingforecast").style.display = "none";
	}

	// This function generates the list of various
	// cities.
	function fetchCities() {
		checkError(this);
		var text = this.responseText.split("\n");
		for (var i = 0; i < text.length; i++) {
			var option = document.createElement("option");
			option.innerHTML = text[i];
			document.getElementById("cities").appendChild(option);
		}
		document.getElementById("loadingnames").style.display = "none";
		document.getElementById("citiesinput").disabled = false;
	}

	function cityInfo() {
		clearAndShow();
		var city = document.getElementById("citiesinput").value;
		city = city.replace(/ /g, "");
		sendRequest("oneday&city=", city);
		sendRequest("week&city=", city);
	}

	// This function makes three of the gifs visible
	// and clears various elements of their child nodes
	function clearAndShow() {
		var loadingGifs = document.getElementsByClassName("loading");
		for (var i = 1; i < loadingGifs.length; i++) {
			loadingGifs[i].style.display = "block";
		}
		document.getElementById("resultsarea").style.display = "block";
		document.getElementById("location").innerHTML = "";
		document.getElementById("graph").innerHTML = "";
		document.getElementById("forecast").innerHTML = "";
	}

	function getCities() {
		var loadingGifs = document.getElementsByClassName("loading");
		for (var i = 1; i < loadingGifs.length; i++) {
			loadingGifs[i].style.display = "none";
		}
		sendRequest("cities", "");
	}

	// This function takes in a parameter ajax, checks for
	// any status errors and displays certain text based on the error.
	// It also displays/hides certain elements based on if there was an error
	function checkError(ajax) {
		if (ajax.status != "200") {
			if (ajax.status != "410") {
				document.getElementById("errors").innerHTML = "Error Message: " + ajax.statusText;
			}
			var loadingGifs = document.getElementsByClassName("loading");
			for (var i = 0; i < loadingGifs.length; i++) {
				loadingGifs[i].style.display = "none";
			}
			if (ajax.status == "410") {
				document.getElementById("nodata").style.display = "block";
			}
			document.getElementById("currentTemp").style.display = "none";
			document.getElementById("slider").style.display = "none";
			document.getElementById("buttons").style.display = "none";
		} else {
			document.getElementById("nodata").style.display = "none";
			document.getElementById("currentTemp").style.display = "block";
			document.getElementById("slider").style.display = "block";
			document.getElementById("buttons").style.display = "block";
		}
	}

	// Changes the temperature displayed on the page
	function changeTemp() {
		var temperature = Math.round(days[document.getElementById("slider").value].
			querySelector("temperature").textContent);
		document.getElementById("currentTemp").innerHTML = temperature + "&#8457";	
	}

	function precipClick() {
		document.getElementById("graph").style.display = "block";
		document.getElementById("slider").style.display = "none";
	}

	function tempClick() {
		document.getElementById("graph").style.display = "none";
		document.getElementById("slider").style.display = "block";
	}

})();