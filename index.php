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

if (isset($_POST['confirm_page'])){
    confirm_reading(pirate_auth_current_user('id'), $_POST['page_id']);
    redirect_to('./');
}

get_partial('header');
?>


<div class="container">
    <h1 class="page-header">Welcome to <?php echo get_setting('site_title'); ?>, <?php echo ucwords(pirate_auth_current_user('username')); ?></h1>

    <table class="table table-striped table-bordered">
        <thead><th>Title</th><th>Author</th><th>Date Created</th><th class="hidden-xs">Requires Confirmation</th><th class="hidden-xs">Confirmed</th><th>Version</th></thead>
        <?php
        $pages = get_original_pages(pirate_auth_current_user('id'));
        while($spage = mysqli_fetch_array($pages)){
            $page = get_latest_page($spage['id']);

            if ((pirate_auth_current_user('rank') != 'user' || $page['visibility'] == 'public') && $page['state'] != 'draft'){
                ?>
                <tr>
                    <td><a href="viewpage.php?id=<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a></td>
                    <td><?php echo pirate_auth_get_user_by_id($page['author_id'])['first_name'] . " " . pirate_auth_get_user_by_id($page['author_id'])['last_name']; ?></td>
                    <td><?php echo $page['date_created']; ?></td>
                    <td class="hidden-xs"><?php echo $page['requires_confirmation']; ?></td>
                    <td class="hidden-xs"><?php echo user_has_confirmed(pirate_auth_current_user('id'), $page['id']); ?></td>
                    <td><?php echo get_latest_page_version($spage['id']); ?></td>
                </tr>
            <?php
            }
        }
        ?>
    </table>



    <h3>Actions</h3>
    <ul class="nav nav-pills nav-stacked">
        <?php if (can_current_user("create")): ?>
            <li><a href="admin.php">Admin Dashboard</a></li>
            <li><a href="newpage.php">New Page</a></li>
        <?php endif; ?>
        <li><a href="edituser.php?user=<?php echo pirate_auth_current_user('id'); ?>">Edit Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<?php get_partial('footer'); ?>