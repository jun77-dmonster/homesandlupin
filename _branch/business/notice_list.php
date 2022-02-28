<?php
$sub_menu = '400100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['NOTICE_TABLE']} ";

$sql_search = " where notice_gubun in('B0000','{$branch['branch_cd']}') and open_fl='T' and delete_fl='F' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'notice_title' :
        case 'notice_content' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "uid";
    $sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$g5['title'] = '지점 공지사항';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 7;
?>

<form name="fNoticelist" id="fNoticelist" action="./notice_list_update.php" onsubmit="return fNoticelist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">


<div class="box-view-wrap">

	<div class="mall-products-view">

		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">등록된 공지사항 총 <span class="num"><?php echo $total_count ?></span> 건</span>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th>구분</th>
						<th>제목</th>
						<th>조회수</th>
						<th>등록일</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
					?>
					<tr>
						<td class="td_category"><?php echo ($row['notice_gubun']=="B0000")?"전체지점":get_branch_name($row['notice_gubun'])?></td>
						<td class="td_addr"><a href="./notice_view.php?uid=<?php echo $row['uid']?>"><?php echo $row['notice_title']?></a></td>
						<td class="td_cnt"><?php echo $row['notice_hit']?></td>
						<td class="td_datetime"><?php echo $row['reg_dt']?></td>
					</tr>
					<?php
					}
					if ($i == 0)
						echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
					?>
					</tbody>
					</table>

				</div>

			</div>


		</div>

	</div>

</div>

<div class="btn_fixed_top">
    <!--<a href="./branch_notice_write.php?<?php echo $qstr ?>" class="btn btn_01">공지사항 등록</a>-->
</div>

</form>
<script>
function fNoticelist_submit(f){

	

}
</script>
<?
include_once ('../admin.tail.php');