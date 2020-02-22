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

* [/](https://github.com/pronist/phpblog/blob/basic/controllers/index.php#L8) - **Show** Posts (GET)

#### Auth

* [/auth/login](https://github.com/pronist/phpblog/blob/basic/controllers/auth.php#L6) - Login **Form** for a User (GET)
* [/auth/login](https://github.com/pronist/phpblog/blob/basic/controllers/auth.php#L16) - Create a User **Session** (POST)
* [/auth/logout](https://github.com/pronist/phpblog/blob/basic/controllers/auth.php#L34) - Delete a User **Session** (GET)

#### User

* [/user/register](https://github.com/pronist/phpblog/blob/basic/controllers/user.php#L6) - Register **Form** for a new User (GET)
* [/user/register](https://github.com/pronist/phpblog/blob/basic/controllers/user.php#L16) - **Create** a new User (POST)
* [/user/update](https://github.com/pronist/phpblog/blob/basic/controllers/user.php#L26) - Update **Form** for User informations (GET)
* [/user/update](https://github.com/pronist/phpblog/blob/basic/controllers/user.php#L39) - **Update** User informations (POST)

#### Post

* [/post/write](https://github.com/pronist/phpblog/blob/basic/controllers/post.php#L6) - Write **Form** for a new Post (GET)
* [/post/write](https://github.com/pronist/phpblog/blob/basic/controllers/post.php#L16) - **Write** a new Post (POST)
* [/post/read?id={id}](https://github.com/pronist/phpblog/blob/basic/controllers/post.php#L30) - **Read** a Post by a post id (GET)
* [/post/update?id={id}](https://github.com/pronist/phpblog/blob/basic/controllers/post.php#L43) - Update **Form** for Post informations (GET)
* [/post/update?id={id}](https://github.com/pronist/phpblog/blob/basic/controllers/post.php#L57) - **Update** for Post informations (POST)
* [/post/delete?id={id}&token={token}](https://github.com/pronist/phpblog/blob/basic/controllers/post.php#L70) - **Delete** a Post (GET)

#### Image

* [/image](https://github.com/pronist/phpblog/blob/basic/controllers/image.php#L32) - **Get** a Image (GET)
* [/image](https://github.com/pronist/phpblog/blob/basic/controllers/image.php#L6) - **Upload** a Image (POST)

## License

[MIT](https://github.com/pronist/phpblog/blob/basic/LICENSE)

Copyright 2020. [SangWoo Jeong](https://github.com/pronist). All rights reserved.
