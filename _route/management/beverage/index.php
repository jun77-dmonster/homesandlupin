<?php
$sub_menu = '200700';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '식음료 메인';
include_once ('../../admin.head.php');
?>

<div class="cont-box-wrap">
	
	<div class="cont-box">
		
		<div class="cont-box-top">
			<p class="tit">테스트1</p>
		</div>
		<div class="cont-box-bottom"></div>

	</div><!--//cont-box-->

</div>

<?
include_once ('../../admin.tail.php');