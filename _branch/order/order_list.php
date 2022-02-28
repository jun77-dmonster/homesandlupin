<?php
$sub_menu = '300100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '지점 주문 현황';
include_once ('../admin.head.php');
?>

<?
include_once ('../admin.tail.php');