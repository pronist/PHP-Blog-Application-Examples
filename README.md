# PHP 7+ Blog Application Examples

* *php >= 7.2*
* Extended Coding Style: [PSR-12](https://www.php-fig.org/psr/psr-12/)

## Branches

* [Beginning](https://github.com/pronist/phpblog/tree/beginning) - **Classic - Legacy**
* [Basic](https://github.com/pronist/phpblog/tree/basic) - **VC(View, Controller) - Functional**
* [Intermediate](https://github.com/pronist/phpblog/tree/intermediate) - **MVC(Model, View, Controller) - OOP**

## Getting started

```bash
# PHP Built-in Server
php -S localhost:8080
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

## Beginning - Classical Architecture

<p>
    <img src="https://travis-ci.com/pronist/phpblog.svg?branch=beginning">
    <img src="https://github.styleci.io/repos/231950937/shield?branch=beginning" alt="StyleCI">
</p>

* URL is endswith **'.php'**
* Only using **GET**, **POST** HTTP Method
* Execution environment and view is not separated from **Application Logic**
* Only using **PHP built-in Functions**
* **Document root directory** is not safe
* Not using **OOP(Object-Oriented Programming)**
* Not using **PSR-4 Autoloading**

### Features

<https://github.com/pronist/phpblog/tree/beginning/bootstrap/app.php>

#### Index

* [/](https://github.com/pronist/phpblog/tree/beginning/index.php) - **Show** Posts (GET)

#### Auth

* [/auth/login.php](https://github.com/pronist/phpblog/tree/beginning/auth/login.php) - Login **Form** for a User (GET)
* [/auth/login_process.php](https://github.com/pronist/phpblog/tree/beginning/auth/login_process.php) - Create a User **Session** (POST)
* [/auth/logout.php](https://github.com/pronist/phpblog/tree/beginning/auth/logout.php) - Delete a User **Session** (GET)

#### User

* [/user/register.php](https://github.com/pronist/phpblog/tree/beginning/user/register.php) - Register **Form** for a new User (GET)
* [/user/register_process.php](https://github.com/pronist/phpblog/tree/beginning/user/register_process.php) - **Create** a new User (POST)
* [/user/update.php](https://github.com/pronist/phpblog/tree/beginning/user/update.php) - Update **Form** for User informations (GET)
* [/user/update_process.php](https://github.com/pronist/phpblog/tree/beginning/user/update_proess.php) - **Update** User informations (POST)

#### Post

* [/post/write.php](https://github.com/pronist/phpblog/tree/beginning/post/write.php) - Write **Form** for a new Post (GET)
* [/post/write_process.php](https://github.com/pronist/phpblog/tree/beginning/post/write_process.php) - **Write** a new Post (POST)
* [/post/read.php?id={id}](https://github.com/pronist/phpblog/tree/beginning/post/read.php) - **Read** a Post by a post id (GET)
* [/post/update.php?id={id}](https://github.com/pronist/phpblog/tree/beginning/post/update.php) - Update **Form** for Post informations (GET)
* [/post/update_process.php?id={id}](https://github.com/pronist/phpblog/tree/beginning/post/update_process.php) - **Update** for Post informations (POST)
* [/post/delete_process.php?id={id}&token={token}](https://github.com/pronist/phpblog/tree/beginning/post/delete_process.php) - **Delete** a Post (GET)

#### Image

* [/image/upload.php](https://github.com/pronist/phpblog/tree/beginning/image/upload.php) - **Upload** a Image (POST)

## License

[MIT](https://github.com/pronist/phpblog/blob/beginning/LICENSE)

Copyright 2020. [SangWoo Jeong](https://github.com/pronist). All rights reserved.
