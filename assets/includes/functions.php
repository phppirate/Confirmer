<?php
/**
 * Created by  : PhpStorm.
 * User        : sam
 * Company     : Jeeble
 * Date        : 7/21/15
 * Time        : 9:55 AM
 */

function get_partial($name){
    include_once "assets/partials/_" . $name . ".php";
}

function kill_confirmer(){
    global $connection;

    die(mysqli_error($connection));
}

/*
 * @link Page Functions
 */

function get_pages(){
    global $connection;

    $sql = "SELECT * FROM pages";

    if ($result = mysqli_query($connection, $sql)){
        return $result;
    } else {
        kill_confirmer();
    }
}
function get_original_pages(){
    global $connection;

    $sql = "SELECT * FROM pages WHERE original_id = '0'";

    if ($result = mysqli_query($connection, $sql)){
        return $result;
    } else {
        kill_confirmer();
    }
}
function get_user_pages($user_id){
    global $connection;

    $sql = "SELECT * FROM pages WHERE author_id = '{$user_id}'";

    if ($result = mysqli_query($connection, $sql)){
        return $result;
    } else {
        kill_confirmer();
    }
}
function get_user_original_pages($user_id){
    global $connection;

    $sql = "SELECT * FROM pages WHERE author_id = '{$user_id}' AND original_id = '0'";

    if ($result = mysqli_query($connection, $sql)){
        return $result;
    } else {
        kill_confirmer();
    }
}

function update_page($page_id, $title, $content, $requires_confirmation, $state, $visibility){
    global $connection;
    global $sql_date;

    $title = addslashes($title);
    $content = addslashes($content);



    $sql = "UPDATE pages SET title = '{$title}', content = '{$content}', requires_confirmation = '{$requires_confirmation}', date_updated = '{$sql_date}', state = '{$state}', visibility = '{$visibility}' WHERE id = '{$page_id}' LIMIT 1";

    if ($result = mysqli_query($connection, $sql)){
        return true;
    } else {
        kill_confirmer();
    }

}

function new_page($author_id, $title, $content, $requires_confirmation, $state, $visibility, $original_id){
    global $connection;
    global $sql_date;

    $title = addslashes($title);
    $content = addslashes($content);



    $sql = "INSERT INTO pages(author_id, title, content, requires_confirmation, date_created, state, visibility, original_id) VALUES ('{$author_id}', '{$title}', '{$content}', '{$requires_confirmation}', '{$sql_date}', '{$state}', '{$visibility}', '{$original_id}')";

    if ($result = mysqli_query($connection, $sql)){
        return true;
    } else {
        kill_confirmer();
    }

}

function get_page($id){
    global $connection;

    $sql = "SELECT * FROM pages WHERE id = '{$id}' LIMIT 1";

    if ($result = mysqli_query($connection, $sql)){
        return mysqli_fetch_array($result);
    } else{
        kill_confirmer();
    }
}

function get_latest_page($id){
    global $connection;

    $sql = "SELECT * FROM pages WHERE id = '{$id}' OR original_id = '{$id}' AND state != 'draft' ORDER BY date_created DESC LIMIT 1";

    if ($result = mysqli_query($connection, $sql)){
        return mysqli_fetch_array($result);
    } else{
        kill_confirmer();
    }
}

function get_latest_page_version($id){
    global $connection;

    $sql = "SELECT * FROM pages WHERE id = '{$id}' OR original_id = '{$id}' AND state != 'draft' ORDER BY date_created DESC";

    if ($result = mysqli_query($connection, $sql)){
        return mysqli_num_rows($result);
    } else{
        kill_confirmer();
    }
}

function get_pages_for_original($original_id){
    global $connection;

    $sql = "SELECT * FROM pages WHERE id = '{$original_id}' OR original_id = '{$original_id}' ORDER BY date_created ASC";

    if ($result = mysqli_query($connection, $sql)){
        return $result;
    } else{
        kill_confirmer();
    }
}

/*
 * @link User Functions
 */

