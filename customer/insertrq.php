<?php

include "../common.php";

$branch_cd = $_POST['branch_cd'];
$room_cd = $_POST['room_cd'];
$write_gubun = $_POST['write_gubun'];
$customer_content = $_POST['customer_content'];
$write_ip = $_SERVER['REMOTE_ADDR'];
$customer_reg_dt = date("Y-m-d H:i:s");


$sql = "insert into DM_T_VOICE_CUSTOMER
				set branch_cd		=	'{$branch_cd}',
					room_cd		=	'{$room_cd}',
					write_gubun			=	'{$write_gubun}',
					customer_content			=	'{$customer_content}',
					write_ip			=	'{$write_ip}',
					customer_reg_dt			=	'{$customer_reg_dt}'";

sql_query($sql);



?>