<?php

function main(): string
{
    $command = parseCommand();

    if (function_exists($command)) {
        $result = $command();
    } else {
        $result = handleError("Нет такой функции");
    }

    return $result;
}

function parseCommand(): string
{
    //TODO улучшите код, избавтесь от дублирования строки handleHelp
    $functionName = 'handleHelp';
    if(isset($_SERVER['argv'][1])) {
        $functionName = match ($_SERVER['argv'][1]) {
            'help' => 'handleHelp',
            'add-post' => 'addPost',
            default => 'handleHelp'
        };
    }

    return $functionName;
}