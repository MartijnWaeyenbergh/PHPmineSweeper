<?php



class mineGame{

	function checkGrid($grid,$x,$y){
		return $grid[$x][$y];
	}

	function startGame(){
		$grid = mineGame::generateGrid(GRIDSIZE);
		$grid = mineGame::addMinestoGrid($grid,NUMBEROFMINES);
		$_SESSION['game'] = "on";
		$_SESSION['grid'] = $grid;
		$_SESSION['visibleGrid'] = mineGame::generateGrid(GRIDSIZE);
		echo mineGame::tekenGrid($grid);
		$_SESSION['movesDone'] = 0;
	}

	function generateGrid($gridSize){
		$grid = array();
		for ($i=0; $i < $gridSize; $i++) { 
			for ($j=0; $j < $gridSize; $j++) { 
				$grid[$i][$j] = "0";
			}
		}
		return $grid;
	}

	function addMinestoGrid($grid,$numberOfMines){
		$max = count($grid) - 1;
		$minesSet = 0;
		while ($minesSet < $numberOfMines) {
			$i = mt_rand(0,$max);
			$j = mt_rand(0,$max);
			if ($grid[$i][$j] != "X"){
				$grid[$i][$j] = "X";
				$grid = mineGame::addNumbersToNeighbours($grid,$i,$j);
				$minesSet++;
			}
		}
		return $grid;
	}

	function checkEmptyNeighbours($i,$j){
		$max = count($_SESSION['grid']) - 1;
		if(($i-1 >= 0)&&($j-1 >= 0)&&is_numeric($_SESSION['grid'][$i-1][$j-1])&&($_SESSION['grid'][$i-1][$j-1] == 0)&&($_SESSION['visibleGrid'][$i-1][$j-1] == 0)){
			$_SESSION['visibleGrid'][$i-1][$j-1]= "1";
			mineGame::checkEmptyNeighbours($i-1,$j-1);
		}
		if(($i-1 >= 0)&&is_numeric($_SESSION['grid'][$i-1][$j])&&($_SESSION['grid'][$i-1][$j] == 0)&&($_SESSION['visibleGrid'][$i-1][$j] == 0)){
			$_SESSION['visibleGrid'][$i-1][$j]= "1";
			mineGame::checkEmptyNeighbours($i-1,$j);
		}
		if(($i-1 >= 0)&&($j+1 <= $max)&&is_numeric($_SESSION['grid'][$i-1][$j+1])&&($_SESSION['grid'][$i-1][$j+1] == 0)&&($_SESSION['visibleGrid'][$i-1][$j+1] == 0)){
			$_SESSION['visibleGrid'][$i-1][$j+1]= "1";
			mineGame::checkEmptyNeighbours($i-1,$j+1);
		}
		if(($j-1 >= 0)&&is_numeric($_SESSION['grid'][$i][$j-1])&&($_SESSION['grid'][$i][$j-1]==0)&&($_SESSION['visibleGrid'][$i][$j-1] == 0)){
			$_SESSION['visibleGrid'][$i][$j-1]= "1";
			mineGame::checkEmptyNeighbours($i,$j-1);
		}
		if(($j+1 <= $max)&&is_numeric($_SESSION['grid'][$i][$j+1])&&($_SESSION['grid'][$i][$j+1]==0)&&($_SESSION['visibleGrid'][$i][$j+1] == 0)){
			$_SESSION['visibleGrid'][$i][$j+1]= "1";
			mineGame::checkEmptyNeighbours($i,$j+1);
		}
		if(($i+1 <= $max)&&($j-1 >= 0)&&is_numeric($_SESSION['grid'][$i+1][$j-1])&&($_SESSION['grid'][$i+1][$j-1]==0)&&($_SESSION['visibleGrid'][$i+1][$j-1] == 0)){
			$_SESSION['visibleGrid'][$i+1][$j-1]= "1";
			mineGame::checkEmptyNeighbours($i+1,$j-1);
		}
		if(($i+1 <= $max)&&is_numeric($_SESSION['grid'][$i+1][$j])&&($_SESSION['grid'][$i+1][$j]==0)&&($_SESSION['visibleGrid'][$i+1][$j] == 0)){
			$_SESSION['visibleGrid'][$i+1][$j]= "1";
			mineGame::checkEmptyNeighbours($i+1,$j);
		}
		if(($i+1 <= $max)&&($j+1 <= $max)&&is_numeric($_SESSION['grid'][$i+1][$j+1])&&($_SESSION['grid'][$i+1][$j+1]==0)&&($_SESSION['visibleGrid'][$i+1][$j+1] == 0)){
			$_SESSION['visibleGrid'][$i+1][$j+1]= "1";
			mineGame::checkEmptyNeighbours($i+1,$j+1);
		}
	}

	function addNumbersToNeighbours($grid,$i,$j){
		$max = count($grid) - 1;
		if(($i-1 >= 0)&&($j-1 >= 0)&&is_numeric($grid[$i-1][$j-1])){
			$grid[$i-1][$j-1]++;
		}
		if(($i-1 >= 0)&&is_numeric($grid[$i-1][$j])){
			$grid[$i-1][$j]++;
		}
		if(($i-1 >= 0)&&($j+1 <= $max)&&is_numeric($grid[$i-1][$j+1])){
			$grid[$i-1][$j+1]++;
		}
		if(($j-1 >= 0)&&is_numeric($grid[$i][$j-1])){
			$grid[$i][$j-1]++;
		}
		if(($j+1 <= $max)&&is_numeric($grid[$i][$j+1])){
			$grid[$i][$j+1]++;
		}
		if(($i+1 <= $max)&&($j-1 >= 0)&&is_numeric($grid[$i+1][$j-1])){
			$grid[$i+1][$j-1]++;
		}
		if(($i+1 <= $max)&&is_numeric($grid[$i+1][$j])){
			$grid[$i+1][$j]++;
		}
		if(($i+1 <= $max)&&($j+1 <= $max)&&is_numeric($grid[$i+1][$j+1])){
			$grid[$i+1][$j+1]++;
		}
		return $grid;
	}

	function tekenGrid($grid){
		$output = "<table border=1>";
		$max = count($grid);
		for ($i=0; $i < $max; $i++) { 
			$output .= "<tr>";
			for ($j=0; $j < $max; $j++) { 
				if ($_SESSION['visibleGrid'][$i][$j] == 0){
					$output .= "<td><a href='?play&x=".$i."&y=".$j."'><button class='button'></button></a></td>";
				}else{
					$output .= "<td>";
					if ($grid[$i][$j]==0){
						if($grid[$i][$j]=="X"){
							$output .= "<div class='clearField'>&#x1f4a3;</div>";
						}else{
							$output .= "<div class='clearField num0'></div>";							
						}
					}
					else{
						$output .= "<div class='clearField num".$grid[$i][$j]."'>".$grid[$i][$j]."</div>";
					}
					$output .= "</div></td>";
				}
			}
			$output .= "</tr>";
		}
		$output .= "</table>";
		return $output;
	}


}


?>