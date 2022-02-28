<?php
$sub_menu = '500200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['GAME_REQUEST_TABLE']} ";

$sql_search = " where branch_cd='{$branch['branch_cd']}' ";

if (!$sst) {
    $sst = "od_id";
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

$g5['title'] = '요청 현황 목록';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="6";
?>

<form name="requestList" id="requestList" action="./games_request_list_update.php" onsubmit="return requestList_submit(this);" method="post">
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

				<span class="table-tit">요청 현황 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<!--<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록</button>-->
					<button type="submit" name="act_button" value="선택취소" onclick="document.pressed=this.value"  class="crmBtn type-white">선택취소</button>

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
						<th>요청번호</th>
						<th>요청게임수</th>
						<th>요청일자</th>
						<th>요청현황</th>
						<th>보기</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./games_request_view.php?od_id={$row['od_id']}' class='board_copy btn btn_03'>보기</a>";
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id<?php echo $i ?>">
						</td>
						<td class="td_addr"><?php echo $row['od_id']?></td>
						<td class="td_cnt"><?php echo $row['od_cart_count']?></td>
						<td class="td_datetime"><?php echo $row['od_time']?></td>
						<td class="td_category"><?php echo $row['od_status']?></td>
						<td class="td_mng"><?php echo $s_mod?></td>
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
			
			<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>


		</div>

	</div>

</div>

</form>

<script>
function requestList_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택취소") {
        if(!confirm("선택한 요청 목록을 정말 취소시키겠습니까?\n\n취소 되어도 신청했던 기록은 남게됩니다")) {
            return false;
        }
    }

    return true;

}
</script>

<?
include_once ('../admin.tail.php');