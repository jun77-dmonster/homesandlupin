<?php
$sub_menu = '200600';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');


sql_query("update {$DM['GAMES_REQUEST_DESCRIPTION_TABLE']} set request_status='confirm', request_confirm_dt='".G5_TIME_YMDHIS."' where uid='{$uid}'");


goto_url("./employee_call_list.php?".$qstr);
?>