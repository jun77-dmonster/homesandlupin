<?php
$sub_menu = '200720';
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

}else if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$beverage_cd = isset($_POST['beverage_cd'][$k]) ? clean_xss_tags($_POST['beverage_cd'][$k], 1, 1) : '';

		$sql = " update {$DM['BEVERAGE_TABLE']} 
					set beverage_delete_fl = 'T'
					where beverage_cd = '{$beverage_cd}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("음료 삭제에 실패 했습니다");
		}

	}

}else{

	alert("비정상적으로 접근 했습니다");

}

goto_url("./beverage_list.php?$qstr");