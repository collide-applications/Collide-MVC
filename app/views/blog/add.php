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
 * Blog demo content for add post
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
        <h3>Add new post</h3>

        <div class="add">
            <form method="post" action="<?=$this->url->get()?>blog/add">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="50" align="right">
                            <label for="title">Title:</label><br />
                        </td>
                        <td>
                            <input type="text" name="post[title]" id="title" maxlength="255" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <td align="right">
                            <label for="post_content">Content:</label><br />
                        </td>
                        <td>
                            <textarea name="post[content]" id="post_content"></textarea>
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
    </div>
    <!-- /content -->