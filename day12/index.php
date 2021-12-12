<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    $connections = buildConnections($allInputs);
    prettyPrint($connections);

    $paths = pathBuilder($connections, array(array("start")), 1);
    $paths = removeOnesThatDontEnd($paths);
//    prettyPrint($paths);

    echo "COUNT: " . count($paths);
    echo "<br>";
    echo "<br>";

    //PART TWO
    $paths = pathBuilder($connections, array(array("start")), 2);
    $paths = removeOnesThatDontEnd($paths);
//    prettyPrint($paths);

    echo "COUNT: " . count($paths);


    function pathBuilder($connections, $paths, $modeForVisiting)
    {
        for ($i = 0; $i < count($paths); $i++)
        {
            $choices = findAllConnectionsFromGivenPoint($connections, $paths[$i][count($paths[$i]) - 1]);
            for ($j = 0; $j < count($choices); $j++)
            {
                $path = null;
                //use the original on the last one to save memory
                if ($j == count($choices) - 1)
                {
                    $path = $paths[$i];
                }
                else
                {
                    $path = array_merge(array(), $paths[$i]);
                }

                if (canVisit($path, $choices[$j], $modeForVisiting))
                {
                    array_push($path, $choices[$j]);
                    array_push($paths, $path);
                }
            }
        }
        return $paths;
    }


    function buildConnections(array $allInputs)
    {
        $connections = array();
        for ($j = 0; $j < count($allInputs); $j++)
        {
            array_push($connections, explode("-", $allInputs[$j]));
        }
        return $connections;
    }


    function prettyPrint($connections)
    {
        for ($j = 0; $j < count($connections); $j++)
        {
            for ($i = 0; $i < count($connections[$j]); $i++)
            {
                echo $connections[$j][$i] . "-";
            }
            echo "<br>";
        }
    }

    function findAllConnectionsFromGivenPoint($connections, $point)
    {
        $choices = array();
        for ($j = 0; $j < count($connections); $j++)
        {
            if (strcmp($connections[$j][0], $point) == 0)
            {
                array_push($choices, $connections[$j][1]);
            }
            if (strcmp($connections[$j][1], $point) == 0)
            {
                array_push($choices, $connections[$j][0]);
            }
        }
        return $choices;
    }

    function canVisit($path, $point, $modeForVisiting)
    {
        if ($modeForVisiting == 1)
        {
            return canVisitWithLowerCaseOnlyOnce($path, $point);
        }
        else
        {
            return canVisitOneLowerCaseTwice($path, $point);
        }
    }

    function canVisitWithLowerCaseOnlyOnce($path, $point)
    {
        for ($j = 0; $j < count($path); $j++)
        {
            //cant leave end
            if (strcmp($path[$j], "end") == 0)
            {
                return false;
            }

            if (strcmp($path[$j], $point) == 0)
            {
                if (!preg_match('#^[A-Z]+$#', $point))
                {
                    return false;
                }
            }
        }
        return true;
    }

    function canVisitOneLowerCaseTwice($path, $point)
    {
        for ($j = 0; $j < count($path); $j++)
        {
            //cant leave end
            if (strcmp($path[$j], "end") == 0)
            {
                return false;
            }

            //cant revist start
            if (strcmp($point, "start") == 0)
            {
                return false;
            }

            $oneRevisitUsedUp = false;
            $freq = array_count_values($path);
            foreach ($freq as $k => $v)
            {
                if ($v > 1 && !preg_match('#^[A-Z]+$#', $k))
                {
                    $oneRevisitUsedUp = true;
                    break;
                }
            }

            if (strcmp($path[$j], $point) == 0)
            {
                if ($oneRevisitUsedUp && !preg_match('#^[A-Z]+$#', $point))
                {
                    return false;
                }
            }
        }
        return true;
    }

    function removeOnesThatDontEnd($paths)
    {
        $pathsThatEnd = array();
        for ($j = 0; $j < count($paths); $j++)
        {
            if (strcmp($paths[$j][count($paths[$j]) - 1], "end") == 0)
            {
                array_push($pathsThatEnd, $paths[$j]);
            }
        }
        return $pathsThatEnd;
    }

?>