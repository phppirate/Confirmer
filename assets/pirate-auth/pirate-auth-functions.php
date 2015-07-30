<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 10/31/14
 * Time: 11:43 PM
 */

function pirate_auth_login($string, $password){
    global $connection;

    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE ( username = '{$string}' OR email = '{$string}') AND hashed_password = '{$hashed_password}' LIMIT 1";

    if($result = mysqli_query($connection, $sql)){
        if (mysqli_num_rows($result) != 0){
            $user = pirate_auth_get_user_by_string_and_pass($string, $password);

            pirate_auth_login_key_set($user['id']);

            return true;
        } else {
            return false;
        }
    } else {
        die(mysqli_error($connection));
    }
    return false;
}

function pirate_auth_get_user_by_string_and_pass($string, $password){
    global $connection;

    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE ( username = '{$string}' OR email = '{$string}') AND hashed_password = '{$hashed_password}' LIMIT 1";

    if($result = mysqli_query($connection, $sql)){
        return mysqli_fetch_array($result);
    }
}

function pirate_auth_current_user($param){
    return pirate_auth_user_param(pirate_auth_get_session_data(), $param);
}

function pirate_auth_user_param($user_id, $param){
    $user = pirate_auth_get_user_by_id($user_id);
    return $user[$param];
}

function pirate_auth_get_user_by_id($user_id){
    global $connection;
    $sql = "SELECT * FROM users WHERE id = '{$user_id}' LIMIT 1";
    if($result = mysqli_query($connection, $sql)){
        return mysqli_fetch_array($result);
    }
}

function pirate_auth_login_key_set($string){
    global $pirate_auth_config;
    $_SESSION[$pirate_auth_config['login_key'] . '-' . 'user_id'] = $string;
    $_SESSION[$pirate_auth_config['login_key']] = 'logged_in';
}

function pirate_auth_register($first_name, $last_name, $username, $email, $password, $conf_password){
    global $connection;
    global $pirate_auth_config;
    if ($password == $conf_password){
        if (strlen($password) >= $pirate_auth_config['password_min_length'] ){
            $password_hashed = md5($conf_password);

            $sql = "
                      INSERT INTO users (first_name, last_name, username, email, hashed_password)
                      VALUES ('{$first_name}', '{$last_name}', '{$username}', '{$email}', '{$password_hashed}')";

            if ($result = mysqli_query($connection, $sql)){

                if ($pirate_auth_config['requires_email_confirmation']){
                    $token = pirate_auth_generate_reset_token();
                    $sql = "UPDATE users SET signup_token = '{$token}' WHERE first_name = '{$first_name}' AND email = '{$email}' LIMIT 1";

                    if ($result = mysqli_query($connection, $sql)){
                        $subject = "Welcome To Pirates Cove!";
                        $message = "";
                        redirect_to("index.php?message=" . urlencode('You have been sent a confirmation email.'));
                    } else {
                        redirect_to('register.php?message=' . urlencode('Error with confirmation sign up.'));
                    }

                } else {
                    if (pirate_auth_login($username, $password)){
                        redirect_to("index.php?message=" . urlencode($pirate_auth_config['greeting'] . ' ' . $username));
                    } else {
                        redirect_to("index.php?message=" . urlencode('You are signed up now just login.'));
                    }
                }

            } else {
                redirect_to("register.php?message=" . urldecode("Username or Password are wrong"));
            }
        } else {
            redirect_to("register.php?message=" . urldecode("Passwords cannot be less the 6 characters."));
        }
    } else {
        redirect_to("register.php?message=" . urldecode("Passwords do not match."));
    }
}

function pirate_auth_get_session_data(){
    global $pirate_auth_config;
    return $_SESSION[$pirate_auth_config['login_key'] . '-' . 'user_id'];
}

function pirate_auth_logout_users(){
    session_start();

    $_SESSION = array();

    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(), '' , time()-42000, '/');
    }

    session_destroy();
    $message = "You are now Logged out.";
    redirect_to("login.php?message={$message}");

}

function pirate_auth_generate_reset_token(){
    $token = rand(1000000000, 9999999999);
    return $token;
}

function redirect_to($local){
    header("Location: $local");
    exit;
}