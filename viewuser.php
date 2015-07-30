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

$user = pirate_auth_get_user_by_id($_GET['user']);

get_partial('header');
?>


    <div class="container">
        <h1 class="page-header"><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></h1>
        <div class="col-sm-4">
            <dl>
                <dt>Username</dt>
                <dd><?php echo $user['username']; ?></dd>
                <dt>Email</dt>
                <dd><?php echo $user['email']; ?></dd>
                <dt>Rank</dt>
                <dd><?php echo $user['rank']; ?></dd>
            </dl>
        </div>
        <div class="col-sm-8">
            <table class="table table-bordered table-striped">
                <thead><th>Title</th><th>State</th><th>Date Created</th></thead>
                <?php
                    $pages = get_user_pages($user['id']);
                    while($page = mysqli_fetch_array($pages)){
                        ?>
                            <tr><td><a href="viewpage.php?id=<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a></td><td><?php echo $page['state']; ?></td><td><?php echo $page['date_created']; ?></td></tr>
                        <?php
                    }
                ?>
            </table>
        </div>
    </div>

<?php get_partial('footer'); ?>