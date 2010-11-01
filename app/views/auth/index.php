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
 * Authentication page
 *
 * @package     Collide MVC App
 * @subpackage  Views
 * @category    Auth
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */
 ?>

    <div id="login" class="float-left">
        <form method="post" action="<?=$this->url->get()?>auth/login">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><h2>Login</h2></td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="user">Username</label>
                    </td>
                    <td>
                        <input type="text" name="form[user]" id="user" />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="pass">Password</label>
                    </td>
                    <td>
                        <input type="password" name="form[pass]" id="pass" />
                    </td>
                </tr>
                <tr>
                    <td align="right" colspan="2">
                        <input type="submit" name="submit" value="Login" />
                    </td>
                </tr>
            </table>
        </form>
    </div>