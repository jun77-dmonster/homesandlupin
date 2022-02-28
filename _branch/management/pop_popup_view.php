<?php
$sub_menu = '200300';
include_once('./_common.php');

$g5['title'] = "검색 테스트";
include_once ('../pop.admin.head.php');

$row = sql_fetch("select * from {$DM['POPUP_TABLE']} where nw_uid='{$nw_uid}'");

?>
<div class="layer-popup">
	
	<div class="wrapper type-800">

		<div class="container-wrap">

			<div style='width:100%; padding:10px;'>
			<?php echo $row['nw_content']?>
			</div>

		</div>

	</div>

</div>
<?
include_once ('../pop.admin.tail.php');