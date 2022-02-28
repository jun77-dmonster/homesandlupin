<?php
$sub_menu = '100000';
include_once('./_common.php');

sql_query(" update DM_T_GAMES_REQUEST_DESCRIPTION set request_status='confirm', request_confirm_dt='".G5_TIME_YMDHIS."' where uid='{$employee_uid}' ");

goto_url("./index.php");