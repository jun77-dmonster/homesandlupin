<?php
$sub_menu = '200510';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택수정"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';
        $room_pwd = isset($_POST['room_pwd'][$k]) ? clean_xss_tags($_POST['room_pwd'][$k], 1, 1) : '';

		$sql = " update {$DM['BRANCH_ROOM_TABLE']}  
					set room_pwd		=	'".get_encrypt_string($room_pwd)."',
						room_pwd_enc	=	'{$room_pwd}'
					where uid = '{$uid}'";

		sql_query($sql);

	}

}else if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';

		$sql = " update {$DM['BRANCH_ROOM_TABLE']}  
					set room_delete_fl		=	'T'
					where uid = '{$uid}'";		

		sql_query($sql);

		$r1 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch_cd}' and  room_delete_fl='F'");

		sql_query("update {$DM['BRANCH_TABLE']} set branch_room_cnt='{$r1['cnt']}' where branch_cd='{$branch_cd}' ");

	}

}

goto_url2("./pop_branch_room_list.php?branch_cd=".$branch_cd);