function can_user($user_id, $action){
    $user = pirate_auth_get_user_by_id($user_id);

    if($action == "manage users" && $user['rank'] == "admin"){
        return true;
    }
    if($action == "manage users" && $user['rank'] == "author"){
        return false;
    }
    if($action == "manage users" && $user['rank'] == "editor"){
        return false;
    }
    if($action == "manage users" && $user['rank'] == "user"){
        return false;
    }


    if($action == "delete" && $user['rank'] == "admin"){
        return true;
    }
    if($action == "delete" && $user['rank'] == "author"){
        return true;
    }
    if($action == "delete" && $user['rank'] == "editor"){
        return false;
    }
    if($action == "delete" && $user['rank'] == "user"){
        return false;
    }


    if($action == "save" && $user['rank'] == "admin"){
        return true;
    }
    if($action == "save" && $user['rank'] == "author"){
        return true;
    }
    if($action == "save" && $user['rank'] == "editor"){
        return false;
    }
    if($action == "save" && $user['rank'] == "user"){
        return false;
    }


    if($action == "create" && $user['rank'] == "admin"){
        return true;
    }
    if($action == "create" && $user['rank'] == "author"){
        return true;
    }
    if($action == "create" && $user['rank'] == "editor"){
        return false;
    }
    if($action == "create" && $user['rank'] == "user"){
        return false;
    }


    if($action == "edit" && $user['rank'] == "admin"){
        return true;
    }
    if($action == "edit" && $user['rank'] == "author"){
        return true;
    }
    if($action == "edit" && $user['rank'] == "editor"){
        return true;
    }
    if($action == "edit" && $user['rank'] == "user"){
        return false;
    }


    if($action == "draft" && $user['rank'] == "admin"){
        return true;
    }
    if($action == "draft" && $user['rank'] == "author"){
        return true;
    }
    if($action == "draft" && $user['rank'] == "editor"){
        return true;
    }
    if($action == "draft" && $user['rank'] == "user"){
        return false;
    }
}
function can_current_user($action){
    return can_user(pirate_auth_current_user('id'), $action);
}

function get_users(){
    global $connection;

    $sql = "SELECT * FROM users";

    if ($result = mysqli_query($connection, $sql)){
        return $result;
    } else {
        kill_confirmer();
    }
}

/*
 * @link Confirmations
 */

function user_has_confirmed($user_id, $page_id){
    global $connection;

    $sql = "SELECT * FROM confirmations WHERE user_id = '{$user_id}' AND page_id = '{$page_id}'";

    if ($result = mysqli_query($connection, $sql)){
        if(mysqli_num_rows($result) >= 1){
            return "true";
        } else {
            return "false";
        }
    } else {
        kill_confirmer();
    }
}

function confirm_reading($user_id, $page_id){
    global $connection;
    global $sql_date;
    global $name_date;

    $page = get_page($page_id);
    $author = pirate_auth_get_user_by_id($page['author_id']);

    $sql = "INSERT INTO confirmations(page_id, user_id, date_confirmed) VALUES ('{$page_id}', '{$user_id}', '{$sql_date}')";

    if ($result = mysqli_query($connection, $sql)){
        $subject = "Policy Controller";
        $message = pirate_auth_current_user('first_name') . " " . pirate_auth_current_user('last_name') . " Just agreed with \"" . $page['title'] . "\" on " . $name_date . ".";

        mail($author['email'], $subject, $message, "from: m-4@mission-4.com");

        return true;
    } else {
        kill_confirmer();
    }
}

function get_page_confirmations($page_id){
    global $connection;

    $sql = "SELECT * FROM confirmations WHERE page_id = '{$page_id}' ORDER BY date_confirmed ASC";

    if ($result = mysqli_query($connection, $sql)){
       return $result;
    } else {
        kill_confirmer();
    }
}


/*
 * @link Settings
 */

function get_setting($setting){
    global $connection;

    $sql = "SELECT * FROM settings WHERE id = '1' LIMIT 1";

    if ($result = mysqli_query($connection, $sql)){
        $settings = mysqli_fetch_array($result);

        return $settings[$setting];
    } else {
        kill_confirmer();
    }
}