<?php

function addPost(): string
{

    //TODO реализуйте добавление поста в хранилище db.txt
    //Заголовок и тело поста считывайте тут же через readline
    //обработайте ошибки
    //в случае успеха верните тект что пост добавлен

    $fileName = getcwd() . '/db.txt';

    $file = fopen($fileName, 'a+');

    if (!is_writable($fileName)) {
        return handleError("Файл не доступен для записи");
    }

    do {
        $title = readline("Введите заголовок поста: ");
    } while (empty($title));

    do {
        $text = readline("Введите текст поста: ");
    } while (empty($text));

    $id = 0;
    while (!feof($file)) {
        fgets($file);
        $id++;
    }

    $data = "$id;$title;$text;" . PHP_EOL;

    if (fwrite($file, $data)) {
        fclose($file);
        return "Пост добавлен";
    }

    fclose($file);
    return handleError("Произошла ошибка записи. Данные не сохранены");

}

function readAllPosts(): string
{
    $db = getDb();




    return "";
}

function readPost(): string
{
    //TODO реализуйте чтение одного поста, номер поста считывайте из командной строки
    $fileName = getcwd() . '/db.txt';

    if (!is_readable($fileName)) {
        return handleError("Файл db.txt не читается");
    }

    do {
        $id = (int)readline("Введите id поста: ");
    } while (empty($id));

    $file = fopen($fileName, 'r');

    while (!feof($file)) {
        $line = fgets($file);
        $post = explode(";", $line);
        if ((int)$post[0] === $id) {
            fclose($file);
            return $line;
        }
    }

    return "Пост с id = $id не найден";
}

function clearPosts(): string
{
    //TODO сотрите все посты

    $fileName = getcwd() . '/db.txt';

    if (!is_writable($fileName)) {
        return handleError("Файл не доступен для записи");
    }

    $file = fopen($fileName, 'w');

    if ($file) {
        fclose($file);
        return 'Все посты удалены';
    }

    fclose($file);
    return handleError('Не удалось открыть файл.');

}

function searchPost(): string
{
    //TODO* реализуйте поиск поста по заголовку (можно и по всему телу), поисковый запрос спрашивайте через readline
    $fileName = getcwd() . '/db.txt';

    if (!is_readable($fileName)) {
        return handleError("Файл db.txt не читается");
    }

    do {
        $subTitle = readline("Введите часть текста заголовка для поиска постов: ");
    } while (empty($subTitle));

    $file = fopen($fileName, 'r');

    $str = '';

    while (!feof($file)) {
        $line = fgets($file);
        $post = explode(";", $line);

        if (isset($post[1]) && str_contains($post[1], $subTitle)) {
            $str .= $line;
        }
    }

    fclose($file);

    return $str . "Поиск завершен";
}