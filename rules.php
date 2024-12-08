<?php

    require "backend/include/template2.inc.php";

    $frame = new Template("backend/skins/dtml/frame_public.html");
    $rules = new Template("backend/skins/dtml/rules.html");

    session_start();

    $frame->setContent("CONTENT", $rules->get());
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