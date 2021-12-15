<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    list($pattern, $instructions) = processInputs($allInputs);

    echo $pattern . "<br>";
    echo "<br>";

    $split_pattern = str_split($pattern);
    $stringBuild = "";
    for ($d = 0; $d < 10; $d++)
    {
        for ($j = 0; $j < count($split_pattern); $j++)
        {
            //cant do plus one on last element of array
            if ($j != count($split_pattern) - 1)
            {
                $stringBuild = $stringBuild . $split_pattern[$j] . $instructions[$split_pattern[$j] . $split_pattern[$j + 1]];
            }
            else
            {
                $stringBuild = $stringBuild . $split_pattern[$j];
            }
        }
        $split_pattern = str_split($stringBuild);
        $stringBuild = "";
    }

    $pairs = array();
    for ($j = 0; $j < count($split_pattern); $j++)
    {
        if ($j != count($split_pattern) - 1)
        {
            if (!array_key_exists($split_pattern[$j] . $split_pattern[$j + 1], $pairs))
            {
                $pairs[$split_pattern[$j] . $split_pattern[$j + 1]] = 0;
            }
            $pairs[$split_pattern[$j] . $split_pattern[$j + 1]] = $pairs[$split_pattern[$j] . $split_pattern[$j + 1]] + 1;
        }
    }

    $array_count_values = array_count_values($split_pattern);
    print_r($array_count_values);
    $max = 0;
    $min = 999999999999999;
    foreach ($array_count_values as $k => $v)
    {
        if ($v > $max)
        {
            $max = $v;
        }
        if ($v < $min)
        {
            $min = $v;
        }
    }
    echo "<br>";
    print_r($pairs);
    echo "<br>";
    echo "Max: ".$max."<br>";
    echo "Min: ".$min."<br>";
    echo $max - $min;

    echo "<br>";



    //PART TWO
    $split_pattern = str_split($pattern);
    $pairs = array();
    print_r($pairs);
    for ($j = 0; $j < count($split_pattern); $j++)
    {
        if ($j != count($split_pattern) - 1)
        {
            if (!array_key_exists($split_pattern[$j] . $split_pattern[$j + 1], $pairs))
            {
                $pairs[$split_pattern[$j] . $split_pattern[$j + 1]] = 0;
            }
            $pairs[$split_pattern[$j] . $split_pattern[$j + 1]] = $pairs[$split_pattern[$j] . $split_pattern[$j + 1]] + 1;
        }
    }

    print_r($pairs);

    for ($d = 0; $d < 40; $d++)
    {
        $newPairs = array();
        foreach ($pairs as $k => $v)
        {
            $newLetter = $instructions[$k];
            $str_split = str_split($k);
            $pair1 = $str_split[0] . $newLetter;
            $pair2 = $newLetter . $str_split[1];

            $count = $v;
            if (!array_key_exists($pair1, $newPairs))
            {
                $newPairs[$pair1] = 0;
            }
            $newPairs[$pair1] = $newPairs[$pair1] + $count;

            if (!array_key_exists($pair2, $newPairs))
            {
                $newPairs[$pair2] = 0;
            }
            $newPairs[$pair2] = $newPairs[$pair2] + $count;
        }
        $pairs = $newPairs;
    }

    print_r($pairs);

    //double count and then half later plus add ends
    $letters = array();
    foreach ($pairs as $k => $v)
    {
        $str_split = str_split($k);
        $letter1 = $str_split[0];
        $letter2 = $str_split[0];
        $count = $v;
        if (!array_key_exists($letter1, $letters))
        {
            $letters[$letter1] = 0;
        }
        $letters[$letter1] = $letters[$letter1] + $count;
        if (!array_key_exists($letter2, $letters))
        {
            $letters[$letter2] = 0;
        }
        $letters[$letter2] = $letters[$letter2] + $count;
    }

    echo "<br>";
    echo count($letters)."<br>";
    foreach ($letters as $k => $v)
    {
        $letters[$k] = $letters[$k] / 2;
    }

    $letters[$split_pattern[0]] = $letters[$split_pattern[0]] + 1;
    $letters[$split_pattern[count($split_pattern)-1]] = $letters[$split_pattern[count($split_pattern)-1]] + 1;

    print_r($letters);
    echo "<br>";
    $max = 0;
    $min = 999999999999999999;
    foreach ($letters as $k => $v)
    {
        if ($v > $max)
        {
            $max = $v;
        }
        if ($v < $min)
        {
            $min = $v;
        }
    }
    echo "Max: ".$max."<br>";
    echo "Min: ".$min."<br>";

    echo $max - $min;

    function processInputs($allInputs)
    {
        $pattern = $allInputs[0];

        $instructions = array();
        for ($j = 2; $j < count($allInputs); $j++)
        {
            $string = $allInputs[$j];
            $stringParts = explode(" -> ", $string);
            $instructions[$stringParts[0]] = $stringParts[1];
        }
        return array($pattern, $instructions);
    }

?>