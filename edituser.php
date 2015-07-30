<?php
/**
 * Created by  : PhpStorm.
 * User        : sam
 * Company     : Jeeble
 * Date        : 7/21/15
 * Time        : 9:52 AM
 */

require_once("assets/includes/includes.php");

confirm_pirate_auth_login();

if (isset($_POST['update'])){

    if (md5($_POST['admin_password']) == pirate_auth_current_user('hashed_password')){
        $user = pirate_auth_get_user_by_id($_POST['user_id']);

        $name = mbsplit(" ", $_POST['name']);
        $first_name = $name[0];
        $last_name = $name[1];

        $username = $_POST['username'];
        $email = $_POST['email'];

        $password = $_POST['new_password'];
        $cpassword = $_POST['conf_password'];

        $hashed_password = $user['hashed_password'];

        $rank = $user['rank'];

        if (isset($_POST['rank']) && $_POST['rank'] != ''){
            $rank = $_POST['rank'];
        }

        if (($password != "" && $cpassword != "") && ($password == $cpassword)){
            $hashed_password = md5($password);
        }

        $sql = "UPDATE users SET first_name = '{$first_name}', last_name = '{$last_name}', username = '{$username}', email = '{$email}', hashed_password = '{$hashed_password}', rank = '{$rank}' WHERE id = '{$user['id']}' LIMIT 1";

        if ($result = mysqli_query($connection, $sql)){
            redirect_to("viewuser.php?user=" . $user['id']);
        }

    } else {
        redirect_to('admin.php?message=admin password was incorrect');
    }
}


if ((pirate_auth_current_user('rank') != 'admin') && pirate_auth_current_user('id') != $_GET['user']){
    redirect_to('index.php?err');
}


$user = pirate_auth_get_user_by_id($_GET['user']);

get_partial('header');
?>


    <div class="container">
        <div class="col-sm-4 col-sm-offset-4">
            <h1 class="page-header">Edit User</h1>

            <form action="edituser.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" name="name" value="<?php echo $user['first_name'] . " " . $user['last_name'];  ?>" type="text"/>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" name="username" value="<?php echo $user['username'];  ?>" type="text"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" id="email" name="email" value="<?php echo $user['email'];  ?>" type="text"/>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input class="form-control" id="password" name="new_password" type="password"/>
                </div>
                <div class="form-group">
                    <label for="conf_password">Confirm New Password</label>
                    <input class="form-control" id="conf-password" name="conf_password" type="password"/>
                </div>

                <?php if (pirate_auth_current_user('rank') == 'admin' && $user['id'] != pirate_auth_current_user('id')): ?>
                    <div class="form-group">
                        <label for="rank">Rank</label>
                        <select class="form-control" id="rank" name="rank">
                            <option value="admin" <?php if ($user['rank'] == 'admin'): ?>selected='selected' <?php endif; ?>>Administrator</option>
                            <option value="author" <?php if ($user['rank'] == 'author'): ?>selected='selected' <?php endif; ?>>Author</option>
                            <option value="user" <?php if ($user['rank'] == 'user'): ?>selected='selected' <?php endif; ?>>User</option>
                        </select>
                    </div>
                <?php endif; ?>

                <p>
                <div class="pass-confirm" data-pass="#password" data-confpass="#conf-password">
                    &nbsp;
                </div>

                <input name="user_id" value="<?php echo $user['id']; ?>" type="hidden"/>
                
                </p>

                <hr/>
                <div class="form-group">
                    <label for="admin_password">User Password</label>
                    <input class="form-control" id="admin_password" name="admin_password" type="password"/>
                </div>

                <button type="submit" class="btn btn-success pull-right" name="update">Update</button>

            </form>
        </div>
    </div>

<?php get_partial('footer'); ?>