<?php
$sub_menu = '500200';
include_once('./_common.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();

if (! $post_count_chk) {
    alert($act_button." 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

// 보관기간이 지난 상품 삭제
cart_game_clean();

$sw_direct = (isset($_REQUEST['sw_direct']) && $_REQUEST['sw_direct']) ? 1 : 0;

// cart id 설정
set_game_cart_id($sw_direct);


$tmp_cart_id = get_session('ss_cart_id');

// 브라우저에서 쿠키를 허용하지 않은 경우라고 볼 수 있음.
if (!$tmp_cart_id)
{
    alert('더 이상 작업을 진행할 수 없습니다.\\n\\n브라우저의 쿠키 허용을 사용하지 않음으로 설정한것 같습니다.\\n\\n브라우저의 인터넷 옵션에서 쿠키 허용을 사용으로 설정해 주십시오.\\n\\n그래도 진행이 되지 않는다면 운영자에게 문의 바랍니다.');
}

$tmp_cart_id = preg_replace('/[^a-z0-9_\-]/i', '', $tmp_cart_id);

if($sw_direct) {
	$ct_select = 1;
	$ct_select_time = G5_TIME_YMDHIS;
} else {
	$ct_select = 0;
	$ct_select_time = '0000-00-00 00:00:00';
}

for ($i=0; $i<$post_count_chk; $i++) {

	//auth_check_menu($auth, $sub_menu, 'w');
	// 실제 번호를 넘김
    $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
	$games_cd = isset($_POST['games_cd'][$k]) ? clean_xss_tags($_POST['games_cd'][$k], 1, 1) : '';

	$games = get_game_info($games_cd);

	$sql = " insert into {$DM['GAME_CART_TABLE']}
			  set od_id				=	'{$tmp_cart_id}',
				branch_cd			=	'{$branch['branch_cd']}',			
				games_cd			=	'{$games_cd}',
				games_nm			=	'{$games['games_nm']}',
				ct_status			=	'신청',
				ct_time				=	'".G5_TIME_YMDHIS."',
				ct_direct			=	'{$sw_direct}',
				ct_select			=	'{$ct_select}',
				ct_select_time		=	'{$ct_select_time}'";


	$r1 = sql_query($sql);

}

goto_url("./games_cart.php");