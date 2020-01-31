<?php

require_once dirname(__DIR__) . '/bootstrap/app.php';

if (!array_key_exists('user', $_SESSION)) {
    return header('Location: /auth/login.php');
}

$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32));
$user = $_SESSION['user'];

$stmt = mysqli_prepare($GLOBALS['DB_CONNECTION'], 'SELECT * FROM users WHERE email = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $user['email']);
if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    [ 'email' => $email ] = mysqli_fetch_assoc($result);
}
mysqli_stmt_close($stmt);

?>

<?php require_once dirname(__DIR__) . '/layouts/top.php'; ?>

<div id="main__form-auth" class="uk-padding uk-position-fixed uk-position-center">
    <form action="/user/update_process.php" method="post">
        <input type="hidden" name="token" value="<?=$_SESSION['CSRF_TOKEN']?>">
        <input type="text" name="email" placeholder="Email" value="<?=$email?>" class="uk-input">
        <input type="password" name="password" placeholder="Password" class="uk-input">
        <input type="submit" value="Submit" class="uk-button uk-button-default uk-width-1-1">
    </form>
</div>

<?php require_once dirname(__DIR__) . '/layouts/bottom.php'; ?>
