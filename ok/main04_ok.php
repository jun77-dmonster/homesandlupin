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

            $sql = "SELECT bv.beverage_cd, bv.beverage_kor_nm, bv.beverage_eng_nm, bv.beverage_price, bv.beverage_file, bv.beverage_option_subject, bv.beverage_supply_subject, branch.sold_out_fl FROM DM_T_BEVERAGE AS bv JOIN DM_T_BRANCH_BEVERAGE AS branch ON branch.beverage_cd = bv.beverage_cd WHERE 1=1 AND bv.beverage_display_fl = 'T' AND bv.beverage_delete_fl = 'F' AND branch.delete_fl = 'F' AND branch.branch_cd ='".$_SESSION['branch_cd']."' AND bv.beverage_cate=".$_POST['item_cd'];
            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
        case "option":

            $sql = "SELECT beverage_op_no, beverage_op_id, beverage_op_type, beverage_op_price, beverage_code FROM DM_T_BEVERAGE_OPTION WHERE beverage_code='".$_POST['beverage_cd']."' AND beverage_op_use_fl='T'";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;
        case "required_subject":



        break;
        case "choose_subject":



        break;
        case "required_option":
            $sql = "SELECT beverage_op_no, beverage_op_id, beverage_op_type, beverage_op_price FROM DM_T_BEVERAGE_OPTION WHERE beverage_code='".$_POST['beverage_cd']."' AND beverage_op_use_fl='T' AND beverage_op_type = 0";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);
        break;
        case "choose_option":
            $sql = "SELECT beverage_op_no, beverage_op_id, beverage_op_type, beverage_op_price FROM DM_T_BEVERAGE_OPTION WHERE beverage_code='".$_POST['beverage_cd']."' AND beverage_op_use_fl='T' AND beverage_op_type = 1";

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

                $ct_option_ex = explode("/", $item['ct_option']);

                for($i = 0; $i < count($ct_option_ex); $i++) {
                    if($i == 0) {
                        $io_id_ex = explode(":", $ct_option_ex[0]);
                        $io_type = 0;

                        $last_ct_option = explode(chr(30), $ct_option_ex[0]);

                        $sql = "INSERT INTO DM_T_CART (od_id, branch_cd, room_cd, beverage_cd, ct_status, ct_price, ct_option, ct_qty, io_id, io_type, io_price, ct_time, ct_ip, ct_direct, ct_select) VALUES ('".$od_id."','".$branch_cd."','".$room_cd."','".$item['productCd']."','".$ct_status."','".$item['productPrice']."','".$last_ct_option[0]."','".$item['productCount']."','".$io_id_ex[1]."','".$io_type."','".$item['productOptionPriceArr'][0]."',NOW(),'".$ct_ip."','".$ct_direct."', '".$ct_select."')";
                        $result = sql_query($sql);
                    }
                    if($i == 1) {

                        $title = explode(":", $ct_option_ex[1]);
                        $io_id_ex = explode(chr(30), $title[1]);

                        $io_type = 1;

                        for($k = 1; $k < count($item['productOptionPriceArr']); $k++) {
                            $sql = "INSERT INTO DM_T_CART (od_id, branch_cd, room_cd, beverage_cd, ct_status, ct_price, ct_option, ct_qty, io_id, io_type, io_price, ct_time, ct_ip, ct_direct, ct_select) VALUES ('".$od_id."','".$branch_cd."','".$room_cd."','".$item['productCd']."','".$ct_status."','".$item['productPrice']."','".$title[0].":".$io_id_ex[$k-1]."','".$item['productCount']."','','".$io_type."','".$item['productOptionPriceArr'][$k]."',NOW(),'".$ct_ip."','".$ct_direct."', '".$ct_select."')";
                            $result = sql_query($sql);
                        }

                    }

                }


                $od_cart_price += $item['productTotalPrice'];
            }

            //branch_cd, room_cd,
            //, '".$branch_cd."', '".$room_cd."'
            $sql = "INSERT INTO DM_T_ORDER (od_id, od_cart_count, od_cart_price, od_receipt_price, od_cancel_price, od_misu, od_mod_history, od_memo, od_status, od_time, od_ip, od_room_call_time) VALUES ('".$od_id."', '".count($productList)."', '".$od_cart_price."', '".$od_cart_price."', 0, 0, '', '', '".$ct_status."', NOW(), '".$ct_ip."', '0000-00-00 00:00:00')";
            $result = sql_query($sql);



        break;

        case "branch_check_image":

            $sql = "SELECT guide_basic_order_img FROM DM_T_BASE_GUIDE WHERE branch_cd = '" .$_SESSION['branch_cd']. "'";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;

        case "corp_check_image":

            $sql = "SELECT sc_basic_order_img FROM DM_T_SITE_CONFIG WHERE site_nm = '홈즈앤루팡'";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;

        case "order_popup":


            $order_sql = " SELECT t1.od_id, t1.branch_cd, t1.room_cd, t2.od_status, t2.od_time, t3.room_no  
            from ( SELECT  od_id, branch_cd, room_cd FROM DM_T_CART GROUP BY od_id ) as t1 
            join DM_T_ORDER as t2 
            on t1.od_id=t2.od_id
			join ( select room_no, room_cd from DM_T_BRANCH_ROOM where branch_cd='B9168') AS t3
			on t1.room_cd=t3.room_cd
            where t1.branch_cd='{$_SESSION['branch_cd']}' 
            and date_format(t2.od_time,'%Y-%m-%d') = Date(NOW()) and t2.od_status != '주문'
            order by t2.od_time desc 
            limit 0, 1 ";
            $order_stmt = sql_query($order_sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($order_stmt); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

//            if ($order_stmt) {
//                $indexRow = 0;
//
//                $result['code'] = 200;
//                while ($row = $order_stmt->fetch_assoc()) {
//                    $result['order'][$indexRow] = $row;
//                    $indexRow ++;
//                }
//
//                $order_stmt->free();
//            } else {
//
//            }

        break;


        case "success_order":

            $date = date("Y-m-d") . " 00:00:00";


            $sql = "SELECT od.od_id FROM DM_T_ORDER AS od JOIN DM_T_CART AS cart ON od.od_id = cart.od_id WHERE od.od_status = '호출' AND cart.branch_cd = '" . $_SESSION['branch_cd'] . "' AND cart.room_cd = '".$_SESSION['room_cd']."' AND od.od_time >= '".$date."'";

            $result = sql_query($sql);

            $arr = array();

            for($i=0; $row = sql_fetch_array($result); $i++) {
                array_push($arr, $row);
            }

            echo json_encode($arr);

        break;


        case "success_order_check":

            $sql = "UPDATE DM_T_ORDER SET od_status = '확인' WHERE od_id IN (".$_POST['wherein'].")";
            $result = sql_query($sql);

            $sql1 = "UPDATE DM_T_CART SET ct_status = '확인' WHERE od_id IN (".$_POST['wherein'].")";
            $result1 = sql_query($sql1);

        break;
    }