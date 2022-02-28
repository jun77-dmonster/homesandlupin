<?php
$sub_menu = '500100';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if($act_button === "선택삭제"){
	if (!$post_count_chk) {
		alert($act_button." 하실 항목을 하나 이상 체크하세요.");
	}
}

check_admin_token();

if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$ct_id = isset($_POST['ct_id'][$k]) ? clean_xss_tags($_POST['ct_id'][$k], 1, 1) : '';

		$sql = " delete from {$DM['GAME_CART_TABLE']} where ct_id = '{$ct_id}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("요청 중인 게임 삭제에 실패 했습니다");
		}

	}

	goto_url("./games_cart.php");

	exit;


}else if($act_button === "비우기"){

	auth_check_menu($auth, $sub_menu, 'd');
	
	sql_query("delete from {$DM['GAME_CART_TABLE']} where od_id='{$od_id}'");

	set_session("ss_cart_id","");

	goto_url("./games_cart.php");

	exit;

}else{

	auth_check_menu($auth, $sub_menu, 'w');
	
	

}


