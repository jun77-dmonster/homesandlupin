<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$branch_info = get_branch_info($branch_cd);

$g5['title'] = "{$branch_info['branch_nm']} 게임 관리";
include_once ('../../pop.admin.head.php');

$sql_common = " from {$DM['BRANCH_BEVERAGE_TABLE']} as t1 join {$DM['BEVERAGE_TABLE']} as t2 on t1.beverage_cd=t2.beverage_cd  ";

$sql_search = " where t1.branch_cd='{$branch_info['branch_cd']}' and t1.delete_fl='F' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'subject' :
        case 'content' :
        case 'answer' :
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

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="10";
?>

<div class="layer-popup">

	<div class="wrapper type-1200">

		<div class="container-wrap">

			<div class="box-view-wrap">	
			
				<div class="view-title"><?php echo $branch_info['branch_nm']?> 등록된 식음료 : <?php echo $total_count;?> 건</div>

				<div class="content-bottom-wrap2">

				<form name="fPopBranchBeveragelist" id="fPopBranchBeveragelist" action="./pop_beverage_list_update.php" onsubmit="return fPopBranchBeveragelist_submit(this);" method="post">
				<input type="hidden" name="sst" value="<?php echo $sst ?>">
				<input type="hidden" name="sod" value="<?php echo $sod ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<input type="hidden" name="token" value="">
				<input type="hidden" name="branch_cd" value="<?php echo $branch_cd ?>">

				<div class="contents type-3">

					<div class="inner-table-wrap type-2 scroll">

						<div class="table-tit-area2">

							<div class="btn-wrap-right marB20">

								<button type="button" class="crmBtn type-white" onclick="location.href='./pop_beverage_register.php?branch_cd=<?php echo $branch_cd?>'">지점 식음료 등록</button>
								<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>

							</div>

						</div><!--//table-tit-area-->

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
							</tr>
							</thead>
							<tbody>
							<?php
							for ($i=0; $row=sql_fetch_array($result); $i++) {

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
								<td class="td_category"><?php echo get_code_name($row['beverage_cate'])?></td>
								<td class="td_addr"><?php echo $row['beverage_kor_nm']?> / <?php echo $row['beverage_eng_nm']?></td>
								<td class="td_paybybig"><?php echo number_format($row['beverage_price'])?> 원</td>
								<td class="td_num"><input type="checkbox" name="beverage_best_icon[<?php echo $i?>]" value="T" <?php echo ($row['beverage_best_icon']=="T")?"checked":""?>></td>
								<td class="td_num"><input type="checkbox" name="beverage_new_icon[<?php echo $i?>]" value="T" <?php echo ($row['beverage_new_icon']=="T")?"checked":""?>></td>
								<td class="td_cnt"><?php echo ($row['beverage_display_fl']=="T")?"노출":"미노출"?></td>
								<td class="td_date"><?php echo substr($row['beverage_reg_dt'],0,10)?></td>
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

				</form>

				</div>

			</div>

		</div>

	</div>

</div>

<script>
function fPopBranchBeveragelist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

	
	if(document.pressed == "선택삭제") {
        if(!confirm("선택한 식음료를 정말 <?php echo $branch_info['branch_nm'];?> 지점에서 삭제 시키겠습니까?")) {
            return false;
        }
    }

	return true;

}
</script>

<?
include_once ('../../pop.admin.tail.php');