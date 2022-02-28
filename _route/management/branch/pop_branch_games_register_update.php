<?php
$sub_menu = '200510';
include_once('./_common.php');

//$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
//$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';
$branch_cd = isset($_POST['branch_cd']) ? $_POST['branch_cd'] : '';

if(!$branch_cd){
	alert("게임 등록할 게임 지점 정보가 없습니다");
}


if (! (isset($_POST['chk']) && is_array($_POST['chk']))) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if($act_button === "선택등록"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$games_cd = $_POST['games_cd'][$k];

		$sql = " insert into {$DM['BRANCH_GAEMS_TABLE']} 
					SET branch_cd		=	'{$branch_cd}',
						games_cd		=	'{$games_cd}',
						branch_use_fl	=	'T',
						branch_games_reg_dt = '".G5_TIME_YMDHIS."'";

		sql_query($sql);

	}

}else{

}

goto_url("./pop_branch_game_list.php?branch_cd=".$branch_cd);
?>