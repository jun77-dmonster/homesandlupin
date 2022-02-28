<?php
$sub_menu = '100400';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택등록"){

	auth_check_menu($auth, $sub_menu, 'w');	


}else if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {
	
		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$data_cd = isset($_POST['data_cd'][$k]) ? clean_xss_tags($_POST['data_cd'][$k], 1, 1) : '';

		sql_query(" delete from  {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$uid}' and data_cd='{$data_cd}'");

	}
	
	$r1 = sql_fetch("select count(*) as cnt from {$DM['BD_TEMPLATE_TABLE']}  where template_uid='{$uid}'");
	
	sql_query("update {$DM['B_TEMPLATE_TABLE']} set template_data_cnt='{$r1['cnt']}' where uid='{$uid}'");

}

goto_url2("./pop_branch_template_data.php?uid=".$uid);