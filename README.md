# PHP 7+ Blog Application Examples

* *php >= 7.4*
* Extended Coding Style: [PSR-12](https://www.php-fig.org/psr/psr-12/)

## Branches

* [Beginning](https://github.com/pronist/phpblog/tree/beginning) - **Classical Architecture**
* [Basic](https://github.com/pronist/phpblog/tree/basic) - **Similar to MVC(Model, View, Controller)**
* [Intermediate](https://github.com/pronist/phpblog/tree/intermediate) - **MVC(Model, View, Controller)**

## Getting started

```bash
# PHP Built-in Server
php -S localhost:8080 -t public
```

## Database (MySQL)

```sql
use phpblog;

CREATE TABLE sessions (
    `id` VARCHAR(255) UNIQUE NOT NULL,
    `payload` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `title` VARCHAR(255),
    `content` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY(`user_id`) REFERENCES users(`id`)
);
```

## Commands

Name|Description|
----|-----------|
composer run **lint**|*PHPCS* with *[PSR-12](https://www.php-fig.org/psr/psr-12/)*

## Intermediate -  MVC(Model, View, Controller)

<p>
    <img src="https://travis-ci.com/pronist/phpblog.svg?branch=intermediate">
    <img src="https://github.styleci.io/repos/231950937/shield?branch=intermediate" alt="StyleCI">
</p>

### Dynamic Extensions

* *pdo_mysql*
* *mb_string*
* *fileinfo*

### Features

<https://github.com/pronist/phpblog/tree/intermediate/bootstrap/app.php>

#### Index

* [/](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/index.php) - **Show** Posts (GET)

#### Auth

* [/auth/login](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/auth.php) - Login **Form** for a User (GET)
* [/auth](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/auth.php) - Create a User **Session** (POST)
* [/auth/logout](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/auth.php) - Delete a User **Session** (POST)

#### User

* [/user/register](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/user.php) - Register **Form** for a new User (GET)
* [/user](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/user.php) - **Create** a new User (POST)

#### Post

* [/posts/write](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/post.php) - Write **Form** for a new Post (GET)
* [/posts](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/post.php) - **Write** a new Post (POST)
* [/posts/{id}](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/post.php) - **Read** a Post by a post id (GET)
* [/posts/{id}/edit](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/post.php) - Update **Form** for Post informations (GET)
* [/posts/{id}](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/post.php) - **Update** for Post informations (PATCH)
* [/posts/{id}](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/post.php) - **Delete** a Post (DELETE)

#### Image

* [/image/{path}](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/image.php) - **Get** a Image (GET)
* [/image](https://github.com/pronist/phpblog/blob/intermediate/app/controllers/image.php) - **Upload** a Image (POST)

## License

[MIT](https://github.com/pronist/phpblog/blob/intermediate/LICENSE)

Copyright 2020. [SangWoo Jeong](https://github.com/pronist). All rights reserved.
