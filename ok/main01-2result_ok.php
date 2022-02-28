<?php

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "wheelInfoData":

//            $sql = "SELECT * FROM DM_T_GAMES_PENALTY WHERE gubun_apply = '" . $_SESSION['branch_cd'] . "' AND penalty_use_fl = 'T' AND penalty_main_display_fl = 'T' ORDER BY penalty_order ASC";
            $sql = "SELECT * FROM DM_T_GAMES_PENALTY WHERE gubun_apply = '".$_SESSION['branch_cd']."' AND  penalty_use_fl = 'T' AND penalty_main_display_fl = 'T' ORDER BY penalty_order ASC LIMIT 0, 11";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);
//
//            $arr = array();
//
//            for($i=0; $row=sql_fetch_array($result); $i++) {
//                array_push($arr, $row);
//            }
//
//            print_r(json_encode($arr));

        break;
    }