<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    list($dots, $folds) = processInputs($allInputs);

//    prettyPrint($dots);
//    print_r($folds);

    $newPoints = reflectPoints($dots, $folds[0]);
//    prettyPrint($newPoints);
    echo count($newPoints);
    echo "<br>";

    //PART TWO
    for ($j = 0; $j < count($folds); $j++)
    {
        $dots = reflectPoints($dots, $folds[$j]);
    }
    gridPrint($dots);
    echo "<br>";


    function processInputs($allInputs)
    {
        $dots = array();
        $folds = array();
        $dotSection = true;
        for ($j = 0; $j < count($allInputs); $j++)
        {
            if ($allInputs[$j] == "")
            {
                $dotSection = false;
                continue;
            }
            if ($dotSection)
            {
                $vars = explode(",", $allInputs[$j]);
                array_push($dots, array(intval($vars[0]), intval($vars[1])));
            }
            else
            {
                $vars = explode(" ", $allInputs[$j]);
                $vars = explode("=", $vars[2]);
                array_push($folds, array($vars[0], intval($vars[1])));
            }
        }
        return array($dots, $folds);
    }

    function prettyPrint($connections)
    {
        for ($j = 0; $j < count($connections); $j++)
        {
            for ($i = 0; $i < count($connections[$j]); $i++)
            {
                echo $connections[$j][$i] . ",";
            }
            echo "<br>";
        }
    }

    function gridPrint($dots)
    {
        $grid = array();
        $maxX = 0;
        $maxY = 0;
        for ($j = 0; $j < count($dots); $j++)
        {
            if ($dots[$j][0] > $maxX)
            {
                $maxX = $dots[$j][0];
            }
            if ($dots[$j][1] > $maxY)
            {
                $maxY = $dots[$j][1];
            }
        }
        $maxX++;
        $maxY++;
        for ($j = 0; $j < $maxY; $j++)
        {
            $row = array();
            for ($i = 0; $i < $maxX; $i++)
            {
                array_push($row, " - ");
            }
            array_push($grid, $row);
        }
        array_push($grid, $row);

        for ($j = 0; $j < count($dots); $j++)
        {
            $grid[$dots[$j][1]][$dots[$j][0]] = " # ";
        }
        for ($j = 0; $j < count($grid); $j++)
        {
            for ($i = 0; $i < count($grid[$j]); $i++)
            {
                echo $grid[$j][$i];
            }
            echo "<br>";
        }
    }

    function reflectPoints($dots, $fold)
    {
        $reflectedPoints = array();
        if ($fold[0] == "y")
        {
            for ($j = 0; $j < count($dots); $j++)
            {
                $x = $dots[$j][0];
                $y = $dots[$j][1];
                if ($y > $fold[1])
                {
                    $y = $fold[1] - ($y - $fold[1]);
                }
                $found = false;
                for ($i = 0; $i < count($reflectedPoints); $i++)
                {
                    if ($reflectedPoints[$i][0] == $x && $reflectedPoints[$i][1] == $y)
                    {
                        $found = true;
                        break;
                    }
                }
                if (!$found)
                {
                    array_push($reflectedPoints, array($x, $y));
                }
            }
        }
        else if ($fold[0] == "x")
        {
            for ($j = 0; $j < count($dots); $j++)
            {
                $x = $dots[$j][0];
                $y = $dots[$j][1];
                if ($x > $fold[1])
                {
                    $x = $fold[1] - ($x - $fold[1]);
                }
                $found = false;
                for ($i = 0; $i < count($reflectedPoints); $i++)
                {
                    if ($reflectedPoints[$i][0] == $x && $reflectedPoints[$i][1] == $y)
                    {
                        $found = true;
                        break;
                    }
                }
                if (!$found)
                {
                    array_push($reflectedPoints, array($x, $y));
                }
            }
        }
        return $reflectedPoints;
    }


?>