<?php
$sub_menu = '300200';
include_once('./_common.php');

$g5['title'] = '주문통합 관리';
include_once ('../admin.head.php');

set_dmcart_id();

echo get_session('ss_cart_direct');
?>

<?
include_once ('../admin.tail.php');