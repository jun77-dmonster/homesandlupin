<?php
include "../common.php";
session_start();
session_destroy();
goto_url("/index.php");
?>