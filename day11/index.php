<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    $octopusGrid = generateOctopusGrid($allInputs, $octopusGrid);

    $count = 0;
    for ($d = 0; $d < 100; $d++)
    {
        $octopusGrid = increaseAllEnergyByOne($octopusGrid);
        list($octopusGrid, $count) = flashingBonaza($octopusGrid, $count);
        $octopusGrid = resetAllEnergyOfFlashedOctupus($octopusGrid);
    }

    echo $count;
    echo "<br>";


    //PART TWO
    $octopusGrid = generateOctopusGrid($allInputs, $octopusGrid);

    $count = 0;
    $dayNumber = 0;
    while (true)
    {
        $octopusGrid = increaseAllEnergyByOne($octopusGrid);
        list($octopusGrid, $count) = flashingBonaza($octopusGrid, $count);
        $octopusGrid = resetAllEnergyOfFlashedOctupus($octopusGrid);
        if (allFlashed($octopusGrid))
        {
            $dayNumber = $d;
            break;
        }
    }

    //Humans dont count from 0
    echo $dayNumber + 1;
    echo "<br>";


    function generateOctopusGrid($allInputs)
    {
        $octopusGrid = array();
        for ($j = 0; $j < count($allInputs); $j++)
        {
            $row = array();
            $str_split = str_split($allInputs[$j]);
            for ($i = 0; $i < count($str_split); $i++)
            {
                array_push($row, intval($str_split[$i]));
            }
            array_push($octopusGrid, $row);
        }
        return $octopusGrid;
    }

    function increaseAllEnergyByOne($octopusGrid)
    {
        for ($j = 0; $j < count($octopusGrid); $j++)
        {
            for ($i = 0; $i < count($octopusGrid[$j]); $i++)
            {
                $octopusGrid[$j][$i]++;
            }
        }
        return $octopusGrid;
    }

    function flashingBonaza($octopusGrid, $count)
    {
        for ($j = 0; $j < count($octopusGrid); $j++)
        {
            for ($i = 0; $i < count($octopusGrid[$j]); $i++)
            {
                if ($octopusGrid[$j][$i] > 9)
                {
                    $count++;
                    $octopusGrid[$j][$i] = -999999;
                    list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j, $i, $count);
                }
            }
        }
        return array($octopusGrid, $count);
    }

    function increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j, $i, $count)
    {
        //top left
        if ($j != 0 && $i != 0)
        {
            $octopusGrid[$j - 1][$i - 1]++;
            if ($octopusGrid[$j - 1][$i - 1] > 9)
            {
                $count++;
                $octopusGrid[$j - 1][$i - 1] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j - 1, $i - 1, $count);
            }
        }
        //top
        if ($j != 0)
        {
            $octopusGrid[$j - 1][$i]++;
            if ($octopusGrid[$j - 1][$i] > 9)
            {
                $count++;
                $octopusGrid[$j - 1][$i] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j - 1, $i, $count);
            }
        }
        //top right
        if ($j != 0 && $i != count($octopusGrid[0]) - 1)
        {
            $octopusGrid[$j - 1][$i + 1]++;
            if ($octopusGrid[$j - 1][$i + 1] > 9)
            {
                $count++;
                $octopusGrid[$j - 1][$i + 1] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j - 1, $i + 1, $count);
            }
        }
        //left
        if ($i != 0)
        {
            $octopusGrid[$j][$i - 1]++;
            if ($octopusGrid[$j][$i - 1] > 9)
            {
                $count++;
                $octopusGrid[$j][$i - 1] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j, $i - 1, $count);
            }
        }
        //right
        if ($i != count($octopusGrid[0]) - 1)
        {
            $octopusGrid[$j][$i + 1]++;
            if ($octopusGrid[$j][$i + 1] > 9)
            {
                $count++;
                $octopusGrid[$j][$i + 1] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j, $i + 1, $count);
            }
        }
        //bottom left
        if ($j != count($octopusGrid) - 1 && $i != 0)
        {
            $octopusGrid[$j + 1][$i - 1]++;
            if ($octopusGrid[$j + 1][$i - 1] > 9)
            {
                $count++;
                $octopusGrid[$j + 1][$i - 1] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j + 1, $i - 1, $count);
            }
        }
        //bottom
        if ($j != count($octopusGrid) - 1)
        {
            $octopusGrid[$j + 1][$i]++;
            if ($octopusGrid[$j + 1][$i] > 9)
            {
                $count++;
                $octopusGrid[$j + 1][$i] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j + 1, $i, $count);
            }
        }
        //bottom right
        if ($j != count($octopusGrid) - 1 && $i != count($octopusGrid[0]) - 1)
        {
            $octopusGrid[$j + 1][$i + 1]++;
            if ($octopusGrid[$j + 1][$i + 1] > 9)
            {
                $count++;
                $octopusGrid[$j + 1][$i + 1] = -999999;
                list($octopusGrid, $count) = increaseEnergyOfAllAroundAndCheckForFlashes($octopusGrid, $j + 1, $i + 1, $count);
            }
        }
        return array($octopusGrid, $count);
    }

    function resetAllEnergyOfFlashedOctupus($octopusGrid)
    {
        for ($j = 0; $j < count($octopusGrid); $j++)
        {
            for ($i = 0; $i < count($octopusGrid[$j]); $i++)
            {
                if ($octopusGrid[$j][$i] < 0)
                {
                    $octopusGrid[$j][$i] = 0;
                }
            }
        }
        return $octopusGrid;
    }

    function prettyPrint($octopusGrid)
    {
        for ($j = 0; $j < count($octopusGrid); $j++)
        {
            for ($i = 0; $i < count($octopusGrid[$j]); $i++)
            {
                echo $octopusGrid[$j][$i] . " ";
            }
            echo "<br>";
        }
        echo "<br>";
    }

    function allFlashed($octopusGrid)
    {
        for ($j = 0; $j < count($octopusGrid); $j++)
        {
            for ($i = 0; $i < count($octopusGrid[$j]); $i++)
            {
                if ($octopusGrid[$j][$i] > 0)
                {
                    return false;
                }
            }
        }
        return true;
    }


?>