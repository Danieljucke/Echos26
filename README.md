# Echos26

> Historical / Academic Project — not recently verified

Echos26 is a Symfony web application built around articles, categories, comments,
images, contact requests, stores, sessions, user registration, and profiles. It
is retained as a record of a 2023–2024 PHP project.

## Technology

- PHP 8.1 or newer
- Symfony 6.1, Twig, and Doctrine ORM
- PHPUnit and Symfony test tooling
- Bootstrap and other vendored frontend assets

## Local setup

Install PHP dependencies with `composer install`, configure a local database
through an untracked environment override, apply the Doctrine migrations, and
use the Symfony local server or another PHP web server.

The application has not been recently verified against current dependencies.
Tracked environment files use local/template configuration; never commit live
credentials or mail-service keys.

## Status and licensing

This is a historical project rather than a currently supported production
service. `composer.json` declares the project proprietary; no separate
open-source license is granted.
