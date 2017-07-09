// Luke Seo
// CSE 154 AO
// HW 6
// This file is the javascript file associated with the bestreads webpage that
// displays several different books along with more information when the
// book is clicked on.

(function() {
	"use strict";

	// This function runs when the window loads and sets a couple
	// initial characteristics, behaviors and then calls a function
	// to display the intial state of the page.
	window.onload = function() {
		document.getElementById("singlebook").style.display = "none";
		document.getElementById("back").onclick = displayImages;
		displayImages();
	};

	// This function takes in parameters of type and book that represents
	// parameters to be passed into the ajax request. The ajax request
	// will run a function based on the parameter type.
	function sendRequest(type, book) {
		var ajax = new XMLHttpRequest();

		if (type == "books") {
			ajax.onload = fetchImages;
		} else if (type == "description") {
			ajax.onload = fetchDescription;
		} else if (type == "reviews") {
			ajax.onload = fetchReviews;
		} else if (type == "info") {
			ajax.onload = fetchInfo;
		}

		ajax.open("GET", "https://webster.cs.washington.edu/students/lukeys24/hw6/bestreads.php?mode=" +
			type + "&title=" + book, true);
		ajax.send();
	}

	// This function uses the ajax response and converts it into XML
	// format to create the image and title of the various books.
	function fetchImages() {
		var allBooks = this.responseXML.querySelectorAll("book");

		// This forloop creates the image and titles that will be displayed
		// on the bestreads webpage along with behavior on when clicked.
		for (var i = 0; i < allBooks.length; i++) {
			var newDiv = document.createElement("div");
			var insideDivTitle = document.createElement("p");
			var imageBook = document.createElement("img");
			var bookName = allBooks[i].querySelector("folder").textContent;

			insideDivTitle.innerHTML = allBooks[i].querySelector("title").textContent;
			imageBook.src = "books/" + bookName + "/cover.jpg";
			
			insideDivTitle.onclick = clicked;
			imageBook.onclick = clicked;

			imageBook.id = bookName;
			insideDivTitle.id = bookName;

			newDiv.appendChild(imageBook);
			newDiv.appendChild(insideDivTitle);
			
			document.getElementById("allbooks").appendChild(newDiv);
		}
	}

	// This function displays the description for a specific book
	function fetchDescription() {
		document.getElementById("description").innerHTML = this.responseText;
	}

	// This function displays the various reviews that will be displayed
	// for a specific book
	function fetchReviews() {
		document.getElementById("reviews").innerHTML = this.responseText;
	}

	// This function displays the title, author and stars for a specific
	// book. The data used is processed in JSON format.
	function fetchInfo() {
		var data = JSON.parse(this.responseText);
		var title = data.title;
		var author = data.author;
		var stars = data.stars;
		document.getElementById("title").innerHTML = title;
		document.getElementById("author").innerHTML = author;
		document.getElementById("stars").innerHTML = stars;
	}

	// This function resets various elements when a specific element
	// is clicked, displays an image for a specific book and sends requests
	// for the description, reviews and book information to be displayed
	function clicked() {
		document.getElementById("allbooks").innerHTML = "";
		document.getElementById("singlebook").style.display = "block";
		document.getElementById("cover").src = "books/" + this.id + "/cover.jpg";

		sendRequest("description", this.id);
		sendRequest("reviews", this.id);
		sendRequest("info", this.id);
	}

	// This function sets the singlebook element to no display and
	// sends a request to display all books.
	function displayImages() {
		document.getElementById("singlebook").style.display = "none";
		sendRequest("books", "");
	}

})();