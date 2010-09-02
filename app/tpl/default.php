<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide PHP Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC App                                               *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 0.1                                                   *
 *                                                                            *
 ******************************************************************************/

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <?php echo $this->getTplTitle(); ?>
    <?php echo $this->getTplDescription(); ?>
    <?php echo $this->getTplKeywords(); ?>
    <?php echo $this->getTplFavicon(); ?>

    <!-- css -->
    <?php echo $this->getTplCss(); ?>
    <!-- /css -->
</head>
<body>
    
<!-- page -->
<div id="page">

    <!-- header -->
    <div id="header" class="clear">
        <a href="http://mvc.collide-applications.com/demo/">
            <img src="<?php echo siteUrl(); ?>img/blog/logo.png" width="80" height="70"
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
                    <a href="<?php echo siteUrl() . $page; ?>">
                        <?php echo $item; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <!-- /menu -->

        <?php echo $main; ?>

    </div>
    <!-- /content -->

    <!-- footer -->
    <div id="footer" class="clear">
        copyright &copy; <a href="http://www.collide-applications.com">Collide Applications</a>
    </div>
    <!-- /footer -->

</div>
<!-- /page -->

</body>
</html>