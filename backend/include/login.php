<?php
    require "dbms.inc.php";

    global $mysqli;

    session_start();

    $action = $_POST['action'] ?? ''; // "login" o "logout"


    if ($action === 'login')
    {
        $uname  = $_POST['uname']  ?? '';
        $passwd = $_POST['passwd'] ?? '';

        $passwd = md5(md5(md5(md5(md5($passwd)))));

        $stmt = $mysqli->prepare("SELECT id FROM admin WHERE uname = ? and passwd = ?");
        $stmt->bind_param("ss", $uname, $passwd);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0)
        {
            $_SESSION['loggedin'] = true;

            echo 1;
        } 
        else
        {
            echo 0;
        }
    }
    else if ($action === 'logout')
    {
        session_unset();
        session_destroy();
    }


?>