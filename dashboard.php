<?php

    require "backend/include/template2.inc.php";
    require "backend/include/dbms.inc.php";

    $frame      = new Template("backend/skins/dtml/frame_public.html");
    $db         = new Template("backend/skins/dtml/dashboard.html");
    $viewranges = new Template("backend/skins/dtml/viewmultiplier.html");
    $ranges     = new Template("backend/skins/dtml/snippet/ranges.html");

    session_start();

    global $mysqli;

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: error.php');
        exit;
    }

    $qry1 = "SELECT * 
            FROM player
            ORDER BY score DESC, lose ASC;";

    $oid  = $mysqli->query($qry1);

    $data = $oid->fetch_all(MYSQLI_ASSOC);

    $j = 1;
    foreach ($data as $d)
    {
        $item = new Template("backend/skins/dtml/snippet/row2.html");
        $item->setContent("index",   $j);
        $item->setContent("name",    $d['name']);
        $item->setContent("score",   doubleval($d['score']));
        $item->setContent("wins",    $d['win']);
        $item->setContent("losses",  $d['lose']);
        $item->setContent("foto",    $d['img']);

        $db->setContent("row", $item->get());

        $j++;
    }


    $qry1 = "SELECT * FROM multiplier";
    $oid  = $mysqli->query($qry1);
    $data = $oid->fetch_all(MYSQLI_ASSOC);
    $j = 1;
    foreach ($data as $d)
    {
        if ($d['type'] == 1)
        {
            $viewranges->setContent("start", $d['start']);
            $viewranges->setContent("end", $d['end']);
            $viewranges->setContent("malus", doubleval($d['val']));
        }
        else
        {
            $ranges = new Template("backend/skins/dtml/snippet/ranges.html");
            $ranges->setContent("index", $j);
            $ranges->setContent("start", $d['start']);
            $ranges->setContent("end", $d['end']);
            $ranges->setContent("muls", doubleval($d['val']));
            $viewranges->setContent("ranges", $ranges->get());
            $j++;
        }

    }
    
    $db->setContent("viewranges", $viewranges->get());


    $frame->setContent("CONTENT", $db->get());
    $frame->close();

    $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

?>

<script>
var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

$(document).ready(function () {
    if (isLoggedIn == 1) {
        document.getElementById('logoutButton').style.display  = 'block';
        document.getElementById('dashbardDiv').style.display   = 'block';
        document.getElementById('updateRankDiv').style.display = 'block';
        document.getElementById('loginButton').style.display   = 'none';
    } else {
        document.getElementById('logoutButton').style.display  = 'none';
        document.getElementById('dashbardDiv').style.display   = 'none';
        document.getElementById('updateRankDiv').style.display = 'none';
        document.getElementById('loginButton').style.display   = 'block';
    }
});
</script>