<?php
$sub_menu = '400300';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';


if($act_button === "선택등록"){
	if (! $post_count_chk) {
		alert($act_button." 하실 항목을 하나 이상 체크하세요.");
	}
}

check_admin_token();

if($act_button === "선택등록"){

	auth_check_menu($auth, $sub_menu, 'w');

	for ($i=0; $i<$post_count_chk; $i++) {

		// 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
		$ct_id = isset($_POST['ct_id'][$k]) ? clean_xss_tags($_POST['ct_id'][$k], 1, 1) : '';
		$games_cd = isset($_POST['games_cd'][$k]) ? clean_xss_tags($_POST['games_cd'][$k], 1, 1) : '';
		$branch_cd = isset($_POST['branch_cd'][$k]) ? clean_xss_tags($_POST['branch_cd'][$k], 1, 1) : '';

		//지점 게임 추가
		$sql = " insert into {$DM['BRANCH_GAEMS_TABLE']} 
					set branch_cd				=	'{$branch_cd}',	
						games_cd				=	'{$games_cd}',
						branch_use_fl			=	'T',
						branch_games_reg_dt		=	'".G5_TIME_YMDHIS."'";

		$r1 = sql_query($sql);

		$r2 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}'");

		if($r2==1){
			sql_query("update {$DM['BRANCH_TABLE']} set branch_game_reg_cnt='{$r2['cnt']}' where branch_cd='{$branch_cd}' ");
		}

		if($r1==1){
		
			//echo "update {$DM['GAME_CART_TABLE']} set ct_result='T' where ct_id='{$ct_id}' and games_cd='{$games_cd}' and branch_cd='{$branch_cd}'";
			//카트 게임 결과 업데이트
			sql_query("update {$DM['GAME_CART_TABLE']} set ct_result='T', ct_status='선택등록' where ct_id='{$ct_id}' and games_cd='{$games_cd}' and branch_cd='{$branch_cd}' ");

		}else{
		
			alert("지점 게임 추가를 실패했습니다.");
			exit;

		}
	
	}

	//echo "update {$DM['GAME_REQUEST_TABLE']} set od_status='선택수락' where od_id='{$od_id}'";
	sql_query("update {$DM['GAME_REQUEST_TABLE']} set od_status='선택등록' where od_id='{$od_id}' ");

	//	echo "<br>";
	

}else if($act_button === "일괄등록"){

	auth_check_menu($auth, $sub_menu, 'w');

	$result = sql_query("select t1.od_id, t1.branch_cd, t2.ct_id, t2.games_cd  from {$DM['GAME_REQUEST_TABLE']} as t1 join {$DM['GAME_CART_TABLE']} as t2 on t1.od_id=t2.od_id where t1.od_id='{$od_id}'");

	for($i=0;$row=sql_fetch_array($result);$i++){

		$sql = " insert into {$DM['BRANCH_GAEMS_TABLE']} 
					set branch_cd				=	'{$row['branch_cd']}',	
						games_cd				=	'{$row['games_cd']}',
						branch_use_fl			=	'T',
						branch_games_reg_dt		=	'".G5_TIME_YMDHIS."'";

		$r1 = sql_query($sql);

		$r2 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$row['branch_cd']}'");

		if($r2==1){
			sql_query("update {$DM['BRANCH_TABLE']} set branch_game_reg_cnt='{$r2['cnt']}' where branch_cd='{$row['branch_cd']}' ");
		}

		if($r1==1){
		
			//echo "update {$DM['GAME_CART_TABLE']} set ct_result='T' where ct_id='{$ct_id}' and games_cd='{$games_cd}' and branch_cd='{$branch_cd}'";

			//카트 게임 결과 업데이트
			sql_query("update {$DM['GAME_CART_TABLE']} set ct_result='T', ct_status='일괄등록' where ct_id='{$row['ct_id']}' and games_cd='{$row['games_cd']}' and branch_cd='{$row['branch_cd']}' ");

		}else{
		
			alert("지점 게임 추가를 실패했습니다.");
			exit;

		}
		

	}

	sql_query("update {$DM['GAME_REQUEST_TABLE']} set od_status='일괄수락' where od_id='{$od_id}' ");

}

goto_url("./branch_games_request_view.php?od_id=".$od_id);