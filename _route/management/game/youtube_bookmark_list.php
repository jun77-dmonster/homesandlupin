<?php
$sub_menu = '200630';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '게임 영상 책갈피';
include_once ('../../admin.head.php');
?>



<?
include_once ('../../admin.tail.php');