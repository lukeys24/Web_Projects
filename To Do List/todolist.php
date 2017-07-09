<?php
	# Luke Seo
	# CSE 154 AO
	# HW 7 To-Do List
	# This file is associated with the To Do List webpage. The purpose of this
	# webpage is to present the user with their To Do List, ability to log out,
	# add and delete items from their list.

	session_start();
	include ("common.php");
	# Redirects user to the start if they are not logged in.s
	if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
		header("Location: start.php");
		die();
	}
	# Displays the header of the webpage by utilizing the common.php
	displayHead();
?>
	<h2><?= $_SESSION["username"] ?>'s To-Do List</h2>

	<ul id="todolist">
		<?php
		# Generates the To Do List of the current user line by line.
		if (file_exists("todo_" . $_SESSION["username"] . ".txt")) {
			$lines = file("todo_" . $_SESSION["username"] . ".txt", FILE_IGNORE_NEW_LINES);
			for ($i = 0; $i < count($lines); $i++) { ?>
				<li>
					<form action="submit.php" method="post">
						<input type="hidden" name="action" value="delete" />
						<input type="hidden" name="index" value="<?= $i ?>" />
						<input type="submit" value="Delete" />
					</form>
					<?= htmlspecialchars($lines[$i]) ?>
				</li>
		<?php }} ?>

		<li>
			<form action="submit.php" method="post">
				<input type="hidden" name="action" value="add" />
				<input name="item" type="text" size="25" autofocus="autofocus" />
				<input type="submit" value="Add" />
			</form>
		</li>
	</ul>

	<div>
		<a href="logout.php"><strong>Log Out</strong></a>
		<em>(logged in since <?= $_COOKIE["date"] ?>)</em>
	</div>
<?= displayFoot() ?>