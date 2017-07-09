<?php
	# Luke Seo
	# CSE 154 AO
	# HW 8 Kevin Bacon
	# This file is the Kevin Bacon webpage that displays the main page
	# that includes a pictures of Kevin and the two inputs for the user to search.

	include("common.php");
	# Displays the header of the webpage by utilizing the common.php
	displayHead();
	displayTitle("The One Degree of Kevin Bacon");
?>
	<p>Type in an actor's name to see if he/she was ever in a movie with Kevin Bacon!</p>
	<p><img src="https://webster.cs.washington.edu/images/kevinbacon/kevin_bacon.jpg" 
		alt="Kevin Bacon" /></p>

<?php
	# Displays the footer of the webpage by utilizing the common.php
	displayFoot();
?>
