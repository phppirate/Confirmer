<?php
require_once "assets/includes/includes.php";


if (get_setting('can_register') != 'true'){
    redirect_to('index.php');
}



    if(isset($_POST['register'])){
        $first_name = addslashes($_POST['first-name']);
        $last_name = addslashes($_POST['last-name']);
        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $conf_password = addslashes($_POST['conf-password']);

        pirate_auth_register($first_name, $last_name, $username, $email, $password, $conf_password);
        
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<form action="register.php" method="post">
    <fieldset style="width: 400px; margin: auto">
        <legend>Register</legend>
        <p>
            <label for="first-name">First Name:</label> <input type="text" name="first-name" id="first-name"/>
        </p>
        <p>
            <label for="last-name">Last Name:</label> <input type="text" name="last-name" id="last-name"/>
        </p>
        <p>
            <label for="username">Username:</label> <input type="text" name="username" id="username"/>
        </p>
        <p>
            <label for="email">email:</label> <input type="text" name="email" id="email"/>
        </p>
        <p>
            <label for="password">password:</label> <input type="password" name="password" id="password"/>
        </p>
        <p>
            <label for="conf-password">confirm password:</label> <input type="password" name="conf-password" id="conf-password"/>
        </p>
        <p>
            <div class="pass-confirm" data-pass="#password" data-confpass="#conf-password">
            confirmation password
            </div>
        </p>
        <button type="submit" name="register">Register</button>
    </fieldset>
</form>

<script src="assets/pirate-authe/jquery.js"></script>
<script>
    $(document).ready(function(){
        $("#password, #conf-password").on("keyup", function (){
            if($("#password").val() == $("#conf-password").val()){
                $(".pass-confirm").css("background", 'lightgreen');
                $(".pass-confirm").html("Passwords Match");
            } else {
                $(".pass-confirm").css("background", 'red');
                $(".pass-confirm").html("Passwords Don't Match");
            }
        });
    });
</script>

</body>
</html>