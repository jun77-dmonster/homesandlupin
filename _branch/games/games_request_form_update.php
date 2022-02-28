<?php
$sub_menu = '500100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

// 장바구니가 비어있는가?
if (get_session("ss_direct"))
    $tmp_cart_id = get_session('ss_cart_direct');
else
    $tmp_cart_id = get_session('ss_cart_id');

if (get_game_cart_count($tmp_cart_id) == 0)
    alert('요청목록이 비어 있습니다.\\n\\n이미 신청하셨거나 요청목록에 담긴 게임이 없는 경우입니다.', './games_cart.php');

$od_status = '접수';

$wr_content = '';
if (isset($_POST['od_memo'])) {
    $wr_content = substr(trim($_POST['od_memo']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}

if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

// 주문번호를 얻는다.
$od_id = get_session('ss_order_id');

$r1 = sql_fetch("select count(*) as cnt from {$DM['GAME_CART_TABLE']} where od_id='{$tmp_cart_id}'");

$sql = " insert into {$DM['GAME_REQUEST_TABLE']} 
			set od_id			=	'{$od_id}',
				branch_cd		=	'{$branch['branch_cd']}',
				od_cart_count	=	'{$r1['cnt']}',
				od_status		=	'$od_status',
				od_time			=	'".G5_TIME_YMDHIS."',
				od_memo			=	'{$wr_content}'";

$r2 = sql_query($sql);

$cart_status = $od_status;

if($r2==1){

	// 장바구니 상태변경
	$sql = "update {$DM['GAME_CART_TABLE']}
           set od_id = '$od_id',
               ct_status = '$cart_status'
         where od_id = '$tmp_cart_id'";

	$result = sql_query($sql, false);

	// 주문정보 입력 오류시 결제 취소
	if(!$result) {

		// 주문삭제
		sql_query(" delete from {$DM['GAME_REQUEST_TABLE']} where od_id = '$od_id' ");

		die('<p> 본사에 추천게임 요청 사항이 정상적으로 이루어지지 않았습니다 </p>');

	}

}

// 주문번호제거
set_session('ss_order_id', '');

// 기존자료 세션에서 제거
if (get_session('ss_direct'))
    set_session('ss_cart_direct', '');


goto_url("./games_request_view.php?od_id=".$od_id);