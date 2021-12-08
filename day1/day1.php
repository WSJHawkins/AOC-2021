<?php
    $file = file_get_contents("aocDay1.txt", true);
    $allInts = explode("\n", $file);

    //PART ONE
    $last = 999999;
    $counter = 0;
    foreach ($allInts as $int)
    {
        if (intval($int) > $last)
        {
            $counter = $counter + 1;
        }
        $last = intval($int);
    }
    echo $counter;


    echo "<br>";
    //PART TWO
    $last = 99999999;
    $counter = 0;

    for ($i = 0; $i < count($allInts); $i++)
    {
        if ($i < 2)
        {
            continue;
        }
        $sum = intval($allInts[$i]) + intval($allInts[$i - 1]) + intval($allInts[$i - 2]);
        if ($sum > $last)
        {
            $counter = $counter + 1;
        }
        $last = $sum;
    }
    echo $counter;
?>