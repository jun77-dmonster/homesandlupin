<?php
$sub_menu = '300100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '주문 상세 현황';
include_once ('../admin.head.php');

$c1 = sql_fetch("select * from {$DM['CART_TABLE']} where od_id='{$od_id}'");


//------------------------------------------------------------------------------
// 주문서 정보
//------------------------------------------------------------------------------
$sql = " select * from {$DM['ORDER_TABLE']} where od_id = '$od_id' ";
$od = sql_fetch($sql);
if (! (isset($od['od_id']) && $od['od_id'])) {
    alert("해당 주문번호로 주문서가 존재하지 않습니다.");
}

// 상품목록
$sql = " select t1.beverage_cd,
                t1.ct_price,
				t2.beverage_kor_nm
		  from {$DM['CART_TABLE']} as t1 join {$DM['BEVERAGE_TABLE']} as t2 on t1.beverage_cd=t2.beverage_cd
          where t1.od_id = '{$od['od_id']}'
          group by t1.beverage_cd
          order by t1.ct_id ";

$result = sql_query($sql);
?>

<div class="box-view-wrap">

	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">
					
					주문지점 <span class="blue"><?php echo get_branch_name($c1['branch_cd'])?></span> | 
					룸번호   <span class="blue"><?php echo get_room_info($c1['room_cd'])?></span> 번 |
					주문일시 <span class="blue"><?php echo $od['od_time']?></span> | 
					주문총액 <span class="num"><?php echo number_format($od['od_cart_price'])?></span> 원 
					
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
						<th>판매가</th>
						<th>소계</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$chk_cnt = 0;
					for($i=0; $row=sql_fetch_array($result); $i++) {
						// 상품의 옵션정보
						$sql = " select ct_id, beverage_cd, ct_price, ct_qty, ct_option, ct_status, io_type, io_price
									from {$DM['CART_TABLE']}
									where od_id = '{$od['od_id']}'
									  and beverage_cd = '{$row['beverage_cd']}'
									order by io_type asc, ct_id asc ";
						$res = sql_query($sql);
						$rowspan = sql_num_rows($res);

						// 합계금액 계산
						$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
										SUM(ct_qty) as qty
									from {$DM['CART_TABLE']}
									where beverage_cd = '{$row['beverage_cd']}'
									  and od_id = '{$od['od_id']}' ";
						$sum = sql_fetch($sql);

						for($k=0; $opt=sql_fetch_array($res); $k++) {
						if($opt['io_type'])
							$opt_price = $opt['io_price'];
						else
							$opt_price = $opt['ct_price'] + $opt['io_price'];

						// 소계
						$ct_price['stotal'] = $opt_price * $opt['ct_qty'];
					?>
					<tr>
						<?php if($k == 0) { ?>
						<td rowspan="<?php echo $rowspan; ?>" class="td_left">
							<?php echo stripslashes($row['beverage_kor_nm']); ?>
						</td>
						<?php } ?>
						<td class="td_left"><?php echo get_text($opt['ct_option']); ?></td>
						<td class="td_num"><?php echo $opt['ct_qty']; ?></td>
						<td class="td_payby td_price"><?php echo number_format($opt_price); ?> 원</td>
						<td class="td_payby td_price"><?php echo number_format($ct_price['stotal']); ?> 원</td>
					</tr>
					<?php
							$chk_cnt++;
						}
					?>
					<?php
					}
					?>
					</tbody>
					</table>

				</div>

			</div>

		</div>

	</div>


</div>

<div class="btn_fixed_top">
    <a href="./order_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
</div>	

<?
include_once ('../admin.tail.php');