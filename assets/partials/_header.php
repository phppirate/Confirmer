<?php
/**
 * Created by  : PhpStorm.
 * User        : sam
 * Company     : Jeeble
 * Date        : 7/21/15
 * Time        : 11:59 AM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo get_setting('site_title'); ?> :: <?php
            echo ucwords(preg_replace("/.php\S*/", "", basename($_SERVER['REQUEST_URI'])));
        ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_setting('site_favicon_path'); ?>"/>
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css"/>

    <link href="assets/froala/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/froala/css/froala_style.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="assets/css/app.css"/>
</head>
<body>

<?php if (!isset($no_logo) && get_setting('site_logo_path') != ''): ?>
    <a href="index.php"><img class="site_logo" src="<?php echo get_setting('site_logo_path'); ?>" alt=""/></a>
<?php endif; ?>