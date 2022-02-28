<?php
$sub_menu = '200300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['POPUP_TABLE']} ";

$sql_search = " where (1) and nw_display IN ('B0000','{$branch['branch_cd']}') ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'nw_title' :
        case 'nw_display' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "nw_reg_dt";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$g5['title'] = '팝업 관리';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="10";
?>

<div class="box-view-wrap">
	
	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">
	
				<span class="table-tit">등록된 팝업 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="popQna('<?php echo $DM['QNA_CODE4']?>')">지점문의</button>

				</div>


				<div class="content_item_bx marT10">

					<div class="tbl_head01 tbl_wrap">

						<table>
						<caption><?php echo $g5['title']; ?> 목록</caption>
						<thead>
						<tr>
							<th>번호</th>
							<th>지점</th>
							<th>제목</th>
							<th>시작일시</th>
							<th>종료일시</th>
							<th>시간</th>
							<th>width</th>
							<th>height</th>
							<th>관리</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for ($i=0; $row=sql_fetch_array($result); $i++) {
						?>
						<tr>
							<td class="td_num"><?php echo $row['nw_uid']?></td>
							<td class="td_code"><?php echo ($row['nw_display']=="B0000")?"전체지점":get_branch_name($row['nw_display'])?></td>
							<td class="td_addr"><?php echo $row['nw_title']?></td>
							<td class="td_date"><?php echo substr($row['nw_begin_time'],0,10)?></td>
							<td class="td_date"><?php echo substr($row['nw_end_time'],0,10)?></td>
							<td class="td_num_c4"><?php echo $row['nw_disable_hours']?></td>
							<td class="td_num_c4"><?php echo $row['nw_width']?></td>
							<td class="td_num_c4"><?php echo $row['nw_height']?></td>
							<td class="td_mng">
								<button type="button" onclick="openPreView(<?php echo $row['nw_uid']?>)" class='board_copy btn btn_03'>미리보기</button>

								<!--<button type="button" onclick="openPreView(<?php echo $row['nw_uid']?>)" class='board_copy btn btn_02'>지점문의</button>-->
							</td>
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

</div>

</form>
<script>
function openPreView(uid){

	var _width	= '800';
    var _height = '600';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_popup_view.php?nw_uid="+uid;

	
	var new_win = window.open(href, "pop_popup_view", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>
<?
include_once ('../admin.tail.php');