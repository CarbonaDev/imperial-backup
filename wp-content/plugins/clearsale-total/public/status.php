<?php
/**
* The public webhook status
*/
/**
* The public webhook status
*
* Define método para pegar pedido com mudança de status.
*
* @package    Clearsale_Total
* @subpackage Clearsale/_Totalpublic
* @author     Letti Tecnologia <contato@letti.com.br>
* @version    "1.0.0"
* @date       20/07/2018
* @copyright  1996-2020 - Letti Tecnologia
*/

require_once '../includes/class-clearsale-total-status.php';

// se for usar o log descomentar as 2 linhas abaixo
//require_once '../includes/class-clearsale-total-log.php';
//global $woocommerce;
//$css = new Clearsale_Total_Log("clearsale-total", "2.2.0");

//Pegando dados Json
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$obj = json_decode($json,true);

//$css->write_log("Status: entrou...");

$code = "";
if (isset($obj['code'])) {
    $code = $obj['code'];
    $date = $obj['date'];
    $type = $obj['type'];
}
//https://tools.ietf.org/html/rfc2616#section-10.4
//400 Bad Request
//404 Not Found
if (!$code) {
    header("HTTP/1.0 400 Bad Request");
    return;
}

//$css->write_log("Status: code=" . $code . " date=" . $date . " type=" . $type);
// passa #pedido para outro metodo

Clearsale_Total_Status::Cs_status($code);

header("HTTP/1.0 200");
//header("HTTP/1.0 404 Not Found");