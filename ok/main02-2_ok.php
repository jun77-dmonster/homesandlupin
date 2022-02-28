<?php

    include "../common.php";

    session_start();


    switch($_GET['type']) {
        case "person_game":

            $sql = "SELECT * FROM DM_T_BASE_GUIDE WHERE branch_cd='" . $_SESSION['branch_cd'] . "' AND guide_use_fl = 'T' AND guide_delete_fl = 'F'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            print_r(json_encode($row));

        break;
    }