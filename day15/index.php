<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    $grid = array();
    $distMap = array();
    $pathMap = array();
    $explored = array();
    for ($j = 0; $j < count($allInputs); $j++)
    {
        $vars = str_split($allInputs[$j]);

        $row1 = array();
        $row2 = array();
        $row3 = array();
        $row4 = array();
        for ($i = 0; $i < count($vars); $i++)
        {
            array_push($row1, intval($vars[$i]));
            array_push($row2, 99999999999999);
            array_push($row3, array(0, 0));
            array_push($row4, 0);
        }
        array_push($grid, $row1);
        array_push($distMap, $row2);
        array_push($pathMap, $row3);
        array_push($explored, $row4);
    }

    $locationToCheck = array(0, 0);
    $distMap[0][0] = 0;
    while (true)
    {
        list($explored, $distMap, $pathMap) = nextExplorationStep($explored, $locationToCheck, $distMap, $grid, $pathMap);
        if ($locationToCheck[0] == count($grid[0]) - 1 && $locationToCheck[1] == count($grid) - 1)
        {
            break;
        }
        else
        {
            $locationToCheck = findNextLocationToCheck($explored, $distMap);
        }
    }

    gridPrint($distMap);
    gridPrint($explored);
    echo "<br>" . $distMap[count($distMap) - 1][count($distMap[0]) - 1] . "<br>";


    //PART TWO
    $grid = array();
    $distMap = array();
    $pathMap = array();
    $explored = array();
    for ($n1 = 0; $n1 < 5; $n1++)
    {
        for ($j = 0; $j < count($allInputs); $j++)
        {
            $vars = str_split($allInputs[$j]);

            $row1 = array();
            $row2 = array();
            $row3 = array();
            $row4 = array();
            for ($n2 = 0; $n2 < 5; $n2++)
            {
                for ($i = 0; $i < count($vars); $i++)
                {
                    $value = intval($vars[$i]) + $n1 + $n2;
                    if ($value >= 10)
                    {
                        $value = $value - 9;
                    }
                    array_push($row1, $value);
                    array_push($row2, 99999999999999);
                    array_push($row3, array(0, 0));
                    array_push($row4, 0);
                }
            }
            array_push($grid, $row1);
            array_push($distMap, $row2);
            array_push($pathMap, $row3);
            array_push($explored, $row4);
        }
    }


    gridPrint($grid);

    $locationToCheck = array(0, 0);
    $distMap[0][0] = 0;
    while (true)
    {
        list($explored, $distMap, $pathMap) = nextExplorationStep($explored, $locationToCheck, $distMap, $grid, $pathMap);
        if ($locationToCheck[0] == count($grid[0]) - 1 && $locationToCheck[1] == count($grid) - 1)
        {
            break;
        }
        else
        {
            $locationToCheck = findNextLocationToCheck($explored, $distMap);
        }
    }

    gridPrint($distMap);
    echo "<br>" . $distMap[count($distMap) - 1][count($distMap[0]) - 1] . "<br>";


    function nextExplorationStep(array $explored, array $location, array $distMap, array $grid, array $pathMap)
    {
        $explored[$location[1]][$location[0]] = 1;
        $currentDistance = $distMap[$location[1]][$location[0]];
        $neighboursToCheck = getNeighboursToCheck($grid, $location[0], $location[1], $explored);
        for ($n = 0; $n < count($neighboursToCheck); $n++)
        {
            if ($distMap[$neighboursToCheck[$n][1]][$neighboursToCheck[$n][0]] > $currentDistance + $grid[$neighboursToCheck[$n][1]][$neighboursToCheck[$n][0]])
            {
                $distMap[$neighboursToCheck[$n][1]][$neighboursToCheck[$n][0]] = $currentDistance + $grid[$neighboursToCheck[$n][1]][$neighboursToCheck[$n][0]];
                $pathMap[$neighboursToCheck[$n][1]][$neighboursToCheck[$n][0]] = array($location[0], $location[1]);
            }
        }
        return array($explored, $distMap, $pathMap);
    }

    function findNextLocationToCheck($explored, $distMap)
    {
        $min = 99999999;
        $minLoc = array();
        for ($j = 0; $j < count($explored); $j++)
        {
            for ($i = 0; $i < count($explored[$j]); $i++)
            {
                if ($explored[$j][$i] != 1)
                {
                    if ($distMap[$j][$i] < $min)
                    {
                        $min = $distMap[$j][$i];
                        $minLoc = array($i, $j);
                    }
                }
            }
        }
        return $minLoc;
    }


    function getNeighboursToCheck($grid, $x, $y, $explored)
    {
        $neighboursToCheck = array();
        //top
        if ($y != 0 && $explored[$y - 1][$x] == 0)
        {
            array_push($neighboursToCheck, array($x, $y - 1));
        }
        //left
        if ($x != 0 && $explored[$y][$x - 1] == 0)
        {
            array_push($neighboursToCheck, array($x - 1, $y));
        }
        //right
        if ($x != count($grid[0]) - 1 && $explored[$y][$x + 1] == 0)
        {
            array_push($neighboursToCheck, array($x + 1, $y));
        }
        //bottom
        if ($y != count($grid) - 1 && $explored[$y + 1][$x] == 0)
        {
            array_push($neighboursToCheck, array($x, $y + 1));
        }
        return $neighboursToCheck;
    }


    function gridPrint($grid)
    {
        for ($j = 0; $j < count($grid); $j++)
        {
            for ($i = 0; $i < count($grid[$j]); $i++)
            {
                echo $grid[$j][$i].",";
            }
            echo "<br>";
        }
    }

?>