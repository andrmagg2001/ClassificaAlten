<?php
    require "dbms.inc.php";

    global $mysqli;

    session_start();


    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: error.php');
        exit;
    }


    $data = $_POST['data'] ?? '';

    if ($data == '')
    {
        echo 0;
        exit;
    }

    $data = json_decode($data, true);

    $stmt = $mysqli->prepare("DELETE FROM multiplier;");
    $stmt->execute();

    foreach ($data as $item) 
    {
        if (isset($item['maluss'], $item['maluse'], $item['malusv'], $item['type'])) 
        {
            $stmt0 = $mysqli->prepare('INSERT INTO multiplier (id, start, end, val, type) VALUES (NULL, ?, ?, ?, ?)');
            $stmt0->bind_param("iidd", $item['maluss'], $item['maluse'], $item['malusv'], $item['type']);
            $stmt0->execute();
        } 
        elseif (isset($item['start'], $item['end'], $item['value'])) 
        {
            $stmt0 = $mysqli->prepare('INSERT INTO multiplier (id, start, end, val, type) VALUES (NULL, ?, ?, ?, ?)');
            $stmt0->bind_param("iidd", $item['start'], $item['end'], $item['value'], $item['type']);
            $stmt0->execute();
        }
    }

    echo 1;

?>