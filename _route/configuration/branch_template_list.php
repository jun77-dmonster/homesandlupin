<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['B_TEMPLATE_TABLE']} ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'template_gubun' :
        case 'template_title' :
            $sql_search .= " ({$sfl} like '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "uid";
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


$g5['title'] = '지점 생성 템플릿';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 6;
?>

<form name="ftemplatelist" id="ftemplatelist" action="./branch_templage_list_update.php" onsubmit="return ftemplatelist_submit(this);" method="post">
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

				<span class="table-tit">등록된 템플릿 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white">선택수정</button>
					<button type="button" class="crmBtn type-white">선택삭제</button>

				</div>

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
						<th>구분</th>
						<th>제목</th>
						<th>등록갯수</th>
						<th>사용유무</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./branch_template_write.php?{$qstr}&amp;w=u&amp;uid={$row['uid']}' class='board_copy btn btn_02'>수정</a>";

						switch($row['template_gubun']){
							case "GAME" : $text = "게임";		break;
							case "RGAME" : $text = "추천게임";	break;
							case "BEVERAGE" : $text = "식음료"; break;
						}
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="uid" value="<?php echo $i ?>" id="uid_<?php echo $i ?>">
						</td>
						<td class="td_category"><?php echo $text;?></td>
						<td class="td_addr"><?php echo $row['template_title']?></td>
						<td class="td_num"><?php echo $row['template_data_cnt']?></td>
						<td class="td_category">
							<select name="template_use_fl[<?php echo $i?>]">
								<option value="T" <?php echo ($row['template_use_fl']=="T")?"selected":""?>>사용</option>
								<option value="F" <?php echo ($row['template_use_fl']=="F")?"selected":""?>>미사용</option>
							</select>
						</td>
						<td class="td_mng">
							<?php echo $s_mod?>
						</td>
					</tr>
					<?
					}
					if ($i == 0)
					echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">등록된 운영자가 없습니다.</td></tr>";
					?>
					</tbody>
					</table>

				</div>

			</div>

		</div>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./branch_template_write.php" id="bo_add" class="ftBtn type-red">템플릿 생성</a>
</div>

</form>
<script>
function ftemplatelist_submit(f){

	

}
</script>
<?
include_once ('../admin.tail.php');