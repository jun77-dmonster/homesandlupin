<?php
$sub_menu = '400300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$od_id				=	isset($_POST['od_id2']) ? trim($_POST['od_id2']) : '';
$od_admin_memo		=	isset($_POST['od_admin_memo']) ? trim($_POST['od_admin_memo']) : '';

if (isset($_POST['od_admin_memo'])) {
    $wr_content = substr(trim($_POST['od_admin_memo']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}

// 090710
if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

$sql = " update {$DM['GAME_REQUEST_TABLE']} set od_admin_memo='{$od_admin_memo}' where od_id='{$od_id}'";

sql_query($sql);

goto_url("./branch_games_request_view.php?od_id=".$od_id);