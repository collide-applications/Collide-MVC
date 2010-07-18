<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

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
                        <a href="<?=siteUrl()?>blog/post/<?=$post['id']?>">
                            <?=$post['title']?>
                        </a>
                    </div>
                    <div class="controls float-right">
                        <a href="<?=siteUrl()?>blog/edit/<?=$post['id']?>">
                            Edit
                        </a>&nbsp;|&nbsp;
                        <a href="<?=siteUrl()?>blog/delete/<?=$post['id']?>">
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