<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +---------------------------------------------------------+
// | Paragin CMS Utilities                                   |
// +---------------------------------------------------------+
// $Id: loader.php 318 2004-10-31 20:57:55Z eelco $

/**
 * @copyright (c) 2004 Paragin
 * @author Eelco Lempsink <lempsink@paragin.nl>
 * @version $Rev: 318 $, $Date: 2004-10-31 21:57:55 +0100 (Sun, 31 Oct 2004) $
 *
 * @package resources
 */

// TODO: Remove anti-caching headers and return 304's

require("../../Config.php");

$config =& new Config();

/** 
 * Stylesheet loader
 *
 * Loads an stylesheet, effectively replacing all occurences of path's
 *
 * @package resources
 */


function translate_path($path)
{
    global $config;

    return str_replace("/$config->path_css", '', $path);
}

header("Content-type: text/css");

$filename = dirname(__FILE__) . "/" . basename($_SERVER['QUERY_STRING']);

if (empty($_SERVER['QUERY_STRING']) or !file_exists($filename))
{
    header("Content-length: 0");
    exit;
}
// else

header(sprintf("Content-length: %s", filesize($filename)));

$csspath   = dirname($_SERVER['SCRIPT_NAME']);
$imagepath = translate_path($config->get_url('path_images'));

include($filename);

?>
