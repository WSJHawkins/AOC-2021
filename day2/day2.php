<?php
    $file = file_get_contents("aocDay2.txt", true);
    $allInstructions = explode("\n", $file);

    //PART ONE
    $horizontalPos = 0;
    $verticalPos = 0;
    foreach ($allInstructions as $instruction)
    {
        $instructionDetails = explode(" ", $instruction);
        $instructionType = $instructionDetails[0];
        $instructionAmount = intval($instructionDetails[1]);
        if ($instructionType == "forward")
        {
            $horizontalPos = $horizontalPos + $instructionAmount;
        }
        else if ($instructionType == "up")
        {
            $verticalPos = $verticalPos - $instructionAmount;
        }
        else if ($instructionType == "down")
        {
            $verticalPos = $verticalPos + $instructionAmount;
        }
    }

    echo $horizontalPos * $verticalPos;

    echo "<br>";

    //PART TWO
    $horizontalPos = 0;
    $verticalPos = 0;
    $aim = 0;
    foreach ($allInstructions as $instruction)
    {
        $instructionDetails = explode(" ", $instruction);
        $instructionType = $instructionDetails[0];
        $instructionAmount = intval($instructionDetails[1]);
        if ($instructionType == "forward")
        {
            $horizontalPos = $horizontalPos + $instructionAmount;
            $verticalPos = $verticalPos + ($aim * $instructionAmount);
        }
        else if ($instructionType == "up")
        {
            $aim = $aim - $instructionAmount;
        }
        else if ($instructionType == "down")
        {
            $aim = $aim + $instructionAmount;
        }
    }

    echo $horizontalPos * $verticalPos;
?>