<?php
$sub_menu = '200400';
include_once('./_common.php');

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택품절"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$beverage_cd = isset($_POST['beverage_cd'][$k]) ? clean_xss_tags($_POST['beverage_cd'][$k], 1, 1) : '';

		$sql = " update {$DM['BRANCH_BEVERAGE_TABLE']} 
					set sold_out_fl = 'T' 
					where branch_cd = '{$branch['branch_cd']}'
					and beverage_cd = '{$beverage_cd}'";	

		sql_query($sql);

	}

}else if($act_button === "선택판매"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$beverage_cd = isset($_POST['beverage_cd'][$k]) ? clean_xss_tags($_POST['beverage_cd'][$k], 1, 1) : '';

		$sql = " update {$DM['BRANCH_BEVERAGE_TABLE']} 
					set sold_out_fl = 'F' 
					where branch_cd = '{$branch['branch_cd']}'
					and beverage_cd = '{$beverage_cd}'";	

		sql_query($sql);

	}

}

goto_url("./beverage_list.php?".$qstr);