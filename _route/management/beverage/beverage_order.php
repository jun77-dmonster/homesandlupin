<?php
$sub_menu = '200720';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '주문 테스트';
include_once ('../../admin.head.php');

set_session('ss_cart_direct', '');

set_dmcart_id();

$tmp_cart_id = get_session('ss_cart_direct');

$branch_cd = "B4362";

$beverage_cd = "BEVERAGE5448";

$beverage = sql_fetch("select t1.*, t2.sold_out_fl from {$DM['BEVERAGE_TABLE']} as t1 join {$DM['BRANCH_BEVERAGE_TABLE']} as t2 on t1.beverage_cd=t2.beverage_cd where t2.branch_cd='{$branch_cd}' and t2.sold_out_fl='F'");

$is_orderable = true;

$option_item = $supply_item = '';


$optin_item = get_beverage_options($beverage_cd, $beverage['beverage_option_subject'], '');
?>

<form name="fitem" method="post" action="./beverage_order_update.php" onsubmit="return fitem_submit(this);">
<input type="hidden" name="beverage_cd[]" value="<?php echo $beverage_cd; ?>">
<input type="hidden" name="sw_direct">
<div class="box-view-wrap">

	<div class="view-title">
		주문테스트
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>주문번호</th>
			<td>
				<input type="text" name="od_id" class="frm_input" value="<?php echo $tmp_cart_id?>">
			</td>
		</tr>
		<tr>
			<th>지점번호</th>
			<td>
				<input type="text" name="branch_cd" class="frm_input" value="<?php echo $branch_cd?>">
			</td>
		</tr>
		<tr>
			<th>룸번호</th>
			<td>
				<select name="room_cd">
					<option value="B4362ROOM9453">1번룸</option>
					<option value="B4362ROOM9591">2번룸</option>
					<option value="B4362ROOM4323">3번룸</option>
					<option value="B4362ROOM0285">4번룸</option>
					<option value="B4362ROOM8286">5번룸</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>식음료코드</th>
			<td>
				<input type="text" class="frm_input" name="beverage_cd" value="<?php echo $beverage_cd?>">
			</td>
		</tr>
		<tr>
			<th>가격</th>
			<td>
				<input type="text" class="frm_input" name="ct_price" value="<?php echo $beverage['beverage_price']?>">
			</td>
		</tr>
		<tr>
			<th>상품명</th>
			<td>
				<input type="text" class="frm_input" name="ct_option" value="<?php echo $beverage['beverage_kor_nm']?>">
			</td>
		</tr>
		<tr>
			<th>수량</th>
			<td>
				<input type="text" class="frm_input" name="ct_qty" value="1">
			</td>
		</tr>
		<tr>
			<th>선택옵션1</th>
			<td>
				<?php echo $optin_item ?>
			</td>
		</tr>
		<tr>
			<th>선택된 옵션</th>
			<td>
				<input type="text" name="beverage_op_type[<?php echo $beverage_cd; ?>][]" value="0">
				<input type="text" name="beverage_op_id[<?php echo $beverage_cd; ?>][]" value="">
				<input type="text" name="beverage_value[<?php echo $beverage_cd; ?>][]" value="<?php echo $it['it_name']; ?>">
			</td>
		</tr>
		<!--
		<tr>
			<th>상품선택옵션명</th>
			<td><input type="text" class="frm_input" name="io_id" value=""></td>
		</tr>
		<tr>
			<th>상품선택옵션구분</th>
			<td><input type="text" class="frm_input" name="io_type" value="0"></td>
		</tr>
		<tr>
			<th>옵션금액</th>
			<td>
				<input type="text" class="frm_input" name="io_price" value="0">
			</td>
		</tr>
		-->
		</table>


	</div>
	

</div>
</form>

<script>
function fitem_submit(f){

	f.action = "./beverage_order_update.php";
    f.target = "";

	f.sw_direct.value = 0;

}
</script>
<?
include_once ('../../admin.tail.php');
