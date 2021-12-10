<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);

    //PART ONE
    $sum = 0;

    for ($j = 0; $j < count($allInputs); $j++)
    {
        $FiLoQueue = array();
        $chars = str_split($allInputs[$j]);
        for ($i = 0; $i < count($chars); $i++)
        {
            $char = $chars[$i];
            if (isOpeningBracket($char))
            {
                array_unshift($FiLoQueue, $char);
            }
            else
            {
                $valueRemoved = array_shift($FiLoQueue);
                if (strcmp($valueRemoved, getOpeningEquivalent($char)) != 0)
                {
                    $sum = $sum + getPoints($char);
                    break;
                }
            }
        }

    }

    echo $sum;
    echo "<br>";


    //PART 2


    $sums = array();
    for ($j = 0; $j < count($allInputs); $j++)
    {
        $sum = 0;
        $FiLoQueue = array();
        $chars = str_split($allInputs[$j]);
        $illegal = false;
        for ($i = 0; $i < count($chars); $i++)
        {
            $char = $chars[$i];
            if (isOpeningBracket($char))
            {
                array_unshift($FiLoQueue, $char);
            }
            else
            {
                $valueRemoved = array_shift($FiLoQueue);
                if (strcmp($valueRemoved, getOpeningEquivalent($char)) != 0)
                {
                    //we dont care about illegal strings this time.
                    $illegal = true;
                    break;
                }
            }
        }

        if($illegal){
            continue;
        }
        for ($i = 0; $i < count($FiLoQueue); $i++)
        {
            $sum = $sum * 5 + getPoints2($FiLoQueue[$i]);
        }
        array_push($sums, $sum);

    }
    sort($sums);
//    print_r($sums);

    echo $sums[(count($sums)+1)/2-1];


    function isOpeningBracket($char)
    {
        if (strcmp($char, "{") == 0 || strcmp($char, "(") == 0 || strcmp($char, "<") == 0 || strcmp($char, "[") == 0)
        {
            return true;
        }
        return false;
    }

    function getOpeningEquivalent($char)
    {
        if (strcmp($char, ")") == 0)
        {
            return "(";
        }
        else if (strcmp($char, "]") == 0)
        {
            return "[";
        }
        else if (strcmp($char, "}") == 0)
        {
            return "{";
        }
        else if (strcmp($char, ">") == 0)
        {
            return "<";
        }
        else
        {
            return "ERROR";
        }
    }

    function getClosingEquivalent($char)
    {
        if (strcmp($char, ")") == 0)
        {
            return "(";
        }
        else if (strcmp($char, "]") == 0)
        {
            return "[";
        }
        else if (strcmp($char, "}") == 0)
        {
            return "{";
        }
        else if (strcmp($char, ">") == 0)
        {
            return "<";
        }
        else
        {
            return "ERROR";
        }
    }

    function getPoints($char)
    {
        if ($char == ')')
        {
            return 3;
        }
        if ($char == ']')
        {
            return 57;
        }
        if ($char == '}')
        {
            return 1197;
        }
        if ($char == '>')
        {
            return 25137;
        }
        return 0;
    }

    function getPoints2($char)
    {
        if ($char == '(')
        {
            return 1;
        }
        if ($char == '[')
        {
            return 2;
        }
        if ($char == '{')
        {
            return 3;
        }
        if ($char == '<')
        {
            return 4;
        }
        return 0;
    }

//    array_shift
//    array_unshift
?>