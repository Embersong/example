<?php

function getDb(): PDO
{
    static $db = null;
    if (is_null($db)) {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    return $db;
}

function initDB(): string
{
    $db = getDb();

    $db->query("PRAGMA foreign_keys = ON;");
    $db->query("CREATE TABLE IF NOT EXISTS `categories` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`category` TEXT NOT NULL
);");
    $db->query("CREATE TABLE IF NOT EXISTS `posts` (
	`id` INTEGER  PRIMARY KEY AUTOINCREMENT UNIQUE,
	`title` TEXT NOT NULL,
	`text` TEXT NOT NULL,
	`id_category` INTEGER,
FOREIGN KEY(`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT
);");

    return "Структура БД построена";
}

function seedDB(): string
{
    $db = getDb();
    initDB();
    $db->query("DELETE FROM posts;");
    $db->query("DELETE FROM categories;");
    $db->query("INSERT INTO categories VALUES (1, 'News'),(2, 'Politics'),(3, 'Sport');");

    $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 1);");
    $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 1);");
    $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 2);");
    $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 2);");
    $db->query("INSERT INTO posts (title, text, id_category) VALUES ('Title 1', 'Text text lorem', 3);");

    return "Данные добавлены";
}