<?php

    include_once('config.php');

    session_start();

    session_unset();

    session_destroy();

    header("Location: http://news-site.test/admin/");

?>
