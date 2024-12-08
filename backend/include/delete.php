<?php
    require "dbms.inc.php";

    global $mysqli;

    session_start();


    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: error.php');
        exit;
    }


    $name = $_POST['name'] ?? '';

    $stmt = $mysqli->prepare("SELECT id FROM player WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $stmt = $mysqli->prepare("DELETE FROM player WHERE id = ?;");
        $stmt->bind_param("s", $row['id']);
        $stmt->execute();

        echo 1;
    }
    else
    {
        echo 0;
    }
?>