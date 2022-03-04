<?php

    include "../common.php";

    session_start();

    switch($_GET['type']) {
        case "client_insert":

            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';


            $sql = "INSERT INTO DM_T_VOICE_CUSTOMER (branch_cd, room_cd, customer_content, write_ip, customer_reg_dt) VALUES ('" . $_SESSION['branch_cd'] . "', '" . $_SESSION['room_cd'] . "', '" . $_POST['customer_content'] . "', '" . $ipaddress . "', NOW())";
            $result = sql_query($sql);

        break;
        case "qrcode":

            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';


            $sql = "INSERT INTO DM_T_VOICE_CUSTOMER (branch_cd, room_cd, customer_content, write_gubun, write_ip, customer_reg_dt) VALUES ('" . $_POST['branch_cd'] . "', '" . $_POST['room_cd'] . "', '" . $_POST['customer_content'] . "', '" . $_POST['write_gubun'] . "' ,'" . $ipaddress . "', NOW())";
            $result = sql_query($sql);

        break;
    }