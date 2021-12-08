<?php

    $file = file_get_contents("sampleInput.txt", true);
    $file = file_get_contents("input.txt", true);
    $allInputs = explode("\n", $file);
    $bingoCalls = explode(",", $allInputs[0]);


    //PART ONE
    $boards = parseBoards(array_slice($allInputs, 2));

    echo "<br>start";
    echo "<br>";
    $indexOfWinningBoard = -1;
    $sumOfWinningBoard = 0;
    $numberJustCalled = 0;
    for ($i = 0; $i < count($bingoCalls); $i++)
    {
        $numberJustCalled = $bingoCalls[$i];
        $boards = tickOffBoards($numberJustCalled, $boards);
        $indexOfWinningBoard = checkForWin($boards);
        if ($indexOfWinningBoard != -1)
        {
            $sumOfWinningBoard = sumOfGivenBoard($boards[$indexOfWinningBoard]);
            break;
        }
    }
    echo "<br>";
    echo $numberJustCalled;
    echo "<br>";
    echo $sumOfWinningBoard;
    echo "<br>";
    echo $numberJustCalled * $sumOfWinningBoard;


    //PART Two
    $boards = parseBoards(array_slice($allInputs, 2));


    echo "<br>start";
    echo "<br>";
    $indexOfWinningBoard = -1;
    $sumOfWinningBoard = 0;
    $numberJustCalled = 0;
    $numberOfBoards = count($boards);
    $alreadyWon = array();
    for ($i = 0; $i < count($bingoCalls); $i++)
    {
        $numberJustCalled = $bingoCalls[$i];
        $boards = tickOffBoards($numberJustCalled, $boards);
        $indexOfWinningBoard = checkForWinAdv($boards, $alreadyWon);
        if ($indexOfWinningBoard != -1)
        {
            $sumOfWinningBoard = sumOfGivenBoard($boards[$indexOfWinningBoard]);
            array_push($alreadyWon, $indexOfWinningBoard);
        }
        if (count($alreadyWon) == $numberOfBoards)
        {
            break;
        }
        while ($indexOfWinningBoard != -1)
        {
            $indexOfWinningBoard = checkForWinAdv($boards, $alreadyWon);
            if ($indexOfWinningBoard != -1)
            {
                $sumOfWinningBoard = sumOfGivenBoard($boards[$indexOfWinningBoard]);
                array_push($alreadyWon, $indexOfWinningBoard);
            }
        }
        if (count($alreadyWon) == $numberOfBoards)
        {
            break;
        }
    }
    echo "<br>";
    echo $numberJustCalled;
    echo "<br>";
    echo $sumOfWinningBoard;
    echo "<br>";
    echo $numberJustCalled * $sumOfWinningBoard;


    function parseBoards($input)
    {
        $boards = array();
        $board = array();
        for ($i = 0; $i < count($input); $i++)
        {
            if ($input[$i] == "")
            {
                if (count($board) > 0)
                {
                    array_push($boards, $board);
                    $board = array();
                }
            }
            else
            {
                $row = array();
                for ($j = 0; $j < 5; $j++)
                {
                    $var = intval(implode("", array_slice(str_split($input[$i]), $j * 2 + $j, 2)));
                    array_push($row, $var);
                }
                array_push($board, $row);
            }
        }
        array_push($boards, $board);

        return $boards;
    }

    function tickOffBoards($number, $boards)
    {
        //each board
        for ($i = 0; $i < count($boards); $i++)
        {
            //each row
            for ($j = 0; $j < count($boards[$i]); $j++)
            {
                //each item
                for ($k = 0; $k < count($boards[$i][$j]); $k++)
                {
                    if ($boards[$i][$j][$k] == $number)
                    {
                        $boards[$i][$j][$k] = "X";
                    }
                }
            }
        }
        return $boards;
    }

    function checkForWin($boards)
    {
        $rowsIndex = checkForRows($boards);
        $coloumnIndex = checkForColoumns($boards);
        if ($rowsIndex != -1)
        {
            return $rowsIndex;
        }
        else if ($coloumnIndex)
        {
            return $coloumnIndex;
        }
        else
        {
            return -1;
        }
    }

    function checkForWinAdv($boards, $alreadyWon)
    {
        $rowsIndex = checkForRowsAdv($boards, $alreadyWon);
        if ($rowsIndex != -1)
        {
            if (!in_array($rowsIndex, $alreadyWon))
            {
                return $rowsIndex;
            }
        }
        $coloumnIndex = checkForColoumnsAdv($boards, $alreadyWon);
        if ($coloumnIndex)
        {
            if (!in_array($coloumnIndex, $alreadyWon))
            {
                return $coloumnIndex;
            }
        }
        return -1;
    }

    function checkForRows($boards)
    {
        //each board
        for ($i = 0; $i < count($boards); $i++)
        {
            //each row
            for ($j = 0; $j < count($boards[$i]); $j++)
            {
                $allXs = true;
                //each item
                for ($k = 0; $k < count($boards[$i][$j]); $k++)
                {
                    if ($boards[$i][$j][$k] != "X")
                    {
                        $allXs = false;
                    }
                }
                if ($allXs)
                {
                    return $i;
                }
            }
        }
        return -1;
    }

    function checkForRowsAdv($boards,$alreadyWon)
    {
        //each board
        for ($i = 0; $i < count($boards); $i++)
        {
            //each row
            for ($j = 0; $j < count($boards[$i]); $j++)
            {
                $allXs = true;
                //each item
                for ($k = 0; $k < count($boards[$i][$j]); $k++)
                {
                    if ($boards[$i][$j][$k] != "X")
                    {
                        $allXs = false;
                    }
                }
                if ($allXs)
                {
                    if (!in_array($i, $alreadyWon))
                    {
                        return $i;
                    }
                    $allXs = false;
                }
            }
        }
        return -1;
    }

    function checkForColoumns($boards)
    {
        //each board
        for ($i = 0; $i < count($boards); $i++)
        {
            //each coloumn
            for ($j = 0; $j < count($boards[$i][0]); $j++)
            {
                $allXs = true;
                //each index
                for ($k = 0; $k < count($boards[$i]); $k++)
                {
                    if ($boards[$i][$k][$j] != "X")
                    {
                        $allXs = false;
                    }
                }
                if ($allXs)
                {
                    return $i;
                }
            }
        }
        return -1;
    }

    function checkForColoumnsAdv($boards, $alreadyWon)
    {
        //each board
        for ($i = 0; $i < count($boards); $i++)
        {
            //each coloumn
            for ($j = 0; $j < count($boards[$i][0]); $j++)
            {
                $allXs = true;
                //each index
                for ($k = 0; $k < count($boards[$i]); $k++)
                {
                    if ($boards[$i][$k][$j] != "X")
                    {
                        $allXs = false;
                    }
                }
                if ($allXs)
                {
                    if (!in_array($i, $alreadyWon))
                    {
                        return $i;
                    }
                    $allXs = false;
                }
            }
        }
        return -1;
    }

    function sumOfGivenBoard($board)
    {
        //each row
        $sum = 0;
        for ($j = 0; $j < count($board); $j++)
        {
            $allXs = true;
            //each item
            for ($k = 0; $k < count($board[$j]); $k++)
            {
                if ($board[$j][$k] != "X")
                {
                    $sum = $sum + $board[$j][$k];
                }
            }
        }
        return $sum;
    }

?>