<?php
	# Luke Seo
	# CSE 154 AO
	# HW 6
	# This file is the php file that is associated with the bestreads webpage
	# that displays various books and additional information when clicked on.
	# This file handles the data that is requested by the webpage.

	$type = $_GET["mode"];
	$book = $_GET["title"];

	# This function decides what data to gather and what function to
	# call based on the parameters passed in. 
	if ($type == "description") {
		$description = file_get_contents("books/$book/$type.txt");
		descriptionTXT($description);
	} else if ($type == "reviews") {
		$reviews = glob("books/$book/review*.txt");
		reviewsHTML($reviews);
	} else if ($type == "info") {
		$info = file("books/$book/info.txt");
		infoJSON($info);
	} else if ($type == "books") {
		$differentDirec = glob("books/*/info.txt");
		$differentNameDirect = glob("books/*");
		booksXML($differentDirec, $differentNameDirect);
	}

	# This function takes in the parameter $lines that represents the information
	# of a specific book, then prints out the data in JSON format.
	function infoJSON($lines) {
		$data = array(
				"title" => $lines[0],
				"author" => $lines[1],
				"stars" => $lines[2]
		);
		header("Content-type: application/json");
		print (json_encode($data));
	}

	# This function takes in the parameter $lines which represents the description
	# of the specific book and then prints it out in plain text format.
	function descriptionTXT($lines) {
		header("Content-type: text/plain");
		print $lines;
	}

	# This function takes in the parameter $files which represents various reviews
	# for a specific book, then outputs it into HTML format.
	function reviewsHTML($files) {
		foreach ($files as $file) {
			$text = file($file);
			$name = $text[0];
			$rating = $text[1];
			$review = array_slice($text, 2);

			header("Content-type: text/html");
			
			?>
			<h3><?= $name ?><span><?= $rating ?></span></h3>
			<p><?= implode(" ", $review) ?></p>
			<?php
		}
	}

	# This function takes in parameters $allDirecs and #folderDirec which represents
	# the all the information files and their respective folder directory. It then
	# creates an XML formatted data that contains each books name and folder location.
	function booksXML($allDirecs, $folderDirec) {

		$xmldom = new DOMDocument();
		$books = $xmldom->createElement("books");
		$xmldom->appendChild($books);

		foreach ($allDirecs as $certainFile) {

			$bookChild = $xmldom->createElement("book");
			$books->appendChild($bookChild);

			$title = $xmldom->createElement("title");
			$title->nodeValue = file($certainFile)[0];
			$bookChild->appendChild($title);

			$theName = dirname($certainFile);
			$base = basename($theName);
			$folder = $xmldom->createElement("folder");
			$folder->nodeValue = $base;
			$bookChild->appendChild($folder);
		}

		header("Content-type: text/xml");	
		print $xmldom->saveXML();

	}
?>
