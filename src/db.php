<?php


function initDB(): string
{
    $db = new PDO("sqlite:database.db");
    $db->query("PRAGMA foreign_keys = ON;");
    $db->query("CREATE TABLE `categories` (
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
