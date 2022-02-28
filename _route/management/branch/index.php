<?php
$sub_menu = '200500';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '지점 메인 ({$})';
include_once ('../../admin.head.php');

$sql_common = "from {$DM['BRANCH_TABLE']} ";

$sql_search = " where branch_withdrawal_fl='F' ";

if (!$sst) {
    $sst = "branch_reg_dt";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 9;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);
?>

<div class="cont-box-wrap">
	
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
	
	//지점문의	
	$branch_qna = sql_fetch("select count(*) as cnt from {$DM['QNA_TABLE']} where branch_cd='{$row['branch_cd']}' and date_format(reg_dt,'%Y-%m-%d')='".G5_TIME_YMD."' and delete_fl='F'  ");

	//고객의 소리	
	$branch_voice = sql_fetch("select count(*) as cnt from {$DM['VOICE_CUSTOMER_TABLE']} where branch_cd='{$row['branch_cd']}' and date_format(customer_reg_dt,'%Y-%m-%d')='".G5_TIME_YMD."' and customer_delete_fl='F'  ");

	//직원호출
	$staff_call = sql_fetch("select count(*) as cnt from {$DM['GAMES_REQUEST_DESCRIPTION_TABLE']} where branch_cd='{$row['branch_cd']}' and date_format(request_reg_dt,'%Y-%m-%d')='".G5_TIME_YMD."' ");

	//주문
	$order = sql_fetch("select count(*) as cnt from {$DM['ORDER_TABLE']} where branch_cd='{$row['branch_cd']}' and date_format(od_receipt_time,'%Y-%m-%d')='".G5_TIME_YMD."' ");

	//게임
	$game = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$row['branch_cd']}' and branch_use_fl='T'  ");

	//식음료
	$beverage = sql_fetch("select count(*) as cnt from {$DM['BRANCH_BEVERAGE_TABLE']} where branch_cd='{$row['branch_cd']}' and delete_fl='F' ");

	?>
	<div class="cont-box">
		
		<div class="cont-box-top">
			<p class="tit"><?php echo $row['branch_nm']?> (지점코드 : <?php echo $row['branch_cd']?> )</p>
		</div>
		<div class="cont-box-bottom">
			
			<div class="box type02">
			
				<ul style="width:350px; margin:35px auto;">
					<li>
						<p class="tit">지점문의</p>
						<p class="cnt"><?php echo $branch_qna['cnt']?> 건</p>
					</li>
					<li>
						<p class="tit">고객의소리</p>
						<p class="cnt"><?php echo $branch_voice['cnt']?> 건</p>
					</li>
					<li>
						<p class="tit">직원호출</p>
						<p class="cnt"><?php echo $staff_call['cnt']?> 건</p>
					</li>
					<li>
						<p class="tit">주문</p>
						<p class="cnt"><?php echo $order['cnt']?> 건</p>
					</li>
					<li>
						<p class="tit">등록된 게임</p>
						<p class="cnt"><?php echo $game['cnt']?> 건</p>
					</li>
					<li>
						<p class="tit">등록된 식음료</p>
						<p class="cnt"><?php echo $beverage ['cnt']?> 건</p>
					</li>
				</ul>

			</div>
			

		</div>

	</div><!--//cont-box-->
	<?php }?>

</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?
include_once ('../../admin.tail.php');