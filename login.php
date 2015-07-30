<?php
require_once "assets/includes/includes.php";
?>
<?php

    if (isset($_POST['login'])){
        if(pirate_auth_login($_POST['username'], $_POST['password'])){
            redirect_to('index.php');
        } else {
            redirect_to('login.php?message=' . urldecode("Sorry username/email and/or password are inccorect."));
        }
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
</head>
<body>
<form action="login.php" method="post">
    <fieldset style="width: 400px; margin: auto">
        <legend>Log In</legend>
        <p>
            <label for="username">username:</label> <input type="text" name="username" id="username"/>
        </p>
        <p>
            <label for="password">password:</label> <input type="password" name="password" id="password"/>
        </p>
        <button type="submit" name="login">Log In</button><?php if (get_setting('can_register') == 'true'): ?> or <a href="register.php">register</a><?php endif; ?>
    </fieldset>
</form>
</body>
</html>