<?php

function handleError(string $error): string
{
    return "\033[31m" . $error . " \r\n \033[97m";
}

function handleHelp(): string
{

    $help = <<<HELP
Доступные команды
help - вывод данной подсказки
init - инициализация структуры БД
seed - заполнит БД фейковыми данными
add-post - создать новый пост
read-all - показать все посты
clear-all - стереть все посты
read-post - показать 1 пост
find-posts - поиск поста
delete-post - удаление поста по id

HELP;


    return $help;
}