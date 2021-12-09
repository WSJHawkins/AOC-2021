<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);


    //PART ONE
    $allHeights = buildHeightMap($allInputs);

    $sum = 0;
    $lowPointCoord = array();
    for ($j = 0; $j < count($allHeights); $j++)
    {
        for ($i = 0; $i < count($allHeights[$j]); $i++)
        {
            if (lowerThanNeighbours($allHeights, $j, $i))
            {
                array_push($lowPointCoord, array(intval($j), intval($i)));
                $sum = $sum + 1 + $allHeights[$j][$i];
            }
        }
    }

    echo $sum;
    echo "<br>";
    var_dump($lowPointCoord);
    echo "<br>";

    //PART TWO
    $basins = array();
    //basin structure=( ((y,x),(y,x)), ((y,x),(y,x),(y,x)))
    for ($j = 0; $j < count($lowPointCoord); $j++)
    {
        if (!isInBasin($basins,$lowPointCoord[$j][0],$lowPointCoord[$j][1]))
        {
            array_push($basins, expandBasin($allHeights, $lowPointCoord[$j], array()));
        }
    }


    //FIND BIGGEST BASINS lets hope we have no duplicates
    $topSize = 0;
    $secondSize = 0;
    $thirdSize = 0;
    for ($j = 0; $j < count($basins); $j++)
    {
        $sizeOfBasin = count($basins[$j]);
        if ($sizeOfBasin > $thirdSize)
        {
            if ($sizeOfBasin > $secondSize)
            {
                //biggest
                if ($sizeOfBasin > $topSize)
                {
                    $thirdSize = $secondSize;
                    $secondSize = $topSize;
                    $topSize = $sizeOfBasin;
                }
                //second biggest
                else
                {
                    $thirdSize = $secondSize;
                    $secondSize = $sizeOfBasin;
                }
            }
            //third biggest
            else
            {
                $thirdSize = $sizeOfBasin;
            }
        }
    }

    echo $topSize * $secondSize * $thirdSize;
    //END

    //FUNCTIONS
    function buildHeightMap(array $allInputs)
    {
        $allHeights = array();
        for ($j = 0; $j < count($allInputs); $j++)
        {
            array_push($allHeights, str_split($allInputs[$j]));
        }
        return $allHeights;
    }


    function lowerThanNeighbours($allHeights, $y, $x)
    {
        $isLower = true;
        $value = intval($allHeights[$y][$x]);
        if ($y != 0)
        {
            if ($value >= $allHeights[$y - 1][$x])
            {
                $isLower = false;
            }
        }
        if ($x != 0)
        {
            if ($value >= $allHeights[$y][$x - 1])
            {
                $isLower = false;
            }
        }
        if ($x != count($allHeights[0]) - 1)
        {
            if ($value >= $allHeights[$y][$x + 1])
            {
                $isLower = false;
            }
        }
        if ($y != count($allHeights) - 1)
        {
            if ($value >= $allHeights[$y + 1][$x])
            {
                $isLower = false;
            }
        }

        return $isLower;
    }

    function lowerThanNeighboursIgnoreBasin($allHeights, $y, $x, $basin)
    {
        $isLower = true;
        $value = intval($allHeights[$y][$x]);
        if ($y != 0)
        {
            if ($value >= $allHeights[$y - 1][$x] && !isInBasin(array($basin), $y - 1, $x))
            {
                $isLower = false;
            }
        }
        if ($x != 0)
        {
            if ($value >= $allHeights[$y][$x - 1] && !isInBasin(array($basin), $y, $x - 1))
            {
                $isLower = false;
            }
        }
        if ($x != count($allHeights[0]) - 1)
        {
            if ($value >= $allHeights[$y][$x + 1] && !isInBasin(array($basin), $y, $x + 1))
            {
                $isLower = false;
            }
        }
        if ($y != count($allHeights) - 1)
        {
            if ($value >= $allHeights[$y + 1][$x] && !isInBasin(array($basin), $y + 1, $x))
            {
                $isLower = false;
            }
        }

        return $isLower;
    }


    function expandBasin($allHeights, $lowPointCoord, $basin)
    {
        array_push($basin, $lowPointCoord);

        $value = intval($allHeights[$lowPointCoord[0]][$lowPointCoord[1]]);

        //check above
        if ($lowPointCoord[0] != 0)
        {
            if (!isInBasin(array($basin), $lowPointCoord[0] - 1, $lowPointCoord[1]))
            {
                if ($allHeights[$lowPointCoord[0] - 1][$lowPointCoord[1]] != 9 )
                {
                    $basin = expandBasin($allHeights,array($lowPointCoord[0] - 1,$lowPointCoord[1]),$basin);
                }
            }
        }
        //check left
        if ($lowPointCoord[1] != 0)
        {
            if (!isInBasin(array($basin), $lowPointCoord[0], $lowPointCoord[1] - 1))
            {
                if ($allHeights[$lowPointCoord[0]][$lowPointCoord[1]-1] != 9)
                {
                    $basin = expandBasin($allHeights,array($lowPointCoord[0],$lowPointCoord[1]-1),$basin);
                }
            }
        }
        //check right
        if ($lowPointCoord[1] != count($allHeights[0]) - 1)
        {
            if (!isInBasin(array($basin), $lowPointCoord[0], $lowPointCoord[1] + 1))
            {
                if ($allHeights[$lowPointCoord[0]][$lowPointCoord[1]+1] != 9)
                {
                    $basin = expandBasin($allHeights,array($lowPointCoord[0],$lowPointCoord[1]+1),$basin);
                }
            }
        }
        //check below
        if ($lowPointCoord[0] != count($allHeights) - 1)
        {
            if (!isInBasin(array($basin), $lowPointCoord[0] + 1, $lowPointCoord[1]))
            {
                if ($allHeights[$lowPointCoord[0] + 1][$lowPointCoord[1]] != 9)
                {
                    $basin = expandBasin($allHeights,array($lowPointCoord[0] + 1,$lowPointCoord[1]),$basin);
                }
            }
        }

        return $basin;
    }

    function isInBasin($basins, $y, $x)
    {
        for ($j = 0; $j < count($basins); $j++)
        {
            for ($i = 0; $i < count($basins[$j]); $i++)
            {
                if ($basins[$j][$i][0] == $y && $basins[$j][$i][1] == $x)
                {
                    return true;
                }
            }
        }
        return false;
    }


?>