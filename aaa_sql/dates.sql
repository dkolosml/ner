-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Версия сервера: 5.6.37
-- Версия PHP: 7.1.7

CREATE TABLE `dates` (
  `id`         INT(11)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date`       DATE      NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
