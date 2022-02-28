<?php
$sub_menu = '200520';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['BRANCH_TABLE']} ";

$sql_search = " where branch_withdrawal_fl='T' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'branch_cd' :
        case 'branch_manager_id' :
        case 'branch_nm' :
        case 'branch_manager_nm' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

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

$g5['title'] = '운영 지점';
include_once ('../../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan="10";
?>

<form name="branchList" id="branchList" action="./branch_list_update.php" onsubmit="return branchlist_submit(this);" method="post">
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

				<span class="table-tit">탈퇴 지점 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<!--<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>-->
					<button type="submit" name="act_button" value="탈퇴철회" onclick="document.pressed=this.value"  class="crmBtn type-white">탈퇴철회</button>
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
						<th>지점코드</th>
						<th>지점명</th>
						<th>지점아이디</th>
						<th>생성된룸</th>
						<th>등록게임</th>
						<th>주문정보</th>
						<th>고객의소리</th>
						<th>탈퇴일자</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {

						$s_mod = '<a href="./branch_register.php?w=u&amp;branch_cd='.$row['branch_cd'].'&amp;'.$qstr.'" class="btn btn_02">상세보기</a>';

						//생성된룸
						$room = sql_fetch("select count(*) as cnt from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$row[branch_cd]}'");

						//등록게임수
						$games = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$row[branch_cd]}'");

						//주문정보
						$order = sql_fetch("select count(*) as cnt from {$DM['ORDER_TABLE']} where branch_cd='{$row[branch_cd]}'");
						
						//고객의 소리
						$customer = sql_fetch("select count(*) as cnt from {$DM['VOICE_CUSTOMER_TABLE']} where branch_cd='{$row[branch_cd]}'");
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="branch_cd[<?php echo $i ?>]" value="<?php echo $row['branch_cd'] ?>" id="branch_cd_<?php echo $i ?>">
						</td>
						<td class="td_category"><?php echo $row['branch_cd']?></td>
						<td class="td_display"><?php echo $row['branch_nm']?></td>
						<td class="td_addr"><?php echo $row['branch_manager_id']?></td>
						<td class="td_num_c4"><?php echo $room['cnt']?></td>
						<td class="td_num_c4"><?php echo $games['cnt']?></td>
						<td class="td_num_c4"><?php echo $order['cnt']?></td>
						<td class="td_num_c4"><?php echo $customer['cnt']?></td>
						<td class="td_date"><?php echo substr($row['branch_reg_dt'],0,10)?></td>
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

<div class="btn_fixed_top">
    <a href="./branch_register.php?<?php echo $qstr ?>" class="btn btn_01">신규 지점 등록</a>
</div>

</form>
<script>
function branchlist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    /*
	if(document.pressed == "탈퇴철회") {
        if(!confirm("선택한 지점을 정말 탈퇴시키겠습니까?\n\n지점이 탈퇴되면 룸 로그인이 되지 않습니다")) {
            return false;
        }
    }
	*/

    return true;

}
</script>
<?
include_once ('../../admin.tail.php');