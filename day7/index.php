<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);


    //PART ONE
    $initialLocations = explode(",", $file);

    $sum = 0;
    $count = 0;
    for ($j = 0; $j < count($initialLocations); $j++)
    {
        $sum = $sum + $initialLocations[$j];
        $count++;
    }
    echo $sum;
    echo "<br>";
    echo $count;
    echo "<br>";
    $roundedMean = round($sum / $count);
    echo "mean:".$roundedMean;
    echo "<br>";

    $searchLocation = $roundedMean;
    $fuelCostBeforeUp = calcFuelCost($initialLocations,$searchLocation);
    $fuelCostGoingUp = calcFuelCost($initialLocations,$searchLocation);
    $fuelCostBeforeDown = calcFuelCost($initialLocations,$searchLocation);
    $fuelCostGoingDown = calcFuelCost($initialLocations,$searchLocation);

    echo "Fuel cost from mean:".$fuelCostBeforeUp;
    echo "<br>";

    do{
        $fuelCostBeforeUp = $fuelCostGoingUp;
        $searchLocation++;
        $fuelCostGoingUp = calcFuelCost($initialLocations,$searchLocation);
        echo "down:".$fuelCostGoingUp;
    }
    while($fuelCostGoingUp < $fuelCostBeforeUp);

    $searchLocation = $roundedMean;

    do{
        $fuelCostBeforeDown = $fuelCostGoingDown;
        $searchLocation--;
        $fuelCostGoingDown = calcFuelCost($initialLocations,$searchLocation);
        echo "up:".$fuelCostGoingDown;
    }
    while($fuelCostGoingDown < $fuelCostBeforeDown);

    echo $searchLocation;
    echo "<br>";
    echo $fuelCostBeforeUp;
    echo "<br>";
    echo $fuelCostBeforeDown;
    echo "<br>";


    function calcFuelCost($locations, $getTo){
        $sum = 0;
        for ($j = 0; $j < count($locations); $j++)
        {
            $sum = $sum + calcTriangleNumber(abs($locations[$j]-$getTo));
        }
        return $sum;
    }

    function calcTriangleNumber($number){
        return ($number*$number + $number)/2;
    }

?>