<?php
$sub_menu = '200300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '고객의 소리 상세보기';
include_once ('../admin.head.php');
?>



<?
include_once ('../admin.head.php');