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

if (!can_current_user("create")){
    redirect_to('index.php');
}

if (isset($_POST['newpage'])){
    if (new_page(pirate_auth_current_user('id'), $_POST['title'], $_POST['content'], $_POST['reqconf'], $_POST['state'], $_POST['visibility'], $_POST['original_id'])){
        redirect_to('index.php');
    }
}
$page = [];
if (isset($_GET['original_id'])){
    $page = get_page($_GET['original_id']);
}

get_partial('header');

?>

<div class="container">
    <form action="newpage.php" method="post">
        <div class="col-sm-6 col-sm-offset-3">
            <h1 class="page-header">New Page</h1>
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
            <div class="form-group">
                <label for="visibility">Visiblity</label>
                <select name="visibility" class="form-control" id="visibility">
                    <option <?php if ($page['visibility'] == "public"): ?>selected<?php endif; ?> value="public">Public</option>
                    <option <?php if ($page['visibility'] == "admins only"): ?>selected<?php endif; ?> value="admins only">Admins Only</option>
                    <option <?php if ($page['visibility'] == "modifiers only"): ?>selected<?php endif; ?> value="modifiers only">Modifiers Only</option>
                    <option <?php if ($page['visibility'] == "editors only"): ?>selected<?php endif; ?> value="editors only">Editors Only</option>
                    <option <?php if ($page['visibility'] == "users only"): ?>selected<?php endif; ?> value="users only">Users Only</option>
                    <option <?php if ($page['visibility'] == "private"): ?>selected<?php endif; ?> value="private">private</option>
                </select>
            </div>
            <input name="original_id" type="hidden" value="<?php echo $page['id']; ?>"/>
            <p>
                <a href="index.php" class="btn btn-default">Back</a>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-success" name="newpage">Submit</button>
            </p>
        </div>
    </form>

</div>
<?php get_partial('footer'); ?>