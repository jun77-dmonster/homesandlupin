<?php

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "use_info":

            $sql = "SELECT * FROM DM_T_BASE_GUIDE WHERE branch_cd = '".$_SESSION['branch_cd']."'";
            $result = sql_query($sql);
            $row = sql_fetch($sql);

            $configImageSql = "SELECT sc_basic_guide_img FROM DM_T_SITE_CONFIG";
            $query = sql_query($configImageSql);
            $configImage = sql_fetch_array($query);

            $row['configImage'] = $configImage['sc_basic_guide_img'];

            print_r(json_encode(array($row)));

            break;
    }