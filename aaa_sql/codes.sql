-- phpMyAdmin SQL Dump /* ner app */
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Версия сервера: 5.6.37
-- Версия PHP: 7.1.7

CREATE TABLE `codes` (
  `id`         INT(11)      NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `r030`       INT(11)      NOT NULL,
  `txt`        VARCHAR(250) NOT NULL,
  `cc`         VARCHAR(3)   NOT NULL,
  `created_at` TIMESTAMP    NOT NULL,
  `updated_at` TIMESTAMP    NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE `codes`
  ADD UNIQUE KEY `r030` (`r030`);
