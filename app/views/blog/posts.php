<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide MVC Framework                                                      *
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
 * Blog demo content for posts page
 *
 * @package     Collide MVC App
 * @subpackage  Views
 * @category    Blog
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
 ?>

    <div id="main" class="float-left">
        <h3><?=$numPosts?> Posts</h3>

        <?php if( $numPosts > 0 ): ?>
            <ul>

            <?php
            $count = 0;
            foreach( $posts as $post ):
                if( ++$count % 2 == 0 ){
                    $liClass = 'even';
                }else{
                    $liClass = 'odd';
                }
            ?>
                <li class="<?=$liClass?>">
                    <div class="float-left">
                        <?=$count?>.
                        <a href="<?=$this->url->get()?>blog/post/<?=$post['id']?>">
                            <?=$post['title']?>
                        </a>
                    </div>
                    <div class="controls float-right">
                        <a href="<?=$this->url->get()?>blog/edit/<?=$post['id']?>">
                            Edit
                        </a>&nbsp;|&nbsp;
                        <a href="<?=$this->url->get()?>blog/delete/<?=$post['id']?>">
                            Delete
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
                
            </ul>
        <?php else: ?>
            No entries founded
        <?php endif; ?>
    </div>