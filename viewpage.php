<?php
/**
 * Created by  : PhpStorm.
 * User        : sam
 * Company     : Jeeble
 * Date        : 7/21/15
 * Time        : 11:56 AM
 */
require_once("assets/includes/includes.php");

confirm_pirate_auth_login();

$page = get_page($_GET['id']);

$latest_page = get_latest_page($page['id']);

if ($page['original_id'] != '0'){
    $latest_page = get_latest_page($page['original_id']);
}

$no_logo = true;

get_partial('header');
?>

<?php if ((can_current_user('edit') && $page['state'] == 'draft') || (can_current_user('create') && $page['state'] == "published")): ?>
    <div class="admin-bar"><?php if ($page['state'] == "draft"): ?><a href="editpage.php?id=<?php echo $page['id']; ?>">Edit Page</a><?php else: ?><a href="newpage.php?original_id=<?php echo $page['id']; ?>">Edit Page</a><?php endif; ?><a href="#readers" data-toggle="modal">Readers</a></div>
<?php endif; ?>
<div class="container no-scroll">
    <div class="page">
        <h1 class="page-header">
            <?php echo $page['title']; ?>
            <?php if ($page['id'] < $latest_page['id']): ?>
                <a href="viewpage.php?id=<?php echo $latest_page['id']; ?>" class="small pull-right">Newer Version</a>
            <?php endif; ?>
        </h1>

        <?php echo $page['content']; ?>
    </div>

    <?php if ($page['requires_confirmation'] == "true"): ?>
        <form class="confirmation" action="index.php" method="post">
            <label for="agree">I Have read and agree with this content</label> <input type="checkbox"  <?php if (user_has_confirmed(pirate_auth_current_user('id'), $page['id']) == "true"): ?>checked disabled<?php endif; ?> id="agree" class="toggle_hidden" data-toggle="#agree_btn"/>
            <br/>
            <input name="page_id" value="<?php echo $page['id']; ?>" type="hidden"/>
            <button type="submit" name="confirm_page" class="btn btn-primary hidden" id="agree_btn">Done</button>
        </form>
    <?php endif; ?>

</div>


<div class="modal fade" id="readers">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Readers</h4>
			</div>
			<div class="modal-body">
                <div class="readers">
                    <ul>
                        <?php
                        $confirmations = get_page_confirmations($page['id']);
                        while($confirmation = mysqli_fetch_array($confirmations)){
                            $reader = pirate_auth_get_user_by_id($confirmation['user_id']);

                            ?>
                            <li><?php echo $reader['first_name'] . " " . $reader['last_name']; ?></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php get_partial('footer') ?>