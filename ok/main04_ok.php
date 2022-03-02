<?php

    include "../common.php";

    session_start();

    global $g5;

    $link = $g5['connect_db'];

    switch($_GET['type']) {
        case "filter":

            $sql = "SELECT * FROM DM_T_CODE WHERE category_group_cd = '02'";
            $result = sql_query($sql);
            $row = sql_fetch_array($result);


            $arr = array();


            for($i=0; $row=sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
        case "product":

            $sql = "SELECT bv.beverage_cd, bv.beverage_kor_nm, bv.beverage_eng_nm, bv.beverage_price, bv.beverage_file, bv.beverage_option_subject FROM DM_T_BEVERAGE AS bv JOIN DM_T_BRANCH_BEVERAGE AS branch ON branch.beverage_cd = bv.beverage_cd WHERE 1=1 AND branch.branch_cd ='".$_SESSION['branch_cd']."' AND bv.beverage_cate=".$_POST['item_cd'];
            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
        case "option":

            $sql = "SELECT beverage_op_no, beverage_op_id, beverage_op_type, beverage_op_price FROM DM_T_BEVERAGE_OPTION WHERE beverage_code='".$_POST['beverage_cd']."' AND beverage_op_use_fl='T'";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
        case "cart":

//            $sql = "INSERT INTO DM_T_CART () VALUES ()";
//
//            $result = sql_query($sql);

            $productList = $_POST['productList'];
            $uniqid = get_uniqid();

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

            $od_id = $uniqid;
            $branch_cd = $_SESSION['branch_cd'];
            $room_cd = $_SESSION['room_cd'];
            $ct_direct = 1;
            $ct_select = 1;
            $ct_ip = $ipaddress;
            $ct_status = "주문";
            $io_type = 0;
            $io_price = 0;

            $od_cart_price = 0;

//            echo $od_id;
//            echo "<br>";
//            echo count($productList);
            foreach($productList as $item) {
                $sql = "INSERT INTO DM_T_CART (od_id, branch_cd, room_cd, beverage_cd, ct_status, ct_price, ct_option, ct_qty, io_id, io_type, io_price, ct_time, ct_ip, ct_direct, ct_select) VALUES ('".$od_id."','".$branch_cd."','".$room_cd."','".$item['productCd']."','".$ct_status."','".$item['productPrice']."','".$item['ct_option']."','".$item['productCount']."','".$item['io_id']."','".$io_type."','".$item['productOptionPrice']."',NOW(),'".$ct_ip."','".$ct_direct."', '".$ct_select."')";
                $result = sql_query($sql);

                $od_cart_price += $item['productTotalPrice'];
            }

            //branch_cd, room_cd,
            //, '".$branch_cd."', '".$room_cd."'
            $sql = "INSERT INTO DM_T_ORDER (od_id, od_cart_count, od_cart_price, od_receipt_price, od_cancel_price, od_misu, od_mod_history, od_memo, od_status, od_time, od_ip, od_room_call_time) VALUES ('".$od_id."', '".count($productList)."', '".$od_cart_price."', '".$od_cart_price."', '".$od_cart_price."', 0, '', '', '', NOW(), '".$ct_ip."', NOW())";
            $result = sql_query($sql);

        break;
    }