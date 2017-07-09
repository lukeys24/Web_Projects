<?php
	# Luke Seo
	# CSE 154 AO
	# HW 7 To-Do List
	# This file is associated with the To-Do List webpage. The purpose of
	# this file is to redirect the user to the start and end a session
	# if it exists.

	session_start();
	if (empty($_SESSION["username"]) && empty($_SESSION["password"])) {
		redirectStart();
	}
	session_destroy();
	session_regenerate_id(TRUE);
	redirectStart();

	# This function redirects the user to the start and exits the 
	# page
	function redirectStart() {
		header("Location: start.php");
		die();
	}
?>