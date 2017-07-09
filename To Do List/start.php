<?php
	# Luke Seo
	# CSE 154 AO
	# HW 7 To-Do List
	# This file is associated with the To-Do List webpage. The purpose of
	# this file is to present the user with the login page where they can
	# input their username and password to proceed to their To Do List
	# if their inputs are valid.
	
	session_start();
	
	# This code checks to see if the user is already logged in, if they are
	# then they are redirected to their To-Do List page.
	if (!(empty($_SESSION["username"]) && empty($_SESSION["password"]))) {
		header("Location: todolist.php");
		die();
	}

	# This code includes the common.php file, then utilizes that
	# file to display the header.
	include ("common.php");
	displayHead();
?>
			<p>
				The best way to manage your tasks. <br />
				Never forget the cow (or anything else) again!
			</p>

			<p>
				Log in now to manage your to-do list. <br />
				If you do not have an account, one will be created for you.
			</p>

			<form id="loginform" action="login.php" method="post">
				<div><input name="name" type="text" size="8" autofocus="autofocus" /> <strong>User Name</strong></div>
				<div><input name="password" type="password" size="8" /> <strong>Password</strong></div>
				<div><input type="submit" value="Log in" /></div>
			</form>

			<p>
				<?php if (isset($_COOKIE["date"])) { ?>
					<em>(last login from this computer was <?= $_COOKIE["date"] ?>)</em>
				<?php } ?>
			</p>
	<?= displayFoot() ?>