<?php 
session_start();
require_once('../config.php');

DeleteTableData('products',$_REQUEST['id']);

$url = GET_APP_URL().'/products/all-products.php?success=Data Delete Successfully!';

header("location:$url");

?>