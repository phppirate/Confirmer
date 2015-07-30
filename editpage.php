<?php
/**
 * Created by  : PhpStorm.
 * User        : sam
 * Company     : Jeeble
 * Date        : 7/21/15
 * Time        : 10:38 AM
 */
require_once("assets/includes/includes.php");
confirm_pirate_auth_login();


if (!can_current_user("edit")){
    redirect_to('index.php');
}


if (isset($_POST['savepage'])){
    if (update_page($_POST['id'], $_POST['title'], $_POST['content'], $_POST['reqconf'], $_POST['state'], "public")){
        redirect_to('index.php');
    }
}
$page = [];
if (isset($_GET['id'])){
    $page = get_page($_GET['id']);
}

get_partial('header');

?>

    <div class="container">
        <form action="editpage.php" method="post">
            <div class="col-sm-6 col-sm-offset-3">
                <h1 class="page-header">Edit Page</h1>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" value="<?php echo $page['title']; ?>" name="title" type="text"/>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" class="froala-editor" data-target=".preview-markdown" id="content" cols="30" rows="20"><?php echo $page['content']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="reqconf">Requiers Confirmation</label>
                    <input class="" id="reqconf" name="reqconf" <?php if ($page['requires_confirmation'] == "true"): ?> checked<?php endif; ?> value="true" type="checkbox"/>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <select name="state" class="form-control" id="state">
                        <option <?php if ($page['state'] == "draft"): ?>selected<?php endif; ?> value="draft">Draft</option>
                        <option <?php if ($page['state'] == "published"): ?>selected<?php endif; ?> value="published">Published</option>
                    </select>
                </div>
                <input name="id" type="hidden" value="<?php echo $page['id']; ?>"/>
                <p>
                    <a href="index.php" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success" name="savepage">Save</button>
                </p>
            </div>
        </form>

    </div>
<?php get_partial('footer'); ?>