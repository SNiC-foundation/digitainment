<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +---------------------------------------------------------+
// | Paragin CMS Utilities                                   |
// +---------------------------------------------------------+
// $Id: loadimage.php 309 2004-10-31 12:58:03Z blieck $

/**
 * @copyright (c) 2004 Paragin
 * @author Eelco Lempsink <lempsink@paragin.nl>
 * @version $Rev: 309 $, $Date: 2004-10-31 13:58:03 +0100 (Sun, 31 Oct 2004) $
 *
 * @package resources
 */

//TODO: this should probably be a 'special' core url: /:image:/foobar or
//      something like that

/** 
 * Image loader
 *
 * Loads an image from a file, based on SESSION values *
 *
 * @package resources
 */
function return_image($id)
{
    if (!isset($_SESSION['image'][$id]))
    {
        return; // empty handed
    }
    // else

    list ($mime, $filename) = explode('|', $_SESSION['image'][$id], 2);
    /* WARNING: this does seem useful, but apparently, some browsers (Opera for
     * sure) open a file twice (for prerendering the html or something) */
    //unset($_SESSION['image'][$id]);
    
    if (!file_exists($filename))
    {
        //show an image when no file is found.
        $file=explode("/",$filename);
        array_pop($file);
        $filename=implode("/",$file)."/none.jpg";
        //return;
    }
    // else

    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header("Content-type: $mime");
    header(sprintf("Content-length: %s", filesize($filename)));
    readfile($filename);
}

if (__FILE__ == realpath($_SERVER['SCRIPT_FILENAME'])) 
{
    session_start();
    return_image($_SERVER['QUERY_STRING']);
}

?>
