<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Blog demo content for post page
 *
 * @package     Collide MVC App
 * @subpackage  Views
 * @category    Blog
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
 ?>

    <!-- content -->
    <div id="main" class="float-left">
        <?php if( $post ): ?>
            <h3><?=$post['title']?></h3>

            <div class="text">
                <?=$post['content']?>
            </div>

            <h3><?=count( $comments )?> Comments</h3>
            
            <div class="comments">
                <div class="add">
                    <form method="post" action="<?=siteUrl()?>blog/comment">
                        <input type="hidden" name="post_id" value="<?=$post['id']?>" />
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td width="50" align="right">
                                    <label for="name">Name:</label><br />
                                </td>
                                <td>
                                    <input type="text" name="name" id="name" maxlength="255" />
                                </td>
                            </tr>
                            <tr valign="top">
                                <td align="right">
                                    <label for="message">Message:</label><br />
                                </td>
                                <td>
                                    <textarea name="message" id="message"></textarea>
                                </td>
                            </tr>
                            <tr align="left">
                                <td></td>
                                <td>
                                    <input type="submit" value="Add" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <!-- comments -->
                <?php if( count( $comments ) > 0 ): ?>
                    <ul>
                    <?php
                    $count = 1;
                    foreach( $comments as $comment ):
                    ?>
                        <li>
                            <h4><?=$count++?>. <?=$comment['name']?></h4>
                            <?=$comment['message']?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    No comments on this post
                <?php endif; ?>
                <!-- /comments -->
                    
            </div>

        <?php else: ?>
            No post founded
        <?php endif; ?>
            
    </div>
    <!-- /content -->