<?php
    $result = null;
    $conn = new mysqli('localhost', 'meta7_dmonster9995', 'meta5451342!@', 'meta7_dmonster9995');
    
    $branch_cd       = isset($_GET['branch_cd']) ? trim($_GET['branch_cd']) : '';

    // Check connection
    if ($conn->connect_error) {
        return $result;
    }

    $sql = "SELECT t1.uid, t1.branch_cd, t1.room_cd, t1.games_cd, t1.request_reg_dt, t1.request_status, t2.games_nm, 
			t2.games_img_file, t3.room_no  
            from DM_T_GAMES_REQUEST_DESCRIPTION as t1 
            join DM_T_BOARD_GAMES as t2 
            on t1.games_cd=t2.games_cd 
			join DM_T_BRANCH_ROOM as t3 
			on t1.room_cd=t3.room_cd
            where t1.branch_cd='{$branch_cd}' 
            and date_format(t1.request_reg_dt,'%Y-%m-%d') = Date(NOW()) and t1.request_status='request'
            order by t1.request_reg_dt desc 
            limit 0, 1";
    $stmt = $conn->query($sql);
    if ($stmt) {
        $indexRow = 0;
        
        $result['code'] = 200;
        while ($row = $stmt->fetch_assoc()) {
            $result['list'][$indexRow] = $row;
            $indexRow ++;
        }

        $stmt->free();
    } else {

    }
    $order_sql = " SELECT t1.od_id, t1.branch_cd, t1.room_cd, t2.od_status, t2.od_time, t3.room_no  
            from ( SELECT  od_id, branch_cd, room_cd FROM DM_T_CART GROUP BY od_id ) as t1 
            join DM_T_ORDER as t2 
            on t1.od_id=t2.od_id
			join ( select room_no, room_cd from DM_T_BRANCH_ROOM where branch_cd='B9168') AS t3
			on t1.room_cd=t3.room_cd
            where t1.branch_cd='{$branch_cd}' 
            and date_format(t2.od_time,'%Y-%m-%d') = Date(NOW()) and t2.od_status='주문'
            order by t2.od_time desc 
            limit 0, 1 ";
    $order_stmt = $conn->query($order_sql);
    if ($order_stmt) {
        $indexRow = 0;
        
        $result['code'] = 200;
        while ($row = $order_stmt->fetch_assoc()) {
            $result['order'][$indexRow] = $row;
            $indexRow ++;
        }

        $order_stmt->free();
    } else {

    }
    $conn->close();
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>