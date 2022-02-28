<?php
$sub_menu = '100200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['MANAGER_TABLE']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'manager_id' :
        case 'manager_nm' :
        case 'manager_nick' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'cell_phone' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "last_login_dt";
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

$g5['title'] = '운영자 관리';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 10;
?>

<div class="box-view-wrap">

	<div class="search_box search_field">

		<form id="">
			
			<table class="ncp_tbl" style='margin:20px 0 20px 0;'>
				<colgroup>
					<col style='width:120px;'>
					<col>
					<col style='width:140px;'>
				</colgroup>
				<tr>
					<th scope="row">검색어</th>
					<td>
						<select name="sfl">
							<option value="manager_id">아이디</option>
							<option value="manager_nm">이름</option>
							<option value="manager_nick">닉네임</option>
							<option value="cell_phone">휴대폰</option>
						</select>
						<div class="inputbox-wrap">
						<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input" placeholder="검색어 입력" style='width:400px;'>
						</div>
					</td>
					<td rowspan="3" class="search_btn_wrap">
						<div class="search_btn_box">
							<button class="tbBtn type-red">검색</button>
						</div>
					</td>
				</tr>
			</table>

		</form>

	</div><!--//search_box search_field-->

</div><!--//box-view-wrap-->

<form name="fmanagerlist" id="fmanagerlist" action="./manager_list_update.php" onsubmit="return fmanagerlist_submit(this);" method="post">
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
				
				<span class="table-tit">등록된 운영자 <span class="num"><?php echo $total_count?></span> 명</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white">버튼1</button>
					<button type="button" class="crmBtn type-white">버튼2</button>
					<button type="button" class="crmBtn type-white">버튼3</button>

				</div>

				<span class="btn-wrap-right inputbox-wrap search_field ">
					
					<select class="" style='width: 110px;'>
						
						<option value="">30개 보기</option>
						<option value="">50개 보기</option>
						<option value="">100개 보기</option>

					</select>

				</span>


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
						<th>번호</th>
						<th>아이디/닉네임</th>
						<th>이름</th>
						<th>직원여부</th>
						<th>연락처</th>
						<th>등록일</th>
						<th>최종로그인</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$mod = "./management_admin_register.php?{$qstr}&amp;w=u&amp;manager_id={$row['manager_id']}";
					?>
					<tr>
						<td class="td_chk"><input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>"></td>
						<td class="td_num">1</td>
						<td class="td_mbid2"><?php echo $row['manager_id']?>/<?php echo $row['manager_nick_nm']?></td>
						<td class=""><?php echo $row['manager_nm']?></td>
						<td class="td_confirm"><?php echo $row['employee_fl']?></td>
						<td class="td_tel"><?php echo $row['cell_phone']?></td>
						<td class="td_datetime"><?php echo substr($row['manager_reg_dt'],0,10)?></td>
						<td class="td_datetime"><?php echo substr($row['last_login_dt'],0,10)?></td>
						<td class="td_mng">
							<a href="<?php echo $mod?>" class="board_copy btn btn_02">수정</a>
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

		</div><!--//mall-orders-view-->

	</div><!--//mall-products-view-->

</div>

<div class="btn_fixed_top">
    <a href="./management_admin_register.php" id="bo_add" class="ftBtn type-red">운영자 추가</a>
</div>
</form>

<script>
function fmanagerlist_submit(f){

	

}
</script>

<?
include_once ('../admin.tail.php');