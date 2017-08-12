<?php
/**
 * Created by PhpStorm.
 * User: Dede Irawan,S.kom
 * Date: 24/12/2016
 * Time: 21.42
 */

function clean_and_print($str){
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}