<?php
$sub_menu = '200200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$g5['title'] = '자주묻는질문';
include_once ('../admin.head.php');
?>

<div class="tab-wrap">
	<ul class="tab-menu">
		<li><a href="./faq_list.php">FAQ</a></li>
		<li class="on"><a href="./faq_type.php">FAQ 환경 관리</a></li>
	</ul>
</div>


<?
include_once ('../admin.tail.php');