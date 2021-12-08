<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);


    //PART ONE
    $allLines = array();
    $maxX = 0;
    $maxY = 0;
    for ($i = 0; $i < count($allInputs); $i++)
    {
        $parts = explode(" -> ", $allInputs[$i]);
        $start = explode(",", $parts[0]);
        $end = explode(",", $parts[1]);
        $x1 = intval($start[0]);
        $y1 = intval($start[1]);
        $x2 = intval($end[0]);
        $y2 = intval($end[1]);

        if ($y1 > $maxY)
        {
            $maxY = $y1;
        }
        if ($y2 > $maxY)
        {
            $maxY = $y2;
        }
        if ($x1 > $maxX)
        {
            $maxX = $x1;
        }
        if ($x2 > $maxX)
        {
            $maxX = $x2;
        }
        array_push($allLines, array(array($x1, $y1), array($x2, $y2)));
    }

    //grid starts at 0 so
    $maxX++;
    $maxY++;
    echo "Max X:" . $maxX . "<br>";
    echo "Max Y:" . $maxY . "<br>";
    $grid = generateGrid($maxX, $maxY);

    $grid = drawLinesOnGrid($allLines, $grid);

//    echo "Grid<br>";
//    for ($i = 0; $i < count($grid); $i++)
//    {
//        for ($j = 0; $j < count($grid[$i]); $j++)
//        {
//            echo $grid[$i][$j] . " ";
//        }
//        echo "<br>";
//    }

    echo countValuesHigherThanGivenInGrid($grid, 2);

    echo "<br>";
    echo "<br>";
    //PART TWO
    $grid = generateGrid($maxX, $maxY);

    $grid = drawLinesOnGridIncDiag($allLines, $grid);
//
//    echo "Grid<br>";
//    for ($i = 0; $i < count($grid); $i++)
//    {
//        for ($j = 0; $j < count($grid[$i]); $j++)
//        {
//            echo $grid[$i][$j] . " ";
//        }
//        echo "<br>";
//    }

    echo countValuesHigherThanGivenInGrid($grid, 2);


    function generateGrid($maxX, $maxY)
    {
        $grid = array();
        for ($i = 0; $i < $maxY; $i++)
        {
            $row = array();
            for ($j = 0; $j < $maxX; $j++)
            {
                array_push($row, 0);
            }
            array_push($grid, $row);
        }
        return $grid;
    }

    function drawLinesOnGrid($lines, $grid)
    {
        for ($i = 0; $i < count($lines); $i++)
        {
            if ($lines[$i][0][0] == $lines[$i][1][0])
            {
                $grid = drawVerticalLineOnGrid($lines[$i], $grid);
            }
            else if ($lines[$i][0][1] == $lines[$i][1][1])
            {
                $grid = drawHorizontalLineOnGrid($lines[$i], $grid);
            }
        }
        return $grid;
    }

    function drawLinesOnGridIncDiag($lines, $grid)
    {
        for ($i = 0; $i < count($lines); $i++)
        {
            if ($lines[$i][0][0] == $lines[$i][1][0])
            {
                $grid = drawVerticalLineOnGrid($lines[$i], $grid);
            }
            else if ($lines[$i][0][1] == $lines[$i][1][1])
            {
                $grid = drawHorizontalLineOnGrid($lines[$i], $grid);
            }
            else
            {
                $grid = drawDiaganolLineOnGrid($lines[$i], $grid);
            }
        }
        return $grid;
    }


    function drawHorizontalLineOnGrid($line, $grid)
    {
        //if x1 is smaller
        if ($line[0][0] < $line[1][0])
        {
            for ($j = 0; $j < ($line[1][0] - $line[0][0] + 1); $j++)
            {
                $grid[$line[0][1]][$line[0][0] + $j]++;
            }
        }
        else
        {
            for ($j = 0; $j < ($line[0][0] - $line[1][0] + 1); $j++)
            {
                $grid[$line[1][1]][$line[1][0] + $j]++;
            }
        }

        return $grid;
    }

    function drawVerticalLineOnGrid($line, $grid)
    {
        //if y1 is smaller
        if ($line[0][1] < $line[1][1])
        {
            for ($j = 0; $j < ($line[1][1] - $line[0][1] + 1); $j++)
            {
                $grid[$line[0][1] + $j][$line[0][0]]++;
            }
        }
        else
        {
            for ($j = 0; $j < ($line[0][1] - $line[1][1] + 1); $j++)
            {
                $grid[$line[1][1] + $j][$line[1][0]]++;
            }
        }

        return $grid;
    }

    function drawDiaganolLineOnGrid($line, $grid)
    {
//        1,1 -> 3,3 ---- 1,1  2,2  3,3
//        9,7 -> 7,9 ----- 9,7 8,8 7,9

//        if x1 smaller
        $xIncrementer = 0;
        if ($line[0][0] < $line[1][0])
        {
            $xIncrementer = 1;
        }
        else
        {
            $xIncrementer = -1;
        }
        //        if y1 smaller
        $yIncrementer = 0;
        if ($line[0][1] < $line[1][1])
        {
            $yIncrementer = 1;
        }
        else
        {
            $yIncrementer = -1;
        }

//        echo $line[0][0] . "," . $line[0][1] . "->" . $line[1][0] . "," . $line[1][1] . "<br>";
//        echo "X Incrementer:".$xIncrementer.", Y Incrementer: ".$yIncrementer."<br>";
        for ($j = 0; $j < (abs($line[1][1] - $line[0][1]) + 1); $j++)
        {
            $grid[$line[0][1] + $j*$yIncrementer][$line[0][0] + $j*$xIncrementer]++;
        }

        return $grid;
    }

    function countValuesHigherThanGivenInGrid($grid, $higherThan)
    {
        $count = 0;
        for ($i = 0; $i < count($grid); $i++)
        {
            for ($j = 0; $j < count($grid[$i]); $j++)
            {
                if ($grid[$i][$j] >= $higherThan)
                {
                    $count++;
                }
            }
        }
        return $count;
    }

?>