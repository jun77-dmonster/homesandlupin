<?php
$sub_menu = '500100';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

$g5['title'] = '본사 추천게임 신청';
include_once ('../admin.head.php');

$sw_direct = isset($_REQUEST['sw_direct']) ? preg_replace('/[^a-z0-9_]/i', '', $_REQUEST['sw_direct']) : '';

set_session("ss_direct", $sw_direct);

if ($sw_direct=="1") {
	$tmp_cart_id = get_session('ss_cart_direct');
}
else {
    $tmp_cart_id = get_session('ss_cart_id');
}



if (get_game_cart_count($tmp_cart_id) == 0)
    alert('요청목록이 비어 있습니다.', './games_cart.php');

// 새로운 주문번호 생성
$od_id = get_uniqid();
set_session('ss_order_id', $od_id);

$s_cart_id = $tmp_cart_id;

$sql_common = " from {$DM['GAME_CART_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd ";
$sql_search = " where t1.od_id='{$s_cart_id}'  ";

if (!$sst) {
    $sst = "t1.ct_id";
    $sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select t1.*, t2.* {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="5";
?>

<form name="frmRequest" id="frmRequest" action="./games_request_form_update.php" onsubmit="return frmRequest_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="od_id" value="<?php echo $od_id?>">

<div class="box-view-wrap">
	
	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">본사 추천 게임 신청 <span class="num"><?php echo $total_count?></span> 건</span>

			</div><!--//table-tit-area-->
			
			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th>게임이미지</th>
						<th>게임이름</th>
						<th>장르</th>
						<th>난이도</th>
						<th>추천인원</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$games_dir = G5_DATA_URL.'/boardgames';
						$game_img = $games_dir."/".$row['games_img_file'];
						$theme = explode("|",$row['games_theme']);
					?>
					<tr>
						<td class="td_img3"><img src="<?php echo $game_img?>" style='width:80px;'></td>
						<td class="td_addr"><?php echo $row['games_nm']?></td>
						<td class="td_category_large">
							<?php 
							for($j=0;$j<count($theme);$j++){
								echo get_code_name($theme[$j]);
								if(count($theme)>$j+1){
								echo " / ";
								}
							}
							?>
						</td>
						<td class="td_category"><?php echo get_code_name($row['games_level'])?></td>
						<td class="td_category"><?php echo $row['recommend_player_min_cnt']?>명 ~ <?php echo $row['recommend_player_max_cnt']?>명</td>
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

<div class="box-view-wrap">
	
	<div class="box-cont">

			
		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>요청사항</th>
			<td>
				<?php echo editor_html('od_memo', get_text(html_purifier($row['od_memo']), 0)); ?>
			</td>
		</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./games_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>


</form>
<script>
function frmRequest_submit(f){

	document.getElementById("btn_submit").disabled = "disabled";

	<?php echo get_editor_js('od_memo'); ?>

	return true;

}
</script>
<?
include_once ('../admin.tail.php');