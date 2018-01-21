-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Версия сервера: 5.6.37
-- Версия PHP: 7.1.7

CREATE TABLE `rates` (
  `id`           INT(11)    NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cc`           VARCHAR(3) NOT NULL,
  `r030`         INT(11)    NOT NULL,
  `rate`         DOUBLE     NOT NULL,
  `exchangedate` DATE       NOT NULL,
  `created_at`   TIMESTAMP  NOT NULL,
  `updated_at`   TIMESTAMP  NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

ALTER TABLE `rates`
  ADD KEY `r030` (`r030`),
  ADD KEY `cc` (`cc`);
