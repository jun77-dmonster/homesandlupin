<?php
$sub_menu = '300200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '주문 상세 보기';
include_once ('../admin.head.php');

$row = sql_fetch("select * from {$DM['ORDER_TABLE']} where od_id='{$od_id}'");

$c1 = sql_fetch("select * from {$DM['CART_TABLE']} where od_id='{$od_id}'");


?>

<div class="box-view-wrap">

	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">
					
					주문지점 <span class="blue"><?php echo get_branch_name($c1['branch_cd'])?></span> | 
					룸번호   <span class="blue"><?php echo get_room_info($c1['room_cd'])?></span> 번 |
					주문일시 <span class="blue"><?php echo $row['od_time']?></span> | 
					주문총액 <span class="num"><?php echo number_format($row['od_cart_price'])?></span> 원 
					
				</span>

			</div>

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<thead>
					<tr>
						<th>상품명</th>
						<th>옵션명</th>
						<th>수량</th>
						<th>주문금액</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="td_addr"></td>
						<td class="td_odrnum"></td>
						<td class="td_cnt"></td>
						<td class="td_paybybig td_price"></td>
					</tr>
					</tbody>
					</table>

				</div>

			</div>

		</div>

	</div>


</div>

<?
include_once ('../admin.tail.php');