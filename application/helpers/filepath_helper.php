<?php
/**
 * Created by PhpStorm.
 * User: Dede Irawan,S.kom
 * Date: 24/12/2016
 * Time: 21.42
 */

function filePath($filePath)
{
    $fileParts = pathinfo($filePath);

    if(!isset($fileParts['filename']))
    {$fileParts['filename'] = substr($fileParts['basename'], 0, strrpos($fileParts['basename'], '.'));}

    return $fileParts;
}