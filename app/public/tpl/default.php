<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Blog demo page default template
 *
 * @package     Collide MVC App
 * @subpackage  Views
 * @category    Blog
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Blog</title>

    <link type="text/css" rel="stylesheet" href="<?=siteUrl()?>css/blog/styles.css" />
</head>
<body>

<!-- page -->
<div id="page">

    <!-- header -->
    <div id="header" class="clear">
        <a href="http://mvc.collide-applications.com/demo/">
            <img src="<?=siteUrl()?>img/blog/logo.png" width="80" height="70"
                 alt="Collide Applications" title="Collide Applications" />
        </a>
        <div class="text">
            Collide MVC Demo Blog
        </div>
    </div>
    <!-- /header -->

    <!-- content -->
    <div id="content">
        
        <!-- menu -->
        <div id="menu" class="float-left">
            <ul>
            <?php foreach( $menu as $item => $page ): ?>
                <li>
                    <a href="<?=siteUrl() . $page?>"><?=$item?></a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <!-- /menu -->

        <?=$main?>

    </div>
    <!-- /content -->

    <!-- footer -->
    <div id="footer" class="clear">
        copyright &copy; <a href="http://collide-applications.com">Collide Applications</a>
    </div>
    <!-- /footer -->

</div>
<!-- /page -->

</body>
</html>