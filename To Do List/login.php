<?php
	# Luke Seo
	# CSE 154 AO
	# HW 7 To-Do List
	# This file is associated with the To-Do List webpage. The purpose of
	# this webpage is to validate whether the user submitted valid parameters
	# to continue to their To-Do List page.

	# This code decides whether to redirect the user based on the
	# parameters that are passed in. If the user is logged in already
	# then they will be redirected to their To-Do List, if there are
	# no parameters for a username/password then they will be redirected
	# back to the start.
	session_start();
	if (!(empty($_SESSION["username"]) && empty($_SESSION["password"]))) {
		redirectList();
	} else if (empty($_POST["name"]) || empty($_POST["password"])) {
		redirectStart();
	} else {
		# This code will use the passed parameters to decide where to
		# direct the user. If the username/password matches an existing
		# username/password, they will be redirected to their To-Do List.
		# If it's a valid username but invalid password then they will be
		# redirected to the start.
		$username = $_POST["name"];
		$password = $_POST["password"];
		if (!file_exists("users.txt")) {
			file_put_contents("users.txt", "");
		}
		$lines = file("users.txt", FILE_IGNORE_NEW_LINES);
		foreach ($lines as $line) {
			$split = explode(":", $line);
			if ($username == $split[0]) {
				if ($password == $split[1]) {
					startCookie();
					startSession($username, $password);
					redirectList();
				} else {
					redirectStart();
				}
			}
		}
		# This code checks to see if the parameter passed username and password
		# is valid to create a new login, if so then they will be redirected to
		# their To-Do List, otherwise they wil be redirected to the start.
		if (preg_match("/^[a-z][a-z\d]{2,7}$/", $username) && preg_match("/^[\d].{4,10}[^a-zA-Z\d]$/", $password)) {
			$append = $username . ":" . $password . "\n";
			file_put_contents("users.txt", $append, FILE_APPEND);
			startCookie();
			startSession($username, $password);
			redirectList();
		} else {
			redirectStart();
		}
	}

	# This function sets a cookie that expires in a week and represents the current time
	function startCookie() {
		setcookie("date", date("D y M d, g:i:s a"), time() + 60 * 60 * 24 * 7, "/");
	}

	# This function redirects the user to the start and exits the page
	function redirectStart() {
		header("Location: start.php");
		die();
	}

	# This function takes in parameters username and password then
	# begins a session, along with setting several session variables
	function startSession($username, $password) {
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		$_SESSION["time"] = $_COOKIE["date"];
	}

	# This function redirects the user to their To-Do list and
	# exits the page
	function redirectList() {
		header("Location: todolist.php");
		die();
	}
?>

