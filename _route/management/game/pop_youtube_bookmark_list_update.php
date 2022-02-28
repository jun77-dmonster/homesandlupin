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

if($act_button === "선택삭제"){

	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';


		$sql = " select youtube_img_thumb from {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} where uid='{$uid}'";
		$file = sql_fetch($sql);
		$youtube_img_thumb	=	$file['youtube_img_thumb'];

		$file_img1 = $youtube_path.'/'.clean_relative_paths($youtube_img_thumb);
		@unlink($file_img1);
		delete_img_thumbnail(dirname($youtube_img_thumb), basename($youtube_img_thumb));


		$sql = " delete from  {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} where uid = '{$uid}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("책갈피 삭제에 실패 했습니다");
		}

	}

}else if($act_button === "선택수정"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$uid = isset($_POST['uid'][$k]) ? clean_xss_tags($_POST['uid'][$k], 1, 1) : '';
		$display_fl = isset($_POST['display_fl'][$k]) ? clean_xss_tags($_POST['display_fl'][$k], 1, 1) : '';
		$youtube_setting_fl = isset($_POST['youtube_setting_fl'][$k]) ? clean_xss_tags($_POST['youtube_setting_fl'][$k], 1, 1) : '';

		$sql = " update {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} set display_fl = '{$display_fl}', youtube_setting_fl='{$youtube_setting_fl}' where uid='{$uid}'";

		$r1=sql_query($sql);

		if($r1==0){
			alert("책갈피 수정에 실패 했습니다");
		}

	}

}

goto_url("./pop_youtube_bookmark_list.php?".$qstr."&games_cd=".$games_cd);