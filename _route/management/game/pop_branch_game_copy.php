<?php
$sub_menu = '200610';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$game = get_game_info($games_cd);

$g5['title'] = "지점 게임 등록";
include_once ('../../pop.admin.head.php');

$sql_common = " from {$DM['BRANCH_TABLE']} ";

$sql_search = " where branch_withdrawal_fl='F' and branch_cd not in (select branch_cd from {$DM['BRANCH_GAEMS_TABLE']} where games_cd='{$games_cd}') ";

if (!$sst) {
    $sst = "branch_reg_dt";
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

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="3";
?>

<form name="frmBranchCopy" id="frmBranchCopy" action="./pop_branch_game_copy_update.php" onsubmit="return frmBranchCopy_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="games_cd" value="<?php echo $games_cd?>">

<div class="layer-popup">

	<div class="wrapper type-600">

		<div class="container-wrap">

			<div class="box-view-wrap2">	

				<div style='width:540px; padding:20px; margin:0 auto;'>

					<div class="table-tit-area" style='border-bottom:1px solid #ccc;'>

						<span class="table-tit"><?php echo $game['games_nm']?> >  지점 게임 복사 </span>

						<div class="btn-wrap-right">

							<button type="submit" name="act_button" value="지점등록" onclick="document.pressed=this.value" class="crmBtn type-white">지점등록</button>

						</div><!--//btn-wrap-left-->

					</div><!--//table-tit-area-->

					<div class="content-bottom-wrap2">

						<div class="contents type-0">

							<div class="tbl_head01 tbl_wrap">

								<table>
								<caption><?php echo $g5['title']; ?> 목록</caption>
								<thead>
								<tr>
									<th scope="col">
										<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
									</th>
									<th>지점코드</th>
									<th>지점명</th>
								</tr>
								</thead>
								<tbody>
								<?php
								for ($i=0; $row=sql_fetch_array($result); $i++) {
								?>
								<tr>
									<td class="td_chk">
										<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
										<input type="hidden" name="branch_cd[<?php echo $i ?>]" value="<?php echo $row['branch_cd'] ?>" id="branch_cd<?php echo $i ?>">
									</td>
									<td class="td_category"><?php echo $row['branch_cd']?></td>
									<td class="td_addr"><?php echo $row['branch_nm']?></td>
								</tr>
								<?php
								}
								if ($i == 0)
									echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
								?>
								</tbody>
								</table>

							</div>
							<!--
							<div style='margin:0 auto; line-height:20px; padding:10px;'>
								
								<p>게임을 등록 할 지점을 선택하여 등록을 클릭</p>
								<p>해당 게임을 등록한 지점은 나타나지 않습니다.</p>

							</div>
							-->


						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>
	

</form>

<script>
function frmBranchCopy_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

	return true;

}
</script>

<?
include_once ('../../pop.admin.tail.php');