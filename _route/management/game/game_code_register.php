<?php
$sub_menu = '200610';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";
}

$g5['title'] = '게임코드 '.$title;
include_once ('../../admin.head.php');
?>

<?
include_once ('../../admin.tail.php');