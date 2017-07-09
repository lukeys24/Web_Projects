<?php
	# Luke Seo
	# CSE 154 AO
	# HW 7 To-Do List
	# This file is associated with the To Do List webpage. The purpose of this
	# file is to use the passed parameters to decide whether to add or delete
	# from the user's To Do List. However if invalid conditions are met
	# then the program reacts accordingly.

	session_start();
	# Checks whether the user is logged in, if they aren't then
	# they are redirected to the start and exits this page.
	if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
		header("Location: start.php");
		die();
	} else if (empty($_POST["action"])) {
		# This code is executed when the passed parameter for action
		# is empty, therefore printing an error message.
		dieAlert();
	} else {
		if ($_POST["action"] == "delete") {
			$lines = file("todo_" . $_SESSION["username"] . ".txt", FILE_IGNORE_NEW_LINES);
			# Checks to see if the passed parameter index is invalid, if so then the user
			# will be presented an error message
			if (!is_numeric($_POST["index"]) || $_POST["index"] >= count($lines) || $_POST["index"] < 0) {
				dieAlert();
			} else {
				# Deletes an item off the list based on the parameter passed
				# index.
				unset($lines[$_POST["index"]]);
				file_put_contents("todo_" . $_SESSION["username"] . ".txt", "");
				foreach ($lines as $line) {
					file_put_contents("todo_" . $_SESSION["username"] . ".txt", $line . "\n", FILE_APPEND);
				}
			}
		} else if ($_POST["action"] == "add") {
			# Following code executes when the user wants to add an item to their To Do List.
			# If this is the first time a user has been to the site a new file containing their
			# list is created, otherwise it is appended to their current existing list.
			if (file_exists("todo_" . $_SESSION["username"] . ".txt")) {
				file_put_contents("todo_" . $_SESSION["username"] . ".txt",$_POST["item"] . "\n", FILE_APPEND);
			} else {
				file_put_contents("todo_" . $_SESSION["username"] . ".txt", $_POST["item"] . "\n");
			}
		}
	}
	# Redirects user to their To Do List
	header("Location: todolist.php");
	die();

	# This function prints an error message.
	function dieAlert() {
		print "Error Invalid Parameters";
		die();
	}
?>