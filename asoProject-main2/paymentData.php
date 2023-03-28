<?php
    session_start();

    $_SESSION['order_payment'] = $_POST["radio"];

    echo json_encode("success");
?>