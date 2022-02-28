<?php
$sub_menu = '200640';
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
		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';

		$sql = " delete from  {$DM['RECOMMEND_GAME_TABLE']} where uid = '{$uid}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("추천 게임 삭제에 실패 했습니다");
		}

	}

}else if($act_button === "선택수정"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';
		$main_display_fl = isset($_POST['main_display_fl'][$k]) ? clean_xss_tags($_POST['main_display_fl'][$k], 1, 1) : '';
		$display_order = isset($_POST['display_order'][$k]) ? clean_xss_tags($_POST['display_order'][$k], 1, 1) : '';

		$sql = " update {$DM['RECOMMEND_GAME_TABLE']} 
					set main_display_fl		=	'{$main_display_fl}',
						display_order		=	'{$display_order}'
				 where uid = '{$uid}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("추천 게임 수정에 실패 했습니다");
		}

	}

}

goto_url("./recommend_games_list.php?".$qstr);