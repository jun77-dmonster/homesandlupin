<?php
$sub_menu = '200730';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$beverage_cate_code = '02002';

$sql_common = " from {$DM['BEVERAGE_TABLE']} as t1 join {$DM['CODE_TABLE']} as t2 on t1.beverage_cate=t2.item_cd ";

$sql_search = " where t1.beverage_display_fl='T' and  t1.beverage_delete_fl='F' and t2.group_cd='{$beverage_cate_code}' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'beverage_cd' :
        case 'beverage_kor_nm' :
        case 'beverage_eng_nm' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "beverage_reg_dt";
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

$g5['title'] = '식음료 목록';
include_once ('../../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="11";

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
					<option value="beverage_kor_nm" <?php echo ($sfl=="beverage_kor_nm")?"selected":""?>>푸드이름(한글)</option>
					<option value="beverage_eng_nm" <?php echo ($sfl=="beverage_eng_nm")?"selected":""?>>푸드이름(영문)</option>
				</select>
				<div class="inputbox-wrap">
					<input type="text" name="stx" class="frm_input" value="<?php echo $stx?>" style="width:650px">
				</div>
			</td>
			<td rowspan="2" class="search_btn_wrap">
				<div class="search_btn_box">
					<button class="tbBtn type-red">검색</button>
					<button class="tbBtn type-white">초기화</button>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row">상품유형</th>
			<td>

				<div class="inputbox-wrap">
					<span class="checkbox_item marR10">
						<input type="checkbox" name="g_best"  value="T" <?php echo ($g_best=="T")?"checked":""?> id="g_best">
						<label for="g_best" >베스트</label>
					</span>
					<span class="checkbox_item marR10">
						<input type="checkbox" name="g_new"  value="T" <?php echo ($g_new=="T")?"checked":""?> id="g_new">
						<label for="g_new" >신상품</label>
					</span>
				</div>

			</td>
		</tr>
	</table>

	</form>

	</div>

</div>

<form name="beverageList" id="beverageList" action="./food_list_update.php" onsubmit="return beverageList_submit(this);" method="post">
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

				<span class="table-tit">등록된 푸드 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록
					<!--<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>-->
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>

				</div>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th scope="col">
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th>이미지</th>
						<th>코드</th>
						<th>카테고리</th>
						<th>한글명/영문명</th>
						<th>가격</th>
						<th>베스트</th>
						<th>신상</th>
						<th>노출여부</th>
						<th>등록일</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./food_register.php?w=u&amp;beverage_cd={$row['beverage_cd']}' class='board_copy btn btn_02'>수정</a>";

						$beverage_dir = G5_DATA_URL.'/beverage';
						$beverage_img = $beverage_dir."/".$row['beverage_file'];						
						//$game_img = get_games_image($row['games_cd'], 100, 100);
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="beverage_cd[<?php echo $i ?>]" value="<?php echo $row['beverage_cd'] ?>" id="beverage_cd<?php echo $i ?>">
						</td>
						<td class="td_img3"><img src="<?php echo $beverage_img?>" style='width:100px;'></td>
						<td class="td_category"><?php echo $row['beverage_cd']?></td>
						<td class="td_category"><?php echo $row['beverage_cate']?></td>
						<td class="td_addr"><?php echo $row['beverage_kor_nm']?> / <?php echo $row['beverage_eng_nm']?></td>
						<td class="td_paybybig"><?php echo number_format($row['beverage_price'])?> 원</td>
						<td class="td_num"><input type="checkbox" name="beverage_best_icon[<?php echo $i?>]" value="T" <?php echo ($row['beverage_best_icon']=="T")?"checked":""?>></td>
						<td class="td_num"><input type="checkbox" name="beverage_new_icon[<?php echo $i?>]" value="T" <?php echo ($row['beverage_new_icon']=="T")?"checked":""?>></td>
						<td class="td_cnt"><?php echo ($row['beverage_display_fl']=="T")?"노출":"미노출"?></td>
						<td class="td_date"><?php echo substr($row['beverage_reg_dt'],0,10)?></td>
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

			<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

		</div>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./food_register.php?<?php echo $qstr ?>" class="btn btn_01">신규 푸드 등록</a>
</div>

</form>

<script>
function beverageList_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 푸드를 정말 삭제시키겠습니까?\n\n삭제되면 모든 지점에서 주문할수 없게 됩니다")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../../admin.tail.php');