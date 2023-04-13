<?php 
session_start();
require_once('../config.php');

DeleteTableData('sales',$_REQUEST['id']);

$url = GET_APP_URL().'/sales/all-sales.php?success=Data Delete Successfully!';

header("location:$url");

?>