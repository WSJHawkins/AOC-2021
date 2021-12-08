<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);


    //PART ONE
    $allOutputs = array();
    for ($j = 0; $j < count($allInputs); $j++)
    {
        array_push($allOutputs, explode(" ", explode(" | ", $allInputs[$j])[1]));
    }

    $count = 0;
    for ($j = 0; $j < count($allOutputs); $j++)
    {
        for ($k = 0; $k < count($allOutputs[$j]); $k++)
        {
            if (strlen($allOutputs[$j][$k]) == 2 || strlen($allOutputs[$j][$k]) == 3 || strlen($allOutputs[$j][$k]) == 4 || strlen($allOutputs[$j][$k]) == 7)
            {
                $count++;
            }
        }
    }

    echo $count;
    echo "<br>";

    //PART TWO
    $allSignals = array();
    for ($j = 0; $j < count($allInputs); $j++)
    {
        array_push($allSignals, explode(" ", explode(" | ", $allInputs[$j])[0]));
    }

    $sum = 0;
    $numbersToLetters = array();

    for ($i = 0; $i < count($allSignals); $i++)
    {
        //FIND EASY IDENTIFIABLE OPTIONS (ONES BY LENGTH ALONE)
        $numbersToLetters = getEasyIdentifiable($allSignals[$i], $numbersToLetters);

        //APPLY DEDUCTION LOGIC TO WORK OUT THE REST
        $numbersToLetters = findRestOfInputs($allSignals[$i], $numbersToLetters);

        //NOW WE KNOW WHAT INPUTS GIVE WHAT NUMBERS LETS SUSS OUTPUTS
        $number = getNumberRepresentedByOutput($allOutputs[$i], $numbersToLetters);

        //php so we can cast lazy
        $sum = $sum + $number;
    }

    echo $sum;
    //END


    //FUNCTIONS
    function getEasyIdentifiable($allSignals, array $numbersToLetters)
    {
        for ($j = 0; $j < count($allSignals); $j++)
        {
            $input = $allSignals[$j];
            if (strlen($input) == 2)
            {
                $numbersToLetters[1] = $input;
            }
            else if (strlen($input) == 3)
            {
                $numbersToLetters[7] = $input;
            }
            else if (strlen($input) == 4)
            {
                $numbersToLetters[4] = $input;
            }
            else if (strlen($input) == 7)
            {
                $numbersToLetters[8] = $input;
            }
        }
        return $numbersToLetters;
    }

    function findRestOfInputs($allSignals, array $numbersToLetters)
    {
        for ($j = 0; $j < count($allSignals); $j++)
        {
            $input = $allSignals[$j];
            if (strlen($input) == 6)
            {
                $b = findLettersFor(4, $numbersToLetters);
                if (contains($input, $b))
                {
                    $numbersToLetters[9] = $input;
                }
                else if (contains($input, findLettersFor(7, $numbersToLetters)))
                {
                    $numbersToLetters[0] = $input;
                }
                else
                {
                    $numbersToLetters[6] = $input;
                }
            }
        }

        for ($j = 0; $j < count($allSignals); $j++)
        {
            $input = $allSignals[$j];
            if (strlen($input) == 5)
            {
                if (contains($input, findLettersFor(7, $numbersToLetters)))
                {
                    $numbersToLetters[3] = $input;
                }
                else if (contains($input, differenceBetween(findLettersFor(1, $numbersToLetters), findLettersFor(6, $numbersToLetters))))
                {
                    $numbersToLetters[2] = $input;
                }
                else
                {
                    $numbersToLetters[5] = $input;
                }
            }
        }
        return $numbersToLetters;
    }

    function getNumberRepresentedByOutput($allOutputs, array $numbersToLetters)
    {
        $number = "";
        for ($j = 0; $j < count($allOutputs); $j++)
        {
            $value = 0;
            for ($k = 0; $k < count($numbersToLetters); $k++)
            {
                if (matches($numbersToLetters[$k], $allOutputs[$j]))
                {
                    $value = $k;
                    break;
                }
            }
            $number = $number . $value;
        }
        return $number;
    }


    function contains($a, $b)
    {
        $counter = 0;
        $valsToFind = str_split($b);
        for ($j = 0; $j < count($valsToFind); $j++)
        {
            if (strpos($a, $valsToFind[$j]) !== false) {
                $counter++;
            }
        }
        if(count($valsToFind) == $counter){
         return true;
        } else{
            return false;
        }
    }

    function matches($a, $b)
    {
        if(strlen($a) != strlen($b)){
            return false;
        }
        $counter = 0;
        $valsToFind = str_split($b);
        for ($j = 0; $j < count($valsToFind); $j++)
        {
            if (strpos($a, $valsToFind[$j]) !== false) {
                $counter++;
            }
        }
        if(strlen($a) == $counter){
            return true;
        } else{
            return false;
        }
    }

    function differenceBetween($a, $b)
    {
        $val = $a;
        $array = str_split($b);
        for ($j = 0; $j < count($array); $j++)
        {
            if (strpos($a, $array[$j]) !== false)
            {
                $val = str_replace($array[$j], "", $val);
            }
        }
        return $val;
    }

    function findLettersFor($num, $numbersToLetters)
    {
        return $numbersToLetters[$num];
    }

?>