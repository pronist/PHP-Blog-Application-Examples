## What is this?

A simple **blog application** example with *PHP 7+* \
this one is created for [phplec](https://github.com/pronist/phplec)

* *php >= 7.2*
* Extended Coding Style: [PSR-12](https://www.php-fig.org/psr/psr-12/)

### Branches

* [Basic](https://github.com/pronist/phpblog/tree/basic) - **Function based MVC(Model, View, Controller)**

### Getting started

```bash
# PHP Built-in Server
php -S localhost:8080 -t public
# Hot reload (Webpack dev server)
npm run watch
```

### Testing

```bash
# Installation phpunit
composer install
# phpunit
composer run test
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

## Basic - Function based MVC(Model, View, Controller)

<p>
    <img src="https://travis-ci.com/pronist/phpblog.svg?branch=basic">
    <img src="https://github.styleci.io/repos/231950937/shield?branch=basic" alt="StyleCI">
</p>

* Not using **OOP(Object-Oriented Programming)**
* Not using **PSR-4 Autoloading**
* Using *Vuejs 2* + *Webpack 4* (Front-end)

### Dynamic Extensions

* *MySQLi*
* *Multibyte String*
* *fileinfo*

### Features

<https://github.com/pronist/phpblog/tree/basic/public/index.php>

#### Auth

* [/auth/login](https://github.com/pronist/phpblog/tree/basic/controllers/Auth.php) - Login **Form** for a User (GET)
* [/auth/login](https://github.com/pronist/phpblog/tree/basic/controllers/Auth.php) - Create a User **Session** (POST)
* [/auth/logout](https://github.com/pronist/phpblog/tree/basic/controllers/Auth.php) - Delete a User **Session** (POST)

#### User

* [/user/register](https://github.com/pronist/phpblog/tree/basic/controllers/User.php) - Register **Form** for a new User (GET)
* [/user/](https://github.com/pronist/phpblog/tree/basic/controllers/User.php) - **Create** a new User (POST)
* [/user/update](https://github.com/pronist/phpblog/tree/basic/controllers/User.php) - Update **Form** for User informations (GET)
* [/user/](https://github.com/pronist/phpblog/tree/basic/controllers/User.php) - **Update** User informations (PATCH)

#### Post

* [/](https://github.com/pronist/phpblog/tree/basic/controllers/Index.php) - **Get** posts (GET)
* [/post/write](https://github.com/pronist/phpblog/tree/basic/controllers/Post.php) - Write **Form** for a new Post (GET)
* [/post/](https://github.com/pronist/phpblog/tree/basic/controllers/Post.php) - **Write** a new Post (POST)
* [/post/{id}](https://github.com/pronist/phpblog/tree/basic/controllers/Post.php) - **Read** a Post by a post id (GET)
* [/post/update/{id}](https://github.com/pronist/phpblog/tree/basic/controllers/Post.php) - Update **Form** for Post informations (GET)
* [/post/{id}](https://github.com/pronist/phpblog/tree/basic/controllers/Post.php) - **Update** for Post informations (PATCH)
* [/post/{id}](https://github.com/pronist/phpblog/tree/basic/controllers/Post.php) - **Delete** a Post (DELETE)

#### Image

* [/image/](https://github.com/pronist/phpblog/tree/basic/controllers/Image.php) - **Upload** a Image (POST)
* [/image/{id}](https://github.com/pronist/phpblog/tree/basic/controllers/Image.php) - **Get** a Image (GET)

### Commands

Name|Description|
----|-----------|
composer run **lint**|*PHPCS* with *[PSR-12](https://www.php-fig.org/psr/psr-12/)*
composer run **test**|*PHPUnit*
npm run **lint**|*ESLint*
npm run **build**|Build with *Webpack*
npm run **watch**|*Webpack Dev Server*

## License

[MIT](https://github.com/pronist/phpblog/blob/basic/LICENSE)

Copyright 2020. [SangWoo Jeong](https://github.com/pronist). All rights reserved.
