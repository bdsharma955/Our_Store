<?php 
session_start();
require_once('../config.php');

DeleteTableData('purchases',$_REQUEST['id']);

$url = GET_APP_URL().'/phurchases/all-phurchases.php?success=Data Delete Successfully!';

header("location:$url");

?>