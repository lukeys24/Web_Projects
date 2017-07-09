<?php
	# Luke Seo
	# CSE 154 AO
	# HW 8 Kevin Bacon
	# This file displays the Kevin Bacon webpage when the user searched for
	# an actor that has been in a movie with Kevin Bacon.

	include("common.php");
	# Displays the header of the webpage by utilizing the common.php
	displayHead();
	$arr = searchId();

	# Takes in parameters to see if an actor was found, if so then
	# it displays a table of similar movies with Kevin, but if
	# none are found then a message is displayed.
	if (count($arr) == 2) {
		$db = $arr[0];
		$id = $arr[1];

		# Searches for the similar movies with Kevin.
		$commonMovies = $db->query("SELECT m.name, m.year
									FROM movies m 
									JOIN roles r1 ON r1.movie_id = m.id
									JOIN actors a1 ON a1.id = r1.actor_id
									JOIN roles r2 ON r2.movie_id = m.id
									JOIN actors a2 ON a2.id = r2.actor_id
									WHERE a1.id = $id
									AND a2.first_name = 'Kevin'
									AND a2.last_name = 'Bacon'
									ORDER BY m.year DESC, m.name ASC");

		$name = $_GET["firstname"] . " " . $_GET["lastname"];
		# Displays a message that the actors wasn't in a movie with Kevin
		# otherwise displays a table of the similar movies.
		if ($commonMovies->rowCount() < 1) { ?>
			<p id="none"><?= $name ?> wasn't in any films with Kevin Bacon.<p>
		<?php } else { 
			displayTitle("Results for $name");
			displayTable($commonMovies, "Films with $name and Kevin Bacon");
		}
	}
	# Displays the footer of the webpage by utilizing the common.php
	displayFoot();
?>