<?php if( !defined( 'ROOT_PATH' ) ) die( '403: Forbidden' );

/******************************************************************************
 *                                                                            *
 * Collide PHP Framework                                                      *
 *                                                                            *
 * MVC framework for PHP.                                                     *
 *                                                                            *
 * @package     Collide MVC Core                                              *
 * @author      Collide Applications Development Team                         *
 * @copyright   Copyright (c) 2009, Collide Applications                      *
 * @license     http://mvc.collide-applications.com/license.txt               *
 * @link        http://mvc.collide-applications.com                           *
 * @since       Version 0.1                                                   *
 *                                                                            *
 ******************************************************************************/

/**
 * Application default config
 *
 * @package     Collide MVC App
 * @subpackage  Configs
 * @category    Application config
 * @author      Collide Applications Development Team
 * @link        http://mvc.collide-applications.com/docs/
 */

/**
 * Configure database connection.
 */

// database driver to use
$cfg['db']['default']['driver']        = 'mysql';
// database username
$cfg['db']['default']['user']          = 'root';
// database password
$cfg['db']['default']['pass']          = 'pass123';
// database host
$cfg['db']['default']['host']          = 'localhost';
// database port
$cfg['db']['default']['port']          = '3306';
// database name
$cfg['db']['default']['db_name']       = 'mvc';
// tables prefix
$cfg['db']['default']['prefix']        = 'blog_';

// Doctrine configs
$cfg['db']['doctrine']['models_path']           = APP_MODELS_PATH;
$cfg['db']['doctrine']['data_fixtures_path']    = $cfg['db']['doctrine']['models_path'] . 'fixtures';
$cfg['db']['doctrine']['migrations_path']       = $cfg['db']['doctrine']['models_path'] . 'migrations';
$cfg['db']['doctrine']['sql_path']              = $cfg['db']['doctrine']['models_path'] . 'sql';
$cfg['db']['doctrine']['yaml_schema_path']      = $cfg['db']['doctrine']['models_path'] . 'yaml';