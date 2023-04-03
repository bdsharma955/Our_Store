<?php 
session_start();
require_once('../config.php');

DeleteTableData('menufactures',$_REQUEST['id']);

$url = GET_APP_URL().'/menufactures/all-menufacture.php?success=Data Delete Successfully!';

header("location:$url");

?>