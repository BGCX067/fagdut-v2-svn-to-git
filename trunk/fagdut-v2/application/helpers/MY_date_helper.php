<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function chequearFecha($fecha) {
    $fecha=  explode('-', $fecha);
    
    return checkdate($fecha[1], $fecha[2], $fecha[0]);
}
