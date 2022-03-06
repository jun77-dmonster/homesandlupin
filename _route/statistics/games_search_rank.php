<?php
$sub_menu = '500200';
include_once('./_common.php');

$g5['title'] = '게임 랭킹';

if($fr_date && $to_date){

	$sql_common = " from (SELECT games_cd, sum(games_play_movie_cnt) AS tot_movie_cnt , sum(games_summary_click_cnt) AS tot_summary_cnt, SUM(games_play_movie_cnt+games_summary_click_cnt) AS total_cnt FROM DM_T_GAMES_COUNT where count_reg_dt between '{$fr_date}' and '{$to_date}' GROUP BY games_cd ) as t1 join {$DM['BOARD_GAMES_TABLE']} AS t2 on t1.games_cd=t2.games_cd ";

}else{

	$sql_common = " from (SELECT games_cd, sum(games_play_movie_cnt) AS tot_movie_cnt , sum(games_summary_click_cnt) AS tot_summary_cnt, SUM(games_play_movie_cnt+games_summary_click_cnt) AS total_cnt FROM DM_T_GAMES_COUNT GROUP BY games_cd ) as t1 join {$DM['BOARD_GAMES_TABLE']} AS t2 on t1.games_cd=t2.games_cd ";

}


$sql_search = " where (1)";

if (!$sst) {
	$sst = "t1.total_cnt";
	$sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

include_once ('../admin.head.php');

$sql = " select t1.*, t2.games_nm, t2.games_img_file {$sql_common} {$sql_search} {$sql_order} limit 0, 30 ";

$result = sql_query($sql);
	
$colspan = 8;
?>
<script src="<?php echo G5_JS_URL ?>/jquery.dmonster_register.js"></script>
<div class="box-view-wrap">
	
	<div class="notice-box">
		<ul>
			<li>게임 이용 영상과 게임 요약의 조회수가 가장 많은 게임 TOP30</li>
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
			</tbody>
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
						<th>순위</th>
						<th>이미지</th>
						<th>게임코드</th>
						<th>게임명</th>
						<th>영상플레이실행</th>
						<th>게임요약조회</th>
						<th>총 조회수</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$games_dir = G5_DATA_URL.'/boardgames';
						$game_img = $games_dir."/".$row['games_img_file'];
						$j=$i+1;
					?>
					<tr>
						<td class="td_num"><?php echo $j?></td>
						<td class="td_img3"><img src="<?php echo $game_img?>" style='width:120px;'></td>
						<td class="td_category"><?php echo $row['games_cd']?></td>
						<td class="td_addr"><?php echo $row['games_nm']?></td>
						<td class="td_category"><?php echo $row['tot_movie_cnt']?></td>
						<td class="td_category"><?php echo $row['tot_summary_cnt']?></td>
						<td class="td_category"><?php echo $row['total_cnt']?></td>
					</tr>
					<?
					}
					if ($i == 0)
					echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">등록된 분류가 없습니다.</td></tr>";
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
</script>
<?
include_once ('../admin.tail.php');