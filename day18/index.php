<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    $parsedInput = parseInput($allInputs);
//    printSnailNumbers($parsedInput);
//    echo "<br>";

    $number = $parsedInput[0];

    //for all additions
    for ($input = 1; $input < count($parsedInput); $input++)
    {
        $number = array($number, $parsedInput[$input]);
        $endLoop = false;
        do
        {
            list($thingsToAdd, $number) = explodeFirstPair($number, 0);
            if (!empty($thingsToAdd))
            {
                continue;
            }

            list($howManySplits, $number) = splitFirstNumber($number);
            if ($howManySplits > 0)
            {
                continue;
            }
            $endLoop = true;
        } while (!$endLoop);
    }

    //work out score
    echo "<br>SCORE:";
    echo magnitude($number);
    echo "<br>";


    //PART TWO
    $parsedInput = parseInput($allInputs);

    $max = 0;
    //for all additions
    for ($input = 0; $input < count($parsedInput); $input++)
    {
        for ($input2 = $input+1; $input2 < count($parsedInput); $input2++)
        {
            $number = $parsedInput[$input];
            $number = array($number, $parsedInput[$input2]);
            $endLoop = false;
            do
            {
                list($thingsToAdd, $number) = explodeFirstPair($number, 0);
                if (!empty($thingsToAdd))
                {
                    continue;
                }

                list($howManySplits, $number) = splitFirstNumber($number);
                if ($howManySplits > 0)
                {
                    continue;
                }
                $endLoop = true;
            } while (!$endLoop);
            $score = magnitude($number);
            if($score > $max){
                $max = $score;
            }
        }
    }

    //not commutative
    for ($input = 0; $input < count($parsedInput); $input++)
    {
        for ($input2 = $input+1; $input2 < count($parsedInput); $input2++)
        {
            $number = $parsedInput[$input2];
            $number = array($number, $parsedInput[$input]);
            $endLoop = false;
            do
            {
                list($thingsToAdd, $number) = explodeFirstPair($number, 0);
                if (!empty($thingsToAdd))
                {
                    continue;
                }

                list($howManySplits, $number) = splitFirstNumber($number);
                if ($howManySplits > 0)
                {
                    continue;
                }
                $endLoop = true;
            } while (!$endLoop);
            $score = magnitude($number);
            if($score > $max){
                $max = $score;
            }
        }
    }

    //work out score
    echo "<br>SCORE:".$max;
    echo "<br>";

    function parseInput($input)
    {
        $parsedInput = array();
        for ($line = 0; $line < count($input); $line++)
        {
            array_push($parsedInput, json_decode($input[$line]));
        }
        return $parsedInput;
    }


    function explodeFirstPair($number, $depth)
    {
        $thingsToAdd = array();
        if (is_array($number[0]))
        {
            if ($depth >= 3)
            {
                insistOnlyContainsRegularNumbers($number[0]);
                $thingsToAdd = array($number[0][0], $number[0][1]);
                $number[0] = 0;

                if (!empty($thingsToAdd) && $thingsToAdd[1] != 0)
                {
                    if (!is_array($number[1]))
                    {
                        $number[1] += $thingsToAdd[1];
                    }
                    else
                    {
                        list($ignore, $number[1]) = addRight($number[1], $thingsToAdd[1]);
                    }
                }
                $thingsToAdd[1] = 0;

                return array($thingsToAdd, $number);
            }
            else
            {
                list($thingsToAdd, $number[0]) = explodeFirstPair($number[0], $depth + 1);
                if (!empty($thingsToAdd))
                {
                    if ($thingsToAdd[1] != 0)
                    {
                        if (!is_array($number[1]))
                        {
                            $number[1] += $thingsToAdd[1];
                        }
                        else
                        {
                            list($ignore, $number[1]) = addRight($number[1], $thingsToAdd[1]);
                        }
                        $thingsToAdd[1] = 0;
                    }
                    return array($thingsToAdd, $number);
                }
            }
        }
        if (is_array($number[1]))
        {
            if ($depth >= 3)
            {
                insistOnlyContainsRegularNumbers($number[1]);
                $thingsToAdd = array($number[1][0], $number[1][1]);
                $number[1] = 0;

                if (!empty($thingsToAdd) && $thingsToAdd[0] != 0 && !is_array($number[0]))
                {
                    $number[0] += $thingsToAdd[0];
                    $thingsToAdd[0] = 0;
                }

                return array($thingsToAdd, $number);
            }
            else
            {
                list($thingsToAdd, $number[1]) = explodeFirstPair($number[1], $depth + 1);
                if (!empty($thingsToAdd) && $thingsToAdd[0] != 0)
                {
                    if (!is_array($number[0]))
                    {
                        $number[0] += $thingsToAdd[0];
                    }
                    else
                    {
                        list($ignore, $number[0]) = addLeft($number[0], $thingsToAdd[0]);
                    }
                    $thingsToAdd[0] = 0;
                    return array($thingsToAdd, $number);
                }
            }
        }
        return array($thingsToAdd, $number);
    }

    function addRight($number, $amountToAdd)
    {
        if (!is_array($number[0]))
        {
            $number[0] += $amountToAdd;
            return array(true, $number);
        }
        else
        {
            list($bool, $number[0]) = addRight($number[0], $amountToAdd);
            if ($bool)
            {
                return array(true, $number);
            }
        }
        if (!is_array($number[1]))
        {
            $number[1] += $amountToAdd;
            return array(true, $number);
        }
        else
        {
            list($bool, $number[1]) = addRight($number[1], $amountToAdd);
            if ($bool)
            {
                return array(true, $number);
            }
        }
        return array(false, $number);
    }

    function addLeft($number, $amountToAdd)
    {
        if (!is_array($number[1]))
        {
            $number[1] += $amountToAdd;
            return array(true, $number);
        }
        else
        {
            list($bool, $number[1]) = addLeft($number[1], $amountToAdd);
            if ($bool)
            {
                return array(true, $number);
            }
        }
        if (!is_array($number[0]))
        {
            $number[0] += $amountToAdd;
            return array(true, $number);
        }
        else
        {
            list($bool, $number[0]) = addLeft($number[0], $amountToAdd);
            if ($bool)
            {
                return array(true, $number);
            }
        }
        return array(false, $number);
    }

    function insistOnlyContainsRegularNumbers($number)
    {
        if (is_array($number[0]) || is_array($number[1]))
        {
            exit("THIS SHOULD NOT HAPPEN, THIS IS IN HERE FOR SANITY");
        }
    }

    function splitFirstNumber($number)
    {
        if (is_array($number[0]))
        {
            list($howManySplitsInThisCall, $number[0]) = splitFirstNumber($number[0]);
            if ($howManySplitsInThisCall == 1)
            {
                return array(1, $number);
            }
        }
        else
        {
            if ($number[0] >= 10)
            {
                $number[0] = splitNumber($number[0]);
                return array(1, $number);
            }
        }
        if (is_array($number[1]))
        {
            list($howManySplitsInThisCall, $number[1]) = splitFirstNumber($number[1]);
            if ($howManySplitsInThisCall == 1)
            {
                return array(1, $number);
            }
        }
        else
        {
            if ($number[1] >= 10)
            {
                $number[1] = splitNumber($number[1]);
                return array(1, $number);
            }
        }
        return array(0, $number);
    }

    function splitNumber($num)
    {
        return array(floor($num / 2), ceil($num / 2));
    }

    function printSnailNumber($number)
    {
        echo "[";
        if (is_array($number[0]))
        {
            printSnailNumber($number[0]);
        }
        else
        {
            echo $number[0];
        }
        echo ",";
        if (is_array($number[1]))
        {
            printSnailNumber($number[1]);
        }
        else
        {
            echo $number[1];
        }
        echo "]";
    }

    function printSnailNumbers($numbers)
    {
        for ($line = 0; $line < count($numbers); $line++)
        {
            printSnailNumber($numbers[$line]);
            echo "<br>";
        }
    }

    function magnitude($number)
    {
        $sumLeft = 0;
        $sumRight = 0;
        if (is_array($number[0]))
        {
            $sumLeft = magnitude($number[0]);
        }
        else
        {
            $sumLeft += $number[0];
        }
        if (is_array($number[1]))
        {
            $sumRight = magnitude($number[1]);
        }
        else
        {
            $sumRight += $number[1];
        }
        return 3 * $sumLeft + 2 * $sumRight;
    }

?>