<?php
$sub_menu = '400100';
include_once('./_common.php');

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}


check_admin_token();


if($act_button === "선택수정"){

	auth_check_menu($auth, $sub_menu, 'w');

}else if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
		$k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';

		$sql = " update {$DM['NOTICE_TABLE']} 
					set delete_fl='T'
					where uid = '{$uid}'";	

		sql_query($sql);

	}

}

goto_url("./branch_notice_list.php?".$qstr);