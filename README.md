## What is this?

A simple **blog application** example with *PHP 7+* \
this one is created for [phplec](https://github.com/pronist/phplec)

* *php >= 7.2*
* Extended Coding Style: [PSR-12](https://www.php-fig.org/psr/psr-12/)

### Branches

* [Basic](https://github.com/pronist/phpblog/tree/basic) - **Classic Architecture**

### Getting started

```bash
# PHP Built-in Server at http://localhost:8080
php -S localhost:8080 -t public
```

### Testing

```bash
# Installation phpunit
composer install
# Unit Testing
vendor/bin/phpunit --verbose
# Coverage
vendor/bin/phpunit --coverage-text
```

### Database (MySQL)

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

## Basic - Classic Architecture

<p>
    <img src="https://travis-ci.com/pronist/phpblog.svg?branch=basic">
    <img src="https://github.styleci.io/repos/231950937/shield?branch=basic" alt="StyleCI">
</p>

* Not using **OOP(Object-Oriented Programming)**
* Not using **PSR-4 Autoloading**
* Not using **User components** in Application Code

### Dynamic Extensions

* *MySQLi*
* *Multibyte String*
* *fileinfo*

### Features

#### Auth

* [/login.php](https://github.com/pronist/phpblog/tree/basic/controllers/login.php) - Login **Form** for a User (GET)
* [/login.php](https://github.com/pronist/phpblog/tree/basic/controllers/login.php) - Create a User **Session** (POST)
* [/logout.php](https://github.com/pronist/phpblog/tree/basic/controllers/logout.php) - Delete a User **Session** (POST)

#### User

* [/user/register.php](https://github.com/pronist/phpblog/tree/basic/controllers/user/register.php) - Register **Form** for a new User (GET)
* [/user/](https://github.com/pronist/phpblog/tree/basic/controllers/user/index.php) - **Create** a new User (POST)
* [/user/update.php](https://github.com/pronist/phpblog/tree/basic/controllers/user/update.php) - Update **Form** for User informations (GET)
* [/user/](https://github.com/pronist/phpblog/tree/basic/controllers/user/index.php) - **Update** User informations (PATCH)

#### Post

* [/](https://github.com/pronist/phpblog/tree/basic/controllers/index.php) - **Get** posts (GET)
* [/post/write.php](https://github.com/pronist/phpblog/tree/basic/controllers/post/write.php) - Write **Form** for a new Post (GET)
* [/post/](https://github.com/pronist/phpblog/tree/basic/controllers/post/index.php) - **Write** a new Post (POST)
* [/post/?id={id}](https://github.com/pronist/phpblog/tree/basic/controllers/post/index.php) - **Read** a Post by a post id (GET)
* [/post/update.php?id={id}](https://github.com/pronist/phpblog/tree/basic/controllers/post/update.php) - Update **Form** for Post informations (GET)
* [/post/?id={id}](https://github.com/pronist/phpblog/tree/basic/controllers/post/index.php) - **Update** for Post informations (PATCH)
* [/post/?id={id}](https://github.com/pronist/phpblog/tree/basic/controllers/post/index.php) - **Delete** a Post (DELETE)

#### Image

* [/image/](https://github.com/pronist/phpblog/tree/basic/controllers/image/index.php) - **Upload** a Image (POST)
* [/image/?id={id}](https://github.com/pronist/phpblog/tree/basic/controllers/image/index.php) - **Get** a Image (GET)

## License

[MIT](https://github.com/pronist/phpblog/blob/basic/LICENSE)

Copyright (c) [SangWoo Jeong](https://github.com/pronist). All rights reserved.
