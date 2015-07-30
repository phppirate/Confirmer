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

if (!can_current_user('create')){
    redirect_to('index.php');
}

if (isset($_POST['update'])){
    $site_title = addslashes($_POST['site_title']);
    $site_logo_path = addslashes($_POST['site_logo_path']);
    $site_favicon_path = addslashes($_POST['site_favicon_path']);
    $can_register = $_POST['can_register'];

    $sql = "UPDATE settings SET site_title = '{$site_title}', site_logo_path = '{$site_logo_path}', site_favicon_path = '{$site_favicon_path}', can_register = '{$can_register}'";

    if ($result = mysqli_query($connection, $sql)){
       redirect_to('admin.php');
    }
}

get_partial('header');
?>


    <div class="container">
        
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-warning">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>
        
        <h1 class="page-header"><span class="fa fa-dashboard"></span> Admin Dashboard</h1>
        <div class="row">

            <div class="col-sm-4">
                <div class="panel panel-info">
                    <div class="panel-heading">Actions</div>
                    <ul class="list-group">
                        <a class="list-group-item" href="index.php"><span class="fa fa-home"></span> home</a>
                        <a class="list-group-item" href="newpage.php"><span class="fa fa-plus"></span> new page</a>
                        <a class="list-group-item" href="logout.php"><span class="fa fa-sign-out"></span> logout</a>
                    </ul>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">All Pages</div>

                    <div class="panel-body">
                        <ul class="hc-tree">
                            <?php
                            $page_originals = get_original_pages();
                            while($original_page = mysqli_fetch_array($page_originals)){
                                ?>
                                <li class="folder">
                                    <a href="#" class="title"><?php echo $original_page['title']; ?></a>
                                    <ol>
                                        <?php
                                        $child_pages = get_pages_for_original($original_page['id']);
                                        $num = 1;
                                        while($child_page = mysqli_fetch_array($child_pages)){
                                            ?>
                                            <li><a href="viewpage.php?id=<?php echo $child_page['id']; ?>"><?php if($child_page['state'] != "draft"){ echo "<span class='fa fa-check-square'></span> "; } else { echo "<span class='fa fa-ban'></span> "; } echo $child_page['title']; ?> v. <?php echo $num; ?></a></li>
                                            <?php
                                            $num++;
                                        }
                                        ?>
                                    </ol>

                                </li>
                            <?php
                            }
                            ?>
                        </ul>

                    </div>
                </div>
            </div>

            <div class="col-sm-4">

                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>

                    <ul class="list-group">
                        <?php
                        $users = get_users();
                        while($usr = mysqli_fetch_array($users)){
                            ?>
                            <li class="list-group-item">
                                <a href="viewuser.php?user=<?php echo $usr['id']; ?>"><?php echo $usr['first_name'] . " " . $usr['last_name']; ?></a>
                            <span class="actions pull-right">
                                <a href="edituser.php?user=<?php echo $usr['id']; ?>">[edit]</a>
                                <a href="delete.php?user=<?php echo $usr['id']; ?>" onclick="return confirm('Are you sure you want to permanintly remove <?php echo $usr['first_name']; ?> from you user list?')">[delete]</a>
                            </span>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
        <div class="row">
            <?php if (pirate_auth_current_user('rank') == "admin"): ?>
                <div class="col-sm-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Site Settings</div>
                        <form action="admin.php" class="panel-body" method="post">
                            <div class="form-group">
                                <label for="site_title">Site Title:</label>
                                <input class="form-control" id="site_title" name="site_title" type="title" value="<?php echo get_setting('site_title'); ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="site_logo_path">Site Logo Path:</label>
                                <input class="form-control" id="site_logo_path" name="site_logo_path" type="title" value="<?php echo get_setting('site_logo_path'); ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="site_favicon_path">Site Favicon Path:</label>
                                <input class="form-control" id="site_favicon_path" name="site_favicon_path" type="title" value="<?php echo get_setting('site_favicon_path'); ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="can_register">Enable Registering:</label>
                                <input class="form-control" id="can_register" name="can_register" value="true" <?php if (get_setting('can_register') == 'true'): ?>checked<?php endif; ?> type="checkbox"/>
                            </div>

                            <button type="submit" class="btn btn-success" name="update">Update</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
    </div>

<?php get_partial('footer'); ?>