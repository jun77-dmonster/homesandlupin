<?php
$sub_menu = '200510';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

//auth_check_menu($auth, $sub_menu, 'w');
if ($w == '' || $w == 'u')
    auth_check_menu($auth, $sub_menu, "w");
else if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");

check_admin_token();

$branch_cd	= isset($_POST['branch_cd']) ? strip_tags(clean_xss_attributes($_POST['branch_cd'])) : '';
$room_cnt	= isset($_POST['room_cnt']) ? preg_replace('/[^0-9]/', '', $_POST['room_cnt']) : 0;
$room_pwd	= isset($_POST['room_pwd']) ? strip_tags(clean_xss_attributes($_POST['room_pwd'])) : '';



if($room_cnt==0){

	alert("생성할 룸 갯수는 0보다 커야 합니다");

}

//룸체크
$room = sql_fetch("select IFNULL(max(room_no),1) as max_room from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch_cd}'");

$r1=set_room_make($branch_cd,$room_pwd,$room_cnt,$room['max_room']);

if($r1==$room_cnt){

	sql_query("update {$DM['BRANCH_TABLE']} set branch_room_cnt='{$room_cnt}' where branch_cd='{$branch_cd}'");

}

goto_url2("./pop_branch_room_list.php?branch_cd=".$branch_cd);