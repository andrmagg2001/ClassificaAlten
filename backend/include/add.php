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
        echo 2;
        exit;
    }

    if ($name !== '') {
        // Prepara la query
        $stmt = $mysqli->prepare("INSERT INTO `player` (`id`, `name`, `score`, `win`, `lose`, `img`) VALUES (NULL, ?, '0', '0', '0', 'backend/skins/img/players/user.png');");
        $stmt->bind_param("s", $name);


        if ($stmt->execute()) {
            echo 1;
        } else {
            echo 0;
        }

        $stmt->close();
    } else {
        echo 0;
    }


?>
