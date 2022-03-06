<?php
$sub_menu = '200620';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '벌칙 룰렛 목록';
include_once ('../../admin.head.php');

$sql_common = " from {$DM['GAMES_PENALTY_TABLE']} ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'penalty_title' :
        case 'penalty_content' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "penalty_reg_dt";
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

$colspan="7";
?>

<form name="penaltyList" id="penaltyList" action="./penalty_roulette_list_update.php" onsubmit="return penaltyList_submit(this);" method="post">
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

				<span class="table-tit">등록된 룰렛 벌칙 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록
					<!--<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>-->
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>
					<!--<button type="button" class="crmBtn type-white" onclick="location.href='./branch_register.php'">신규 지점 등록</button>-->

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
						<th>구분</th>
						<th>이미지</th>
						<th>제목</th>
						<th>조회수</th>
						<th>메인출력</th>
						<th>등록일</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./penalty_roulette_write.php?w=u&amp;uid={$row['uid']}' class='board_copy btn btn_02'>수정</a>";

						$penalty_dir = G5_DATA_URL.'/penalty';
						$penalty_img = $penalty_dir."/".$row['penalty_img'];						

						$penalty_path = G5_DATA_PATH.'/penalty/'.$row['uid'];
						$thumb_path = G5_DATA_PATH.'/penalty/'.$row['uid'].'/thumb';

						$list_img = explode("/",$row['penalty_img']);

						$tname = thumbnail($list_img[1],$penalty_path,$thumb_path,120,120,$is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');

					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid<?php echo $i ?>">
						</td>
						<td class="td_category"><?php echo ($row['gubun_apply']=="B0000")?"전체":get_branch_name($row['gubun_apply'])?></td>
						<td class="td_img2"><img src="<?php echo $penalty_img?>" style='width:70px;'></td>
						<td class="td_addr"><?php echo $row['penalty_title']?></td>
						<td class="td_num"><?php echo $row['penalty_cnt']?></td>
						<td class="td_mng"><?php echo $row['penalty_main_display_fl']?></td>
						<td class="td_datetime"><?php echo $row['penalty_reg_dt']?></td>
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
    <a href="./penalty_roulette_write.php?<?php echo $qstr ?>" class="btn btn_01">벌칙 룰렛 등록</a>
</div>

</form>

<?
include_once ('../../admin.tail.php');