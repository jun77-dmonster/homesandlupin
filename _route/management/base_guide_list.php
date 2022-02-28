<?php
$sub_menu = '200100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['BASE_GUIDE_TABLE']} as t1 join {$DM['BRANCH_TABLE']} as t2 on t1.branch_cd=t2.branch_cd ";

$sql_search = " where (1) and t2.branch_withdrawal_fl='F' and t1.guide_delete_fl='F' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'branch_cd' :
        case 'guide_title' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "t1.uid";
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

$g5['title'] = '지점별 이용안내 목록';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 14;

?>

<div class="box-view-wrap">

	<div class="search_box search_field">

	<form id="searchForm" name="fsearch" method="get">

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
				<option value="t1.branch_cd" <?php echo ($sfl=="t1.branch_cd")?"selected":""?>>지점코드</option>
				<option value="t2.branch_nm" <?php echo ($sfl=="t2.branch_nm")?"selected":""?>>지점이름</option>
			</select>
			<div class="inputbox-wrap">
				<input type="text" name="stx" class="frm_input" value="<?php echo $stx?>" style="width:600px">
			</div>
		</td>
		<td class="search_btn_wrap">
			<div class="search_btn_box">
				<button type="submit" class="tbBtn type-red">검색</button>
				<button type="button" class="tbBtn type-white">초기화</button>
			</div>
		</td>
	</tr>
	</table>

	</form>

	</div>

</div>

<form name="guideList" id="guideList" action="./base_guide_list_update.php" onsubmit="return guideList_submit(this);" method="post">
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

				<span class="table-tit">등록된 지점 이용안내 <span class="num"><?php echo $total_count?></span> 건</span>

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
						<th rowspan="2"><input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></th>
						<th rowspan="2">지점코드</th>
						<th rowspan="2">지점이름</th>
						<th rowspan="2">이용안내</th>
						<th rowspan="2">wife/운영시간</th>
						<th rowspan="2">주문하기화면</th>
						<th rowspan="2">이용안내영상</th>
						<th colspan="6">인원별 추천게임</th>
						<th rowspan="2">관리</th>
					</tr>
					<tr>
						<th>2인</th>
						<th>3인</th>
						<th>4인</th>
						<th>5인</th>
						<th>6인</th>
						<th>7인</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./base_guide_register.php?w=u&amp;branch_cd={$row['branch_cd']}' class='board_copy btn btn_02'>수정</a>";
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="branch_cd[<?php echo $i ?>]" value="<?php echo $row['branch_cd'] ?>" id="branch_cd<?php echo $i ?>">
						</td>
						<td class="td_code"><?php echo $row['branch_cd']?></td>
						<td class="td_addr"><?php echo $row['branch_nm']?></td>
						<td class="td_cnt"><?php echo ($row['guide_file1'])?"지점":"기본"?></td>
						<td class="td_cnt"><?php echo ($row['guide_file2'])?"지점":"기본"?></td>
						<td class="td_cnt"><?php echo ($row['guide_basic_order_img'])?"지점":"기본"?></td>
						<td class="td_cnt"><?php echo ($row['guide_operation_guide_movie'])?"지점":"기본"?></td>
						<td class="td_cntsmall"><?php echo ($row['guide_player2_img'])?"지점":"기본"?></td>
						<td class="td_cntsmall"><?php echo ($row['guide_player3_img'])?"지점":"기본"?></td>
						<td class="td_cntsmall"><?php echo ($row['guide_player4_img'])?"지점":"기본"?></td>
						<td class="td_cntsmall"><?php echo ($row['guide_player5_img'])?"지점":"기본"?></td>
						<td class="td_cntsmall"><?php echo ($row['guide_player6_img'])?"지점":"기본"?></td>
						<td class="td_cntsmall"><?php echo ($row['guide_player7_img'])?"지점":"기본"?></td>
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

		</div>

	</div>

</div>




<div class="btn_fixed_top">
    <a href="./base_guide_register.php?<?php echo $qstr ?>" class="btn btn_01">지점 이용안내 등록</a>
</div>

</form>
<script>
function guideList_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 지점 이용안내를 정말 삭제시키겠습니까?\n\n삭제되면 해당지점 이용안내가 삭제되고 기본 이용안내가 출려됩니다")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../admin.tail.php');