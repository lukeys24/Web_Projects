<?php
	# Luke Seo
	# CSE 154 AO
	# HW 7 To-Do List
	# This file is associated with the To-Do List webpage. The purpose of
	# this file is to capture any redundant HTML code that is displayed
	# across the different webpages for To-Do List.

	# This function displays the header of the webapge that is present in the
	# login and todolist page.
	function displayHead() { ?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8" />
				<title>Remember the Cow</title>
				<link href="https://webster.cs.washington.edu/css/cow-provided.css" type="text/css" rel="stylesheet" />
				<link href="cow.css" type="text/css" rel="stylesheet" />
				<link href="https://webster.cs.washington.edu/images/todolist/favicon.ico" type="image/ico" rel="shortcut icon" />
			</head>

			<body>
				<div class="headfoot">
					<h1>
						<img src="https://webster.cs.washington.edu/images/todolist/logo.gif" alt="logo" />
						Remember<br />the Cow
					</h1>
				</div>
			<div id="main">
<?php }
	
	# This function displays the footer of the webpage that is present in
	# the two different webpages for To-Do List.
	function displayFoot() { ?>
		</div>
		<div class="headfoot">
			<p>
				<q>Remember The Cow is nice, but it's a total copy of another site.</q> - PCWorld<br />
				All pages and content &copy; Copyright CowPie Inc.
			</p>

			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php">
					<img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php">
					<img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
		</div>
		</body>
		</html>
	
<?php } ?>