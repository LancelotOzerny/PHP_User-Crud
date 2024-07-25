<?php
$connection = new PDO('mysql:host=localhost', 'root', '');
echo 'Подключение с MySQL установлено<br/>';

$connection->query('CREATE DATABASE IF NOT EXISTS PetProjects;');
echo 'База данных PetProjects создана<br/>';

$connection->query('CREATE TABLE IF NOT EXISTS `petprojects`.`Users`(
    `id` INT(11) NOT NULL AUTO_INCREMENT , 
    `login` VARCHAR(255) NOT NULL , 
    `email` VARCHAR(255) NOT NULL , 
    `password` VARCHAR(255) NOT NULL , 
    PRIMARY KEY (`id`)) 
    ENGINE = InnoDB;');
echo 'Таблица Users создана<br/>';
?>