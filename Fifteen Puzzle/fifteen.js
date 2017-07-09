// Luke Seo
// CSE 154 AO
// HW 4
// This file is the javascript file associated with the fifteen puzzle game,
// the puzzle is randomized with the shuffle button and congratulates the user when
// the squares are in their original state.
// The extra feature is the End of game notification

(function() {
	"use strict";

	var EMPTY_ROW = 3;
	var EMPTY_COL = 3;
	var NUMBER_ROWS_COLS = 4;
	var HEIGHT_WIDTH = 100;
	var originalPosition = [];

	window.onload = function() {
		createTiles();
		document.getElementById("shufflebutton").onclick = shuffleTiles;
	};

	// This function creates the tiles for the puzzle with one empty at the bottom right
	// corner, they're given properties so the user can interact with it when they click.
	function createTiles() {
		var tileCount = 1;
		for (var i = 0; i < NUMBER_ROWS_COLS; i++) {
			for (var j = 0; j < NUMBER_ROWS_COLS; j++) {
				if (tileCount != 16	) {
					var newTile = document.createElement("div");
					newTile.innerHTML = tileCount;
					newTile.style.backgroundPosition = -j * HEIGHT_WIDTH +
						 "px " + (-i * HEIGHT_WIDTH) + "px";
					newTile.style.left = j * HEIGHT_WIDTH + "px";
					newTile.style.top = i * HEIGHT_WIDTH + "px";
					newTile.className = "puzzleTiles";
					newTile.id = "tile_" + i + "_" + j;
					newTile.onclick = moveOneTile;
					newTile.onmouseover = onTile;
					newTile.onmouseout = offTile;
					document.getElementById("puzzlearea").appendChild(newTile);
					originalPosition.push(newTile.id);
					tileCount++;
				}
			}
		}
	}

	// This function adds a class to this tile when it is adjacent
	// to the empty square so it will change colors and cursors when it
	// is hovered.
	function onTile() {
		var spots = getRowAndCol(this);
		if (checkMove(spots[1], spots[2])) {
			this.classList.add("hoverTile");
		}
	}

	// This function removes the class that associates the tile with being
	// next to the empty tile.
	function offTile() {
		this.classList.remove("hoverTile");
	}

	// This function moves the current tile that is clicked to the empty
	// square spot then checks if the puzzle as been solved
	function moveOneTile() {
		var getIdSplit = getRowAndCol(this);
		if (checkMove(getIdSplit[1], getIdSplit[2])) {
			changeSpots(this, getIdSplit);
			checkIfSolved();
		}
	}

	// This function shuffles the tiles when the shuffle button is clicked
	// then it checks if the puzzle has been solved in the case the shuffle solves
	// the puzzle
	function shuffleTiles() {
		for (var i = 0; i < 1000; i++) {
			var moveableTiles = [];
			for(var j = 0; j < 2; j++) {
				var nextToR = parseInt(EMPTY_ROW) - 1 + j * 2;
				var nextToC = parseInt(EMPTY_COL) - 1 + j * 2;
				if (nextToR < NUMBER_ROWS_COLS && nextToR >= 0 && checkMove(nextToR, EMPTY_COL)) {
					moveableTiles.push(document.getElementById("tile_" + nextToR + "_" + EMPTY_COL));
				}
				if (nextToC < NUMBER_ROWS_COLS && nextToC >= 0 && checkMove(EMPTY_ROW, nextToC)) {
					moveableTiles.push(document.getElementById("tile_" + EMPTY_ROW + "_" + nextToC));
				}
			}
			var randomTile = moveableTiles[Math.floor(Math.random() * moveableTiles.length)];
			var rowAndCol = getRowAndCol(randomTile);
			changeSpots(randomTile, rowAndCol);
		}
		checkIfSolved();
	}

	// This function takes in a row and column as parameters and checks if
	// the tile at that row and column is able to move into the current empty
	// tile spot, it returns true if so and false if not.
	function checkMove(row, column) {
		var emptyR = parseInt(EMPTY_ROW);
		var emptyC = parseInt(EMPTY_COL);
		if (emptyR - 1 == row && emptyC == column) {
			return true;
		} else if (emptyR == row && emptyC - 1 == column) {
			return true;
		} else if (emptyR + 1 == row && emptyC == column) {
			return true;
		} else if (emptyR == row && emptyC + 1 == column) {
			return true;
		}
		return false;
 	}

 	// This function takes in the current tile as a parameter
 	// and returns its split id.
 	function getRowAndCol(current) {
 		return current.id.split("_");
 	}

 	// This function checks if the puzzle has been solved and if so then it
 	// congratulates the winner, if not it will display nothing.
 	function checkIfSolved() {
		var tiles = document.getElementsByClassName("puzzleTiles");
		var isSolved = true;
		for (var i = 0; i < originalPosition.length; i++) {
			var original = originalPosition[i].split("_");
			var rightNow = getRowAndCol(tiles[i]);
			if ((original[1] != rightNow[1]) || (original[2] != rightNow[2])) {
				isSolved = false;
			}
		}
		if (isSolved) {
			document.getElementById("output").innerHTML = "Congratulations you won";
		} else {
			document.getElementById("output").innerHTML = "";
		}
	}

	// This function takes in the current tile and an array of its id
	// that was split as parameters and then switches the spots of the
	// empty tile and the current tile, then switches their columns/rows.
 	function changeSpots(current, spot) {
 		current.style.top = EMPTY_ROW * 100 + "px";
		current.style.left = EMPTY_COL * 100 + "px";
		current.id = "tile_" + EMPTY_ROW + "_" + EMPTY_COL;
		EMPTY_ROW = spot[1];
		EMPTY_COL = spot[2];
 	}

})();