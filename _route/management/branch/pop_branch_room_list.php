<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$branch_info = get_branch_info($branch_cd);

$sql_common = " from {$DM['BRANCH_ROOM_TABLE']} ";

$sql_search = " where branch_cd='{$branch_cd}' and room_delete_fl='F' ";

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
    $sst = "uid";
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

$g5['title'] = "{$branch_info['branch_nm']} 게임룸 관리";
include_once ('../../pop.admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 6;

?>

<div class="layer-popup">

	<div class="wrapper type-1200">

		<div class="container-wrap">

			<form id="createRoom" action="./pop_branch_room_make.php" name="fcreate" method="post">
			<input type="hidden" name="branch_cd" value="<?php echo $branch_cd?>">
			
			<div class="box-view-wrap">	
				<div class="view-title"><?php echo $branch_info['branch_nm']?> 게임룸 관리 (생성된 룸 : <?php echo $total_count;?> )</div>

				<div class="box-cont type-3">

					<table class="ncp_tbl">
					<colgroup>
					<col style="width:200px;">
					<col style="width:auto;">
					<col style="width:140px;">
					</colgroup>
					<tbody>
					<tr>
						<th scope="row">생성할 룸 갯수</th>
						<td>
							<div class="inputbox-wrap">
								<input type="text" name="room_cnt" class="frm_input" style='width:250px' value="0">
							</div>
						</td>
						<td rowspan="2" class="search_btn_wrap">
							<div class="search_btn_box" style="text-align:center;">
								<button type="submit" class="tbBtn type-red" style='width:120px;'>게임룸생성</button>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row">생성할 룸 비밀번호</th>
						<td>
							<div class="inputbox-wrap">
								<input type="text" name="room_pwd" class="frm_input required" required maxlength="4" style='width:250px' placeholder="비밀번호 숫자 네자리"  onKeyup="this.value=this.value.replace(/[^-0-9]/g,'');">
							</div>
						</td>
					</tr>
					</tbody>
					</table>

				</div>

			</div>

			

			</form>

		</div>

		<div class="content-bottom-wrap2">
			
		<form name="fPopBranchRoomlist" id="fPopBranchRoomlist" action="./pop_branch_room_list_update.php" onsubmit="return fPopBranchRoomlist_submit(this);" method="post">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="token" value="">
		<input type="hidden" name="branch_cd" value="<?php echo $branch_cd ?>">

		<div class="contents type-3">
		
			<div class="box-cont type-3">

				<div class="inner-table-wrap type-2 scroll">

					<div class="table-tit-area2">

						<div class="btn-wrap-right marB20">

							<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>
							<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="crmBtn type-white">선택수정</button>

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
							<th>ROOM코드</th>
							<th>ROOM번호</th>
							<th>ROOM비밀번호</th>
							<th>등록일</th>
						</tr>
						</thead>
						<tbody>
						<?php
						for ($i=0; $row=sql_fetch_array($result); $i++) {
						?>
						<tr>
							<td class="td_chk">
								<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
								<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid_<?php echo $i ?>">
							</td>
							<td class="td_category"><?php echo $row['room_cd']?></td>
							<td class="td_category"><?php echo $row['room_no']?></td>
							<td class="td_addr">
								<input type="text" name="room_pwd[<?php echo $i?>]" value="<?php echo $row['room_pwd_enc']?>" class="frm_input">
							</td>
							<td class="td_date"><?php echo $row['room_reg_dt']?></td>
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

		</form>

		</div><!--//content-bottom-wrap2-->

	</div>
	
</div>

<script>
function fPopBranchRoomlist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }


	return true;

}
</script>
<?
include_once ('../../pop.admin.tail.php');