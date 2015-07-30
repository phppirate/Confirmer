<?php
    require_once "database.php";
    require_once "pirate-auth/pirate-auth.php";

    //confirm_pirate_auth_login();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pirate Cove</title>
</head>
<body>

<a href="../../login.php">Log in</a>
<a href="../../register.php">Register</a>

<?php if (pirate_auth_logged_in()): ?>
    <a href="../../logout.php">log out <?php echo pirate_auth_current_user('first_name') . ' ' . pirate_auth_current_user('last_name'); ?></a>
<?php endif; ?>

<h3>Users</h3>
<ul>
    <?php
        while($user = mysqli_fetch_array($users)){
            echo "<li>{$user['first_name']} {$user['last_name']} | {$user['username']} | {$user['email']}</li>";
        }
        echo "<hr>";

    ?>
</ul>
<hr/>

<pre>
 .S_sSSs     .S   .S_sSSs     .S_SSSs    sdSS_SSSSSSbs    sSSs
.SS~YS%%b   .SS  .SS~YS%%b   .SS~SSSSS   YSSS~S%SSSSSP   d%%SP     ------------   --------   ---    ---  ------------
S%S   `S%b  S%S  S%S   `S%b  S%S   SSSS       S%S       d%S'       ************  **********  ***    ***  ************
S%S    S%S  S%S  S%S    S%S  S%S    S%S       S%S       S%S        ---          ----    ---- ---    ---  ----
S%S    d*S  S&S  S%S    d*S  S%S SSSS%S       S&S       S&S        ***          ***      *** ***    ***  ************
S&S   .S*S  S&S  S&S   .S*S  S&S  SSS%S       S&S       S&S_Ss     ---          ---      --- ---    ---  ------------
S&S_sdSSS   S&S  S&S_sdSSS   S&S    S&S       S&S       S&S~SP     ***          ****    ****  ********   ****
S&S~YSSY    S&S  S&S~YSY%b   S&S    S&S       S&S       S&S        ------------  ----------    ------    ------------
S*S         S*S  S*S   `S%b  S*S    S&S       S*S       S*b        ************   ********      ****     ************
S*S         S*S  S*S    S%S  S*S    S*S       S*S       S*S.
S*S         S*S  S*S    S&S  S*S    S*S       S*S        SSSbs
S*S         S*S  S*S    SSS  SSS    S*S       S*S         YSSP
SP          SP   SP                 SP        SP
Y           Y    Y                  Y         Y
</pre>

</body>
</html>

<?php mysqli_close($connection); ?>