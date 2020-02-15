# PHP 7+ Blog Application Examples

* *php >= 7.2*
* Extended Coding Style: [PSR-12](https://www.php-fig.org/psr/psr-12/)

## Branches

* [Beginning](https://github.com/pronist/phpblog/tree/beginning) - **Classical Architecture**
* [Basic](https://github.com/pronist/phpblog/tree/basic) - **Similar to MVC(Model, View, Controller)**

## Getting started

```bash
# PHP Built-in Server
php -S localhost:8080 -t public
```

## Database (MySQL)

```sql
use phpblog;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL
);

CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL,

    FOREIGN KEY(user_id) REFERENCES users(id)
);
```

## Commands

Name|Description|
----|-----------|
composer run **lint**|*PHPCS* with *[PSR-12](https://www.php-fig.org/psr/psr-12/)*
npm run **lint**|*ESLint*

## Basic - Similar to MVC(Model, View, Controller)

<p>
    <img src="https://travis-ci.com/pronist/phpblog.svg?branch=basic">
    <img src="https://github.styleci.io/repos/231950937/shield?branch=basic" alt="StyleCI">
</p>

* URL is endswith **'.php'**
* Only using **GET**, **POST** HTTP Method
* No **Testing and Logging**
* Not using **OOP(Object-Oriented Programming)**
* Not using **PSR-4 Autoloading**

### Dynamic Extensions

* *MySQLi*
* *Multibyte String*
* *fileinfo*

### Features

<https://github.com/pronist/phpblog/tree/basic/bootstrap/app.php>

#### Index

* [/](https://github.com/pronist/phpblog/tree/basic/public/index.php) - **Show** Posts (GET)

#### Auth

* [/auth/login.php](https://github.com/pronist/phpblog/tree/basic/public/auth/login.php) - Login **Form** for a User (GET)
* [/auth/login.php](https://github.com/pronist/phpblog/tree/beginning/auth/login.php) - Create a User **Session** (POST)
* [/auth/logout.php](https://github.com/pronist/phpblog/tree/beginning/auth/logout.php) - Delete a User **Session** (POST)

#### User

* [/user/register.php](https://github.com/pronist/phpblog/tree/basic/public/user/register.php) - Register **Form** for a new User (GET)
* [/user/register.php](https://github.com/pronist/phpblog/tree/basic/public/user/register.php) - **Create** a new User (POST)
* [/user/update.php](https://github.com/pronist/phpblog/tree/basic/public/user/update.php) - Update **Form** for User informations (GET)
* [/user/update.php](https://github.com/pronist/phpblog/tree/basic/public/user/update.php) - **Update** User informations (POST)

#### Post

* [/post/write.php](https://github.com/pronist/phpblog/tree/basic/public/post/write.php) - Write **Form** for a new Post (GET)
* [/post/write.php](https://github.com/pronist/phpblog/tree/basic/public/post/write.php) - **Write** a new Post (POST)
* [/post/read.php?id={id}](https://github.com/pronist/phpblog/tree/basic/public/post/read.php) - **Read** a Post by a post id (GET)
* [/post/update.php?id={id}](https://github.com/pronist/phpblog/tree/basic/public/post/update.php) - Update **Form** for Post informations (GET)
* [/post/update.php?id={id}](https://github.com/pronist/phpblog/tree/basic/public/post/update.php) - **Update** for Post informations (POST)
* [/post/delete.php?id={id}&token={token}](https://github.com/pronist/phpblog/tree/basic/public/post/delete.php) - **Delete** a Post (GET)

#### Image

* [/image/index.php](https://github.com/pronist/phpblog/tree/basic/public/image/index.php) - **Get** a Image (GET)
* [/image/index.php](https://github.com/pronist/phpblog/tree/basic/public/image/index.php) - **Upload** a Image (POST)

## License

[MIT](https://github.com/pronist/phpblog/blob/basic/LICENSE)

Copyright 2020. [SangWoo Jeong](https://github.com/pronist). All rights reserved.
