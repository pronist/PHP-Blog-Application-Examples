<p align="center">
    <a href="https://www.inflearn.com/course/php"><img src="https://cdn.inflearn.com/public/files/courses/280298/57e113b0-2f17-494b-a363-6fdc6d0da066/php2.png" width="400"></a>
</p>

<p align="center">
    <img src="https://travis-ci.com/pronist/phpblog.svg?branch=basic">
</p>

## phpblog

**phpblog** is a **BLOG APPLICATION** example with *PHP 7+*. \
this one is created for [phplec](https://github.com/pronist/phplec)

* *php >= 7.2*
* Extended Coding Style: [PSR-12](https://www.php-fig.org/psr/psr-12/)

## Branches

* [Baisc](https://github.com/pronist/phpblog/tree/basic) - PHP **Classic Architecture**

## Basic

* PHP **Classic Architecture** (URL endswith **.php**)
* No **PSR-4 Autoloading**
* No **OOP(Object-Oriented Programming)**
* Not using **User components** in Application Code

### Dynamic Extensions

* *fileinfo*
* *Multibyte String*
* *ODBC(Open DataBase Connectivity)*

### Features

#### Auth

* [/auth/register.php](https://github.com/pronist/phpblog/tree/basic/public/auth/register.php) - Register **Form** for a new User (GET)
* [/auth/register_process.php](https://github.com/pronist/phpblog/tree/basic/public/auth/register_process.php) - **Create** a new User (POST)
* [/auth/login.php](https://github.com/pronist/phpblog/tree/basic/public/auth/login.php) - Login **Form** for a User (GET)
* [/auth/login_process.php](https://github.com/pronist/phpblog/tree/basic/public/auth/login_process.php) - Create a User **Session** (POST)
* [/auth/update.php](https://github.com/pronist/phpblog/tree/basic/public/auth/update.php) - Update **Form** for User informations (GET)
* [/auth/update_process.php](https://github.com/pronist/phpblog/tree/basic/public/auth/update_process.php) - **Update** User informations (PATCH)
* [/auth/logout.php](https://github.com/pronist/phpblog/tree/basic/public/auth/logout.php) - Delete a User **Session** (GET)

#### Board

* [/board/write.php](https://github.com/pronist/phpblog/tree/basic/public/board/write.php) - Write **Form** for a new Post (GET)
* [/board/write_process.php](https://github.com/pronist/phpblog/tree/basic/public/board/write_process.php) - **Write** a new Post (POST)
* [/board/list.php](https://github.com/pronist/phpblog/tree/basic/public/board/list.php) - **Posts** by a username (GET)
* [/board/read.php](https://github.com/pronist/phpblog/tree/basic/public/board/read.php) - **Read** a Post by a post id (GET)
* [/board/update.php](https://github.com/pronist/phpblog/tree/basic/public/board/update.php) -  Update **Form** for Post informations (GET)
* [/board/update_process.php](https://github.com/pronist/phpblog/tree/basic/public/board/update_process.php) - **Update** for Post informations (PATCH)
* [/board/delete.php](https://github.com/pronist/phpblog/tree/basic/public/board/delete.php) - **Delete** a Post (DELETE)

## Serve

```bash
# PHP Built-in Server at http://localhost:8080
php -S localhost:8080 -t public
```

## Testing

```bash
# Installation phpunit
composer install
# Unit Testing
phpunit --strict-coverage --verbose
```

## Database

```sql
use board;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL
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
