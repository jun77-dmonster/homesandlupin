<?php
$sub_menu = '200510';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';
$branch_cd = isset($_POST['branch_cd']) ? $_POST['branch_cd'] : '';

if(!$branch_cd){
	alert("식음료 등록할 지점 정보가 없습니다");
}

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$beverage_cd = isset($_POST['beverage_cd'][$k]) ? clean_xss_tags($_POST['beverage_cd'][$k], 1, 1) : '';

		/*
		$sql = " update {$DM['BRANCH_GAEMS_TABLE']}  
					set branch_use_fl	=	''
					where uid = '{$uid}'";
		*/
		$sql = " delete from {$DM['BRANCH_BEVERAGE_TABLE']}  where branch_cd = '{$branch_cd}' and beverage_cd='{$beverage_cd}'";

		/*$sql = " insert into {$DM['BRANCH_BEVERAGE_TABLE']} 
					SET branch_cd		=	'{$branch_cd}',
						beverage_cd		=	'{$beverage_cd}',
						delete_fl		=	'F',
						branch_beverage_reg_dt = '".G5_TIME_YMDHIS."'";
						*/

		sql_query($sql);

	}

}


goto_url("./pop_beverage_list.php?branch_cd=".$branch_cd);