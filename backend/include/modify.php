<?php
    require "dbms.inc.php";

    global $mysqli;

    session_start();


    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: error.php');
        exit;
    }


    $name = $_POST['name'] ?? '';
    $nname = $_POST['nname'] ?? '';
    $score = $_POST['nscore'] ?? '';
    $win = $_POST['nwin'] ?? '';
    $lose = $_POST['nlose'] ?? ''; 

    $stmt = $mysqli->prepare("SELECT id FROM player WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && $score != '' && $win != '' && $lose != '' && $nname != '')
    {
        $row = $result->fetch_assoc();

        $stmt = $mysqli->prepare("UPDATE `player` SET `name` = ?, `score` = ?, `win` = ?, `lose` = ? WHERE `player`.`id` = ?;");
        $stmt->bind_param("sdiii", $nname, $score, $win, $lose, $row['id']);
        $stmt->execute();

        echo 1;
    }
    else
    {
        echo 0;
    }
?>