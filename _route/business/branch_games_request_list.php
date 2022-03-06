<?php
$sub_menu = '400300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['GAME_REQUEST_TABLE']} as t1 join {$DM['BRANCH_TABLE']} as t2 on t1.branch_cd=t2.branch_cd ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 't2.branch_nm' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "t1.od_id";
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


$g5['title'] = '지점 추천게임 요청 목록';
include_once ('../admin.head.php');

$sql = " select t1.*, t2.branch_nm {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="7";

?>

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
						<option value="games_nm" <?php echo ($sfl=="games_nm")?"selected":""?>>지점이름</option>
					</select>
					<div class="inputbox-wrap">
						<input type="text" name="stx" class="frm_input" value="<?php echo $stx?>" style="width:650px">
					</div>
				</td>
				<td rowspan="5" class="search_btn_wrap">
					<div class="search_btn_box">
						<button type="submit" class="tbBtn type-red">검색</button>
						<button type="button" class="tbBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">초기화</button>
					</div>
				</td>
			</tr>
		</table>

		</form>

	</div>

</div>


<form name="requestlist" id="requestlist" action="./branch_games_request_list_update.php" onsubmit="return requestlist_submit(this);" method="post">
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

				<span class="table-tit">등록된 요청건 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록</button>
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>

				</div>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th>
							<label for="chkall" class="sound_only">게시판 전체</label>
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th>신청번호</th>
						<th>지점명(코드)</th>
						<th>게임수량</th>
						<th>신청상태</th>
						<th>신청일자</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./branch_games_request_view.php?od_id={$row['od_id']}' class='board_copy btn btn_03'>보기</a>";
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id<?php echo $i ?>">
						</td>
						<td class="td_odrnum"><?php echo $row['od_id']?></td>
						<td class="td_addr"><?php echo $row['branch_nm']?> (<?php echo $row['branch_cd']?>)</td>
						<td class="td_num"><?php echo $row['od_cart_count']?></td>
						<td class="td_category"><?php echo $row['od_status']?></td>
						<td class="td_datetime"><?php echo $row['od_time']?></td>
						<td class="td_mng">
							<?php echo $s_mod?>
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

</form>

<script>
function requestlist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 공지사항을 정말 삭제시키겠습니까?")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../admin.tail.php');