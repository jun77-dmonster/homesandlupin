<?php

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "wifi":

            $sql = "SELECT * FROM DM_T_BASE_GUIDE WHERE branch_cd = '".$_SESSION['branch_cd']."'";
            $result = sql_query($sql);
            $row = sql_fetch($sql);

            print_r(json_encode(array($row)));

        break;
    }