<?php

    require "backend/include/template2.inc.php";
    require "backend/include/dbms.inc.php";

    $frame = new Template("backend/skins/dtml/frame_public.html");
    $home  = new Template("backend/skins/dtml/index.html");

    session_start();

    global $mysqli;

    $qry1 = "SELECT * 
            FROM player
            ORDER BY score DESC, lose ASC;";

    $oid  = $mysqli->query($qry1);

    $data = $oid->fetch_all(MYSQLI_ASSOC);

    $j = 1;
    foreach ($data as $d)
    {
        $item = new Template("backend/skins/dtml/snippet/row.html");
        $item->setContent("index",   $j);
        $item->setContent("name",    $d['name']);
        $item->setContent("score",   doubleval($d['score']));
        $item->setContent("wins",    $d['win']);
        $item->setContent("losses",  $d['lose']);
        $item->setContent("foto",    $d['img']);

        $home->setContent("row", $item->get());

        $j++;
    }

    $frame->setContent("CONTENT", $home->get());
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