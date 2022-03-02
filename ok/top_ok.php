<?php

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "wifi":

            $sql = "SELECT * FROM DM_T_BASE_GUIDE WHERE branch_cd = '".$_SESSION['branch_cd']."'";
            $result = sql_query($sql);
            $row = sql_fetch($sql);
            
            $wifiImageSql = "SELECT sc_basic_wife_img FROM DM_T_SITE_CONFIG";
            $query = sql_query($wifiImageSql);
            $wifiImage = sql_fetch_array($query);

            $row['wifiImage'] = $wifiImage['sc_basic_wife_img'];

            print_r(json_encode(array($row)));

        break;
    }