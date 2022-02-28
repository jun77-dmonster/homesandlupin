<?php
$sub_menu = '500100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['SEARCHWORD_TABLE']} ";

$sql_search = " where (1)  group by search_word  ";

if($fr_date && $to_date){

	$sql_search .= " and ( ";
	$sql_search .= " date_format(reg_dt,'%Y-%m-%d') between '{$fr_date}' and '{$to_date}' ";
	$sql_search .= " ) ";

}

if (!$sst) {
    $sst = "sum_cnt";
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

$g5['title'] = '검색어분석';

include_once ('../admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$sql = " select search_word, sum(cnt) as sum_cnt {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 2;
?>
<script src="<?php echo G5_JS_URL ?>/jquery.dmonster_register.js"></script>
<div class="box-view-wrap">

	<div class="notice-box">
		<ul>
			<li>검색창에서 검색한 전체 검색어에 대한 조회순기준의 통계 입니다.</li>
		</ul>
	</div>

	<div class="search_box search_field">

		<form id="searchForm" name="fsearch" method="get">
		<input type="hidden" name="today" value="<?php echo G5_TIME_YMD?>">

			<table class="ncp_tbl">

			<colgroup>
				<col style='width:120px;'>
				<col style='width:auto'>
				<col style='width:140px;'>
			</colgroup>
			<tbody>
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
				<td rowspan="2" class="search_btn_wrap">
					<div class="search_btn_box">
						<button type="submit" class="tbBtn type-red">검색</button>
						<button type="button" class="tbBtn type-white">초기화</button>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"></th>
				<td></td>
			</tr>
			<tr>
				<th scope="row"></th>
				<td></td>
				<td></td>
			</tr>
			</tbody>
			</table>

		</form>

	</div>

</div>

<div class="box-view-wrap">

	<div class="mall-products-view">

		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">등록된 검색어 <span class="num">0</span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록</button>
					<!-- 관리자 검색 테스트-->
					<button type="button" onclick="openSearch()" class="crmBtn type-white">검색테스트</button>

				</div>

			</div><!--//table-tit-area-->
			
			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap marT10">
		
					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<colgroup>
						<col style="width:250px">
						<col style="width:auto">
					</colgroup>
					<thead>
					<tr>
						<th>검색어</th>
						<th>조회수</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
					?>
					<tr>
						<td><?php echo $row['search_word']?></td>
						<td><?php echo $row['sum_cnt']?></td>
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

function openSearch(){

	var _width	= '1200';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_search_word.php";

	
	var new_win = window.open(href, "pop_search_word", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>
<?
include_once ('../admin.tail.php');