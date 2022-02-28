<?php
$sub_menu = '200400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['POPUP_TABLE']} ";

$sql_search = " where (1) ";

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

<form name="popuplist" id="popuplist" action="./popup_list_update.php" onsubmit="return popupist_submit(this);" method="post">
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
	
				<span class="table-tit">등록된 팝업 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 삭제</button>
					<!--<button type="button" class="crmBtn type-white" onclick="location.href='./faq_register.php'">신규 등록</button>-->

				</div>

				<div class="content_item_bx">

					<div class="tbl_head01 tbl_wrap">

						<table>
						<caption><?php echo $g5['title']; ?> 목록</caption>
						<thead>
						<tr>
							<th scope="col">
								<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
							</th>
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
						$s_mod = "<a href='./popup_register.php?w=u&amp;nw_uid={$row['nw_uid']}' class='board_copy btn btn_02'>수정</a>";
						?>
						<tr>
							<td class="td_chk">
								<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
								<input type="hidden" name="nw_uid[<?php echo $i ?>]" value="<?php echo $row['nw_uid'] ?>" id="nw_uid<?php echo $i ?>">
							</td>
							<td class="td_num"><?php echo $row['nw_uid']?></td>
							<td class="td_code"><?php echo ($row['nw_display']=="B0000")?"전체지점":get_branch_name($row['nw_display'])?></td>
							<td class="td_addr"><?php echo $row['nw_title']?></td>
							<td class="td_date"><?php echo substr($row['nw_begin_time'],0,10)?></td>
							<td class="td_date"><?php echo substr($row['nw_end_time'],0,10)?></td>
							<td class="td_num_c4"><?php echo $row['nw_disable_hours']?></td>
							<td class="td_num_c4"><?php echo $row['nw_width']?></td>
							<td class="td_num_c4"><?php echo $row['nw_height']?></td>
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

</div>

<div class="btn_fixed_top">
    <a href="./popup_register.php?<?php echo $qstr ?>" class="btn btn_01">팝업 등록</a>
</div>

</form>
<script>
function popupist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../admin.tail.php');