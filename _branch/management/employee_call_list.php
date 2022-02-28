<?php
$sub_menu = '200600';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['GAMES_REQUEST_DESCRIPTION_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd ";

$sql_search = " where t1.branch_cd='{$branch['branch_cd']}' ";

//$sql_search = " where t1.branch_cd='{$branch['branch_cd']}' and date_format(t1.request_reg_dt,'%Y-%m-%d') = '".G5_TIME_YMD."' ";

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
    $sst = "t1.request_reg_dt";
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


$g5['title'] = '직원 호출 관리';
include_once ('../admin.head.php');

$sql = " select t1.uid, t1.room_cd, t1.branch_cd, t1.games_cd, t1.request_reg_dt, t1.request_status, t1.request_confirm_dt, t2.games_nm, t2.games_img_file {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 7;

?>

<div class="box-view-wrap">
	
	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">직원 호출 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록
					<!--<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>-->
					<!--
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>
					<!--<button type="button" class="crmBtn type-white" onclick="location.href='./branch_register.php'">신규 지점 등록</button>-->

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
						<th>번호</th>
						<th>룸번호</th>
						<th>게임이미지</th>
						<th>게임명</th>
						<th>상태</th>
						<th>호출일자</th>
						<th>확인일자</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = "<a href='./employee_call_update.php?uid={$row['uid']}' class='board_copy btn btn_02'>직원확인</a>";

						$games_dir = G5_DATA_URL.'/boardgames';
						$game_img = $games_dir."/".$row['games_img_file'];						
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid<?php echo $i ?>">
						</td>
						<td class="td_num"><?php echo $row['uid']?></td>
						<td class="td_category"><?php echo get_room_info($row['room_cd'])?></td>
						<td class="td_img2"><img src="<?php echo $game_img?>" style='width:80px;'></td>
						<td class="td_addr"><?php echo $row['games_nm']?> (<?php echo $row['games_cd']?>)</td>
						<td class="td_category"><?php echo ($row['request_status']=="request")?"고객호출":"직원확인"?></td>
						<td class="td_datetime"><?php echo substr($row['request_reg_dt'],0,10)?></td>
						<td class="td_datetime"><?php echo substr($row['request_confirm_dt'],0,10)?></td>
						<td class="td_mng">
							<?php 
								if($row['request_status']=="request"){
									echo $s_mod;
								}
							?>
						</td>
					</tr>
					<?php
					}
					if ($i == 0)
						echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
					?>
					</tbody>
					</table>

					<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

				</div>

			</div>

		</div>

	</div>

</div>

<?
include_once ('../admin.tail.php');