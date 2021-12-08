<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);


    //PART ONE
    $fish = explode(",", $file);

    $numberOfDays = 80;
    for ($i = 0; $i < $numberOfDays; $i++)
    {
        $numOfFish = count($fish);
        for ($j = 0; $j < $numOfFish; $j++)
        {
            if ($fish[$j] == 0)
            {
                $fish[$j] = 7;
                array_push($fish, 8);
            }
            $fish[$j]--;
        }
    }

    echo count($fish);
    echo "<br>";


    //PART TWO
    $fish = explode(",", $file);

    $bucketsOfAges = array();
    for ($j = 0; $j < 9; $j++)
    {
        array_push($bucketsOfAges, 0);
    }

    $numOfFish = count($fish);
    for ($j = 0; $j < $numOfFish; $j++)
    {
        $bucketsOfAges[$fish[$j]]++;
    }
//    var_dump($bucketsOfAges);
//    echo "<br>";

    $numberOfDays = 256;
    for ($i = 0; $i < $numberOfDays; $i++)
    {
        $howManyAtZero = $bucketsOfAges[0];
        for ($j = 0; $j < count($bucketsOfAges); $j++)
        {
            if ($j == count($bucketsOfAges)-1)
            {
                $bucketsOfAges[6] = $bucketsOfAges[6] + $howManyAtZero;
                $bucketsOfAges[8] = $howManyAtZero;
            }
            else
            {
                $bucketsOfAges[$j] = $bucketsOfAges[$j + 1];
            }
        }
//        var_dump($bucketsOfAges);
//        echo "<br>";
    }

    $sum = 0;
    for ($j = 0; $j < 9; $j++)
    {
        $sum = $sum + $bucketsOfAges[$j];
    }
    echo $sum;

?>