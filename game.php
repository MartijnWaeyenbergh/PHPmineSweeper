<?php
session_start();

/* 	
	Minesweeper
	----------------------
	A grid is created from x on y, with bombs in it in random places.
	Around the bombs is indicated how many adjacent bombs there are to that square.
	This can be horizontal, vertical and diagonal.
	On boxes without adjacent bombs, there will be no value.

	When clicked, it shows either:
	- an empty field, and all adjacent empty fields are also shown.
	- a field with a number (the number of adjacent bombs)
	- a bomb -> you are lost.

	To keep track, I create 2 arrays.
	The first to keep track of the field itself
	The second to keep track of which field has already been clicked on.
	You can then also check this each time.

	There is also a counter that keeps track of how many moves you have already made.

	Using the parameters below, you can determine the size of the game board and the number of bombs.

	in the settings.php file, you can specify the size (how many grids) and the number of mines in the game.

*/


require_once("settings.php");
require_once("class.mineGame.php");

$mineGame = new mineGame();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.button, .clearField{
			width: 20px;
			height: 20px;
			text-align: center;
			font-weight: bold;
		}
		table{
			border-collapse: collapse; border-spacing: 0;
		}
		.num0{
			/*color: green;*/
		}
		.num1{
			color: green;
		}
		.num2{
			color: orange;
		}
		.num3, .num4, .num5, .num6, .num7, .num8{
			color: red;
		}
		.wrapper{
			width: <?=GRIDSIZE*23?>px;
			margin: 0 auto; 
			text-align : center;
		}
		h2{
			text-align : center;
		}
	</style>
</head>
<body>


<div class="wrapper">
	<h2>Minesweeper - PHP </h2>
<?php

	if(isset($_REQUEST["newGame"])){
		unset($_SESSION['game']);
		unset($_SESSION['grid']);
		unset($_SESSION['visibleGrid']);
	}

	if(isset($_SESSION['game']) && $_SESSION['game'] == "on"){
		if (isset($_REQUEST['play'])&&isset($_REQUEST['x'])&&isset($_REQUEST['y'])){
			$_SESSION['movesDone']++;
			if ($mineGame->checkGrid($_SESSION['grid'],$_REQUEST['x'],$_REQUEST['y']) == "X"){
				$gridSize = count($_SESSION['visibleGrid']);
				for ($i=0; $i < $gridSize; $i++) { 
					for ($j=0; $j < $gridSize; $j++) { 
						$_SESSION['visibleGrid'][$i][$j] = "1";
					}
				}
			}
			else{
				$_SESSION['visibleGrid'][$_REQUEST['x']][$_REQUEST['y']]= "1"; 
				$mineGame->checkEmptyNeighbours($_REQUEST['x'],$_REQUEST['y']);
			}
		}else{
			echo "invalid";
		}
		echo $mineGame->tekenGrid($_SESSION['grid']);
		echo "Number of moves : ".$_SESSION['movesDone'];
	}else{
		$mineGame->startGame();
	}

	
?>

<br style="clear:both,">
<a href="?newGame">New Game?</a>
</div>
</body>
</html>