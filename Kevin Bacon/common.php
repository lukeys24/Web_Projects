<?php
	# Luke Seo
	# CSE 154 AO
	# HW 8 Kevin Bacon
	# This file is associated with the Kevin Bacon webpage. The purpose of this
	# file is to capture common code that is present in the various pages for Kevin.

	# This function displays the header for all the pages.
	function displayHead() { ?>
		<!DOCTYPE html>
				<html>
					<head>
						<title>My Movie Database (MyMDb)</title>
						<meta charset="utf-8" />
						<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

						<link href="bacon.css" type="text/css" rel="stylesheet" />
					</head>

					<body>
						<div id="frame">
							<div id="banner">
								<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
								My Movie Database
							</div>
							<div id="main">
	<?php }

	# This function takes in a parameter $phrase as represents the title to
	# be displays on the page.
	function displayTitle($phrase) { ?>
							<h1><?= $phrase ?></h1>
	<?php }

	# This function takes in parameters that repesent a list of movies and
	# a caption then displays them in a table.
	function displayTable($actorMovies, $caption) { ?>
							<table>
								<caption><?= $caption ?></caption>
								<tr><th class="left" >#</th><th>Title</th><th class="right" >Year</th></tr>
		<?php
		$count = 1;
		foreach($actorMovies as $movies) { ?>
								<tr><td class="left"><?= $count ?></td><td><?= $movies["name"] ?></td>
								<td class="right"><?= $movies["year"] ?></td></tr>
		<?php
		$count++;
		} ?>
							</table>
	<?php }

	# This function displays on all pages two forms for the user's input and a footer.
	function displayFoot() { ?>
							<form action="search-all.php" method="get">
								<fieldset>
								<legend>All movies</legend>
									<div>
										<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
										<input name="lastname" type="text" size="12" placeholder="last name" /> 
										<input type="submit" value="go" />
									</div>
								</fieldset>
							</form>

							<form action="search-kevin.php" method="get">
								<fieldset>
									<legend>Movies with Kevin Bacon</legend>
									<div>
										<input name="firstname" type="text" size="12" placeholder="first name" /> 
										<input name="lastname" type="text" size="12" placeholder="last name" /> 
										<input type="submit" value="go" />
									</div>
								</fieldset>
							</form>
							</div>
							<div id="w3c">
								<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
								<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
							</div>
						</div>
					</body>
				</html>
	<?php }

	# This function returns the database and the actor's id who matched
	# best with the user inputted first and last name.
	function searchId() {
		$db = new PDO("mysql:dbname=imdb;charset=UTF8", "lukeys24", "mC88TyBLFo");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$firstName = $_GET["firstname"] . '%';
		$firstName = $db->quote($firstName);
		$lastName = $_GET["lastname"];
		$lastName = $db->quote($lastName);

		# Searches for the actor that best matches the user's input.
		$actorId = $db->query("SELECT id
							   FROM actors
							   WHERE last_name = $lastName
							   AND first_name LIKE $firstName
							   ORDER BY film_count DESC, id ASC
							   LIMIT 1");
		# If an actor wasn't found then the webpage displays a message otherwise
		# the database and id are returned.
		if ($actorId->rowCount() < 1) { ?>
			<p>Actor <?=$_GET["firstname"] . " " . $_GET["lastname"]?> not found</p>
		<?php } else {
			$row = $actorId->fetch();
			$id = $row["id"];
			$id = $db->quote($id);
			return array($db, $id);
		}
	}
?>