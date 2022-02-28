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

		$branch_cd = isset($_POST['branch_cd'][$k]) ? clean_xss_tags($_POST['branch_cd'][$k], 1, 1) : '';

	}


}else if($act_button === "선택탈퇴"){

	auth_check_menu($auth, $sub_menu, 'd');
	
	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$branch_cd = isset($_POST['branch_cd'][$k]) ? clean_xss_tags($_POST['branch_cd'][$k], 1, 1) : '';

		$sql = " update {$DM['BRANCH_TABLE']} 
					set branch_withdrawal_fl = 'T',
						branch_withdrawal_dt = '".G5_TIME_YMDHIS."'
					where branch_cd = '{$branch_cd}'";	

		sql_query($sql);

	}

}else if($act_button === "탈퇴철회"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$branch_cd = isset($_POST['branch_cd'][$k]) ? clean_xss_tags($_POST['branch_cd'][$k], 1, 1) : '';

		$sql = " update {$DM['BRANCH_TABLE']} 
					set branch_withdrawal_fl = 'F',
						branch_withdrawal_dt = '0000-00-00 00:00:00'
					where branch_cd = '{$branch_cd}'";	

		sql_query($sql);

		$r1 = sql_fetch(" select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}' ");

		$r2 = sql_fetch(" select count(*) as cnt from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch_cd}' ");

		sql_query(" update {$DM['BRANCH_TABLE']} set branch_game_reg_cnt='{$r1['cnt']}', branch_room_cnt='{$r2['cnt']}'  where branch_cd='{$branch_cd}'");

	}

}

goto_url("./branch_list.php?".$qstr);
