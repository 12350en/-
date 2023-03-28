<?php
require_once "DBManager.php";
$dbm = new DBManager();
$id = $_POST["names"];

$dbm->menu_detail_display($id + 1);
