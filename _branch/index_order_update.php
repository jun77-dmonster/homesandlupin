<?php
$sub_menu = '100000';
include_once('./_common.php');

if (!$od_id) { alert('주문번호가 넘어오지 않았습니다'); }

sql_query(" update DM_T_ORDER set od_status='접수' where od_id='{$od_id}' ");

sql_query(" update DM_T_CART set ct_status='접수' where od_id='{$od_id}' ");

goto_url("./index.php");