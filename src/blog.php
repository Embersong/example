<?php

function addPost(): string
{
    //TODO перевести на БД

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

    $stmt = $db->query("SELECT p.id post_id, c.id cat_id, c.category, p.title, p.text FROM posts p JOIN categories c ON p.id_category = c.id;");
    //TODO Организуйте вывод 1 пост 1 строка в виде текста
    $result = $stmt->fetchAll();
    print_r($result);
    return "";
}

function readPost(): string
{
    $db = getDb();


    do {
        $id = (int)readline("Введите id поста: ");
    } while (empty($id));

    $stmt = $db->prepare("SELECT * FROM posts p JOIN categories c ON p.id_category = c.id WHERE p.id = :id;");

    $stmt->execute(['id' => $id]);
//TODO вывести текстом пост
    print_r($stmt->fetch());

    return "Пост с id = $id не найден";
}

function clearPosts(): string
{
    //TODO перевести на БД

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
    //TODO перевести на БД
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