<?php
	# Luke Seo
	# CSE 154 AO
	# HW 8 Kevin Bacon
	# This file is the Kevin Bacon webpage that displays all the actor's
	# movies or a message that the actor wasn't found.

	include("common.php");
	# Displays the header of the webpage by utilizing the common.php
	displayHead();
	$arr = searchId();

	# Checks to see if the actor was found, if so then all of the actor's
	# movies are displayed in a sorted table.
	if (count($arr) == 2) {
		$db = $arr[0];
		$id = $arr[1];

		# Searches for the movies
		$actorMovies = $db->query("SELECT m.name, m.year
								   FROM movies m
								   JOIN roles r ON r.movie_id = m.id
								   JOIN actors a ON a.id = r.actor_id
								   WHERE a.id = $id
								   ORDER BY m.year DESC, m.name ASC");
		# Displays the table of movies.
		displayTitle("Results for " . $_GET["firstname"] . " " . $_GET["lastname"]);
		displayTable($actorMovies, "All Films");
	}
	# Displays the footer of the webpage by utilizing the common.php
	displayFoot();
?>