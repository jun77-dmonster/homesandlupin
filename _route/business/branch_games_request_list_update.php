<?php
$sub_menu = '400300';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');	

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$od_id = isset($_POST['od_id'][$k]) ? clean_xss_tags($_POST['od_id'][$k], 1, 1) : '';

		sql_query(" delete from {$DM['GAME_REQUEST_TABLE']} where od_id='{$od_id}'");


	}

}

goto_url("./branch_games_request_list.php");