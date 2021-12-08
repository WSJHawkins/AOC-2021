<?php

$file = file_get_contents("sampleInput.txt",true);
$file = file_get_contents("input.txt",true);
$allInputs = explode("\n", $file);

//PART ONE
$inputByDigit = str_split($allInputs[0]);
$numberOfOnesInEachPosition = array_fill(0,count($inputByDigit),0);

$gamma= array_fill(0,count($inputByDigit),0);
$epsilon = array_fill(0,count($inputByDigit),0);
$counter = 0;
foreach ($allInputs as $input){
    $counter = $counter + 1;
    $inputByDigit = str_split($input);
    $index = 0;
    foreach ($inputByDigit as $digit){
        $numberOfOnesInEachPosition[$index] = $numberOfOnesInEachPosition[$index] + intval($digit);
        $index = $index + 1;
    }
}

$index = 0;
$halfAmount = $counter / 2;
foreach ($numberOfOnesInEachPosition as $digit){
    if($digit > $halfAmount){
        $gamma[$index] = 1;
        $epsilon[$index] = 0;
    } else {
        $gamma[$index] = 0;
        $epsilon[$index] = 1;
    }
    $index = $index + 1;
}

$binary_string = implode("", $epsilon);
$binary_string2 = implode("", $gamma);
echo bindec($binary_string) * bindec(implode("",$gamma));
echo "<br>";

//PART TWO
$inputByDigit = str_split($allInputs[0]);
$numberOfOnesInEachPositionOxy = array_fill(0,count($inputByDigit),0);
$numberOfOnesInEachPositionCo2 = array_fill(0,count($inputByDigit),0);

$oxygen = array();
$co2 = array();

$counter = 0;
foreach ($allInputs as $input){
    $counter = $counter + 1;
    $inputByDigit = str_split($input);
    $index = 0;
    foreach ($inputByDigit as $digit){
        $numberOfOnesInEachPositionOxy[$index] = $numberOfOnesInEachPositionOxy[$index] + intval($digit);
        $numberOfOnesInEachPositionCo2[$index] = $numberOfOnesInEachPositionCo2[$index] + intval($digit);
        $index = $index + 1;
    }
    array_push($oxygen,$input);
    array_push($co2,$input);
}


$counterOxy = $counter;
$counterCo2 = $counter;

$numberOfDigits = count(str_split($allInputs[0]));

for ($bitIndex = 0; $bitIndex < $numberOfDigits; $bitIndex++) {

    $halfAmountOxy = $counterOxy / 2;
    $oxygenMostCommonIsOne = $numberOfOnesInEachPositionOxy[$bitIndex] >= $halfAmountOxy;
    for ($j = 0; $j < count($oxygen); $j++) {
        $inputByDigit = str_split($oxygen[$j]);
        if($oxygenMostCommonIsOne && count($oxygen) > 1){
            if($inputByDigit[$bitIndex] != 1){
                $numberOfOnesInEachPositionOxy = removeEntryFromMostCommon($inputByDigit,$numberOfOnesInEachPositionOxy);
                $counterOxy--;
                array_splice($oxygen, $j, 1);
                $j--;
            }
        }
        //0 is most common
        else if(count($oxygen) > 1){
            if($inputByDigit[$bitIndex] != 0){
                $numberOfOnesInEachPositionOxy = removeEntryFromMostCommon($inputByDigit,$numberOfOnesInEachPositionOxy);
                $counterOxy--;
                array_splice($oxygen, $j, 1);
                $j--;
            }
        }
    }

    $halfAmountCo2 = $counterCo2 / 2;
    $co2MostCommonIsOne = $numberOfOnesInEachPositionCo2[$bitIndex] >= $halfAmountCo2;
    for ($j = 0; $j < count($co2); $j++) {
        $inputByDigit = str_split($co2[$j]);
        if($co2MostCommonIsOne && count($co2) > 1){
            if($inputByDigit[$bitIndex] == 1){
                $numberOfOnesInEachPositionCo2 = removeEntryFromMostCommon($inputByDigit,$numberOfOnesInEachPositionCo2);
                $counterCo2--;
                array_splice($co2, $j, 1);
                $j--;
            }
        }
        //0 is most common
        else if(count($co2) > 1){
            if($inputByDigit[$bitIndex] == 0){
                $numberOfOnesInEachPositionCo2 = removeEntryFromMostCommon($inputByDigit,$numberOfOnesInEachPositionCo2);
                $counterCo2--;
                array_splice($co2, $j, 1);
                $j--;
            }
        }
    }
}

echo bindec($oxygen[0]) * bindec($co2[0]);
echo "<br>";


function removeEntryFromMostCommon($entry, $mostCommon){
    for ($j = 0; $j < count($entry); $j++) {
        $mostCommon[$j] = $mostCommon[$j] - $entry[$j];
    }
    return $mostCommon;
}
?>