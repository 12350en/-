<?php
require_once "DBManager.php";
$dbm = new DBManager();
$ary_names   = $_POST['names'];
$checkValue = $_POST['checkValue'];
$resultArray = $dbm->menu_allergy_filter($ary_names, $checkValue);
