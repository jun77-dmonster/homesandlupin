<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$r1 = sql_fetch("select * from {$DM['B_TEMPLATE_TABLE']} where uid='{$uid}'");

if($r1['template_gubun']=="GAME"){

	$sql_common = " from {$DM['BOARD_GAMES_TABLE']} ";

	$sql_search = " where games_delete_fl='F' and games_cd not in(select data_cd from {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$uid}') ";

	if (!$sst) {
		$sst = "games_nm";
		$sod = "asc";
	}

}else if($r1['template_gubun']=="RGAME"){

	$sql_common = " from {$DM['BOARD_GAMES_TABLE']} ";

	$sql_search = " where games_delete_fl='F' and games_cd not in(select data_cd from {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$uid}') ";

	if (!$sst) {
		$sst = "games_nm";
		$sod = "asc";
	}

}else{

	$sql_common = " from {$DM['BEVERAGE_TABLE']} ";

	$sql_search = " where beverage_delete_fl='F' and beverage_cd not in(select data_cd from {$DM['BD_TEMPLATE_TABLE']} where template_uid='{$uid}') ";

	if (!$sst) {
		$sst = "beverage_kor_nm";
		$sod = "asc";
	}

}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$g5['title'] = "{$r1['template_title']} 템플릿 DATA";
include_once ('../pop.admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="4";
?>

<div class="layer-popup">

	<div class="type-1200">

		<div class="view-title"><?php echo $r1['template_title']?> 템플릿 등록 </div>

		<div class="content-bottom-wrap2">

		<?php
		//구분에 따라 리스트 다름
		if($r1['template_gubun']=="GAME"){
			include_once('./game_skin.php');
		}else if($r1['template_gubun']=="RGAME"){
			include_once('./rgame_skin.php');
		}else{
			include_once('./beverage_skin.php');
		}
		?>

		</div>

	</div>

</div>

<?
include_once ('../pop.admin.tail.php');