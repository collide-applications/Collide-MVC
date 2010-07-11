<?php if( !defined( 'ROOT_PATH' ) ) die( NO_ACCESS_MSG );

/**
 * Welcome page content
 *
 * @package		Collide MVC App
 * @subpackage	Views
 * @category	Welcome
 * @author		Collide Applications Development Team
 * @link		http://mvc.collide-applications.com/docs/
 */
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
	<title><?=$title?></title>

    <style type="text/css">
        *{
            font-family:Verdana, Arial;
            font-size:14px;
        }
        div#page div{
            padding:10px;
            border:1px solid #ccc;
        }
        div#page div#lpanel{
            float:left;
        }
        div#page div#content{
            float:left;
            margin-left:10px;
        }
    </style>
</head>
<body>