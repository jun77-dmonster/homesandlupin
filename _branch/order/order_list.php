<?php
$sub_menu = '300100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['ORDER_TABLE']} as t1 join ( select od_id, branch_cd, room_cd  from {$DM['CART_TABLE']} where branch_cd='{$branch['branch_cd']}' group by od_id ) as t2 on t1.od_id=t2.od_id ";

$sql_search = " where od_status IN('주문','접수','호출') ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'beverage_kor_nm' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if($fr_date && $to_date){

	$sql_search .= " and ( ";
	$sql_search .= " date_format(t1.od_time,'%Y-%m-%d') between '{$fr_date}' and '{$to_date}' ";
	$sql_search .= " ) ";

}

if($sfl_branch){

	$sql_search .= " and ( t2.branch_cd='{$sfl_branch}' )";

}

if (!$sst) {
    $sst = "od_time";
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

$g5['title'] = '지점 주문 현황';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="9";
?>
<script src="<?php echo G5_JS_URL ?>/jquery.dmonster_register.js"></script>
<div class="box-view-wrap">

	<div class="search_box search_field">

		<form id="searchForm" name="fsearch" method="get">
		<input type="hidden" name="today" value="<?php echo G5_TIME_YMD?>">

		<table class="ncp_tbl" style='margin:20px 0 20px 0;'>
			<colgroup>
				<col style='width:120px;'>
				<col>
				<col style='width:140px;'>
			</colgroup>
			<tr>
				<th scope="row">검색어</th>
				<td>
					<select class="small" name="sfl" style='width:200px;'>
						<option value="od_id" <?php echo ($sfl=="od_id")?"selected":""?>>주문번호</option>
					</select>
					<div class="inputbox-wrap">
						<input type="text" name="stx" class="frm_input" value="<?php echo $stx?>" style="width:600px">
					</div>
				</td>
				<td rowspan="2" class="search_btn_wrap">
					<div class="search_btn_box">
						<button class="tbBtn type-red">검색</button>
						<button type="button" class="tbBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">초기화</button>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row">일자검색</th>
				<td>
					<div>
						<span class="period_wrap">
							<button class="period" onclick="inputDate('fr_date', 'to_date', 'T', 0)" type="button">오늘</button>
							<button class="period" onclick="inputDate('fr_date', 'to_date', 'D', 7)" type="button">1주일</button>
							<button class="period" onclick="inputDate('fr_date', 'to_date', 'D', 15)" type="button">15일</button>
							<button class="period" onclick="inputDate('fr_date', 'to_date', 'M', 1)" type="button">1개월</button>
							<button class="period" onclick="inputDate('fr_date', 'to_date', 'M', 3)" type="button">3개월</button>
							<button class="period" onclick="inputDate('fr_date', 'to_date', 'W', 0)"type="button">전체</button>
						</span>
						<span class="date-picker_wrap">
							<input type="text" name="fr_date" id="fr_date" maxlength="10" readonly value="<?php echo $fr_date?>" class="frm_input date-picker startYmd" placeholder="시작일">
						</span>
						<span class="wave-2 text-inline">~</span>
						<span class="date-picker_wrap">
							<input type="text" name="to_date" id="to_date" maxlength="10" readonly value="<?php echo $to_date?>" class="frm_input date-picker startYmd" placeholder="종료일">
						</span>
					</div>
				</td>
			</tr>
		</table>

		</form>

	</div>

	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap marT30">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th>주문번호</th>
						<th>지점</th>
						<th>룸번호</th>
						<th>주문상품수</th>
						<th>금액</th>
						<th>주문일자</th>
						<th>룸호출일자</th>
						<th>주문상태</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
					?>
					<tr>
						<td><?php echo $row['od_id']?></td>
						<td class="td_category1"><?php echo get_branch_name($row['branch_cd'])?></td>
						<td class="td_mng"><?php echo get_room_info($row['room_cd'])?></td>
						<td class="td_mng"><?php echo $row['od_cart_count']?></td>
						<td class="td_paybybig td_price"><?php echo number_format($row['od_cart_price'])?> 원</td>
						<td class="td_datetime"><?php echo $row['od_time']?></td>
						<td class="td_datetime"><?php echo $row['od_room_call_time']?></td>
						<td class="td_mng"><?php echo $row['od_status']?></td>
						<td class="td_mng">
							<a href="./order_view.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="mng_mod btn btn_02">보기</a>
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

				<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

			</div>

		</div>

	</div>


</div>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-05:c+01", maxDate: "+0d" });
});

$(".period").click(function () {
	$('.period').removeClass('on');
	$(this).addClass('on');
});

var f = document.fsearch;

function inputDate(sdate, edate, type, term) {
	cfgInputDate.fr_date = (sdate.nodeType==1) ? sdate : document.getElementById(sdate);
	cfgInputDate.to_date = edate ? ((edate.nodeType==1) ? edate : document.getElementById(edate)) : null;
	cfgInputDate.type = type;
	cfgInputDate.term = term;

	if (type == 'W') {
		if (cfgInputDate.fr_date) cfgInputDate.fr_date.value = '';
		if (cfgInputDate.to_date) cfgInputDate.to_date.value = '';
	}
	else {		
		execInputDate(f.today.value);
	}
}
</script>
<?
include_once ('../admin.tail.php');