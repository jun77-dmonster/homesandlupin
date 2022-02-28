<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$r1 = sql_fetch("select * from {$DM['B_TEMPLATE_TABLE']} where uid='{$uid}'");

if($r1['template_gubun']=="GAME" || $r1['template_gubun']=="RGAME"){

$sql_common = " from {$DM['BD_TEMPLATE_TABLE']} as t1 join  {$DM['BOARD_GAMES_TABLE']} as t2 on t1.data_cd=t2.games_cd";

$sql_search = " where t1.template_uid='{$uid}' ";

if (!$sst) {
    $sst = "t1.uid";
    $sod = "desc";
}

}else{

$sql_common = " from {$DM['BD_TEMPLATE_TABLE']} as t1 join  {$DM['BEVERAGE_TABLE']} as t2 on t1.data_cd=t2.beverage_cd";

$sql_search = " where t1.template_uid='{$uid}' ";

if (!$sst) {
    $sst = "t1.uid";
    $sod = "desc";
}

}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";

$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 10;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$g5['title'] = "{$r1['template_title']} 템플릿 DATA";
include_once ('../pop.admin.head.php');

$sql = " select	t1.*, t2.* {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="7";
?>

<div class="layer-popup">

	<div class="type-800">

		<div class="view-title"><?php echo $r1['template_title']?> 템플릿 : <?php echo $total_count;?> 건</div>

		<div class="content-bottom-wrap2">

			<?php
			//구분에 따라 리스트 다름
			if($r1['template_gubun']=="GAME" || $r1['template_gubun']=="RGAME"){
				include_once('./game_data_skin.php');
			}else{
				include_once('./beverage_data_skin.php');
			}
			?>

		</div>

	</div>

</div>


<script>

function frmDatalist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 게임을 정말 삭제시키겠습니까?")) {
            return false;
        }
    }

    return true;

}

</script>
<?
include_once ('../pop.admin.tail.php');

