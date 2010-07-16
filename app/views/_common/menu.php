<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Blog demo menu
 *
 * @package     Collide MVC App
 * @subpackage  Views
 * @category    Blog
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
 ?>

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