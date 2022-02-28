<?php
$sub_menu = '500200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '게임 요청 상세보기';
include_once ('../admin.head.php');

$result = sql_query("select * from {$DM['GAME_CART_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd where t1.od_id='{$od_id}'");

$r1 = sql_fetch("select * from {$DM['GAME_REQUEST_TABLE']} where od_id='{$od_id}'");
?>
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="box-view-wrap">

	<div class="view-title">
		본사 추천게임 요청 목록
	</div>

	<div class="content_item_bx">

		<div class="tbl_head01 tbl_wrap marT30">

			<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<thead>
			<tr>
				<th>게임이미지</th>
				<th>게임이름</th>
				<th>장르</th>
				<th>난이도</th>
				<th>추천인원</th>
				<th>요청현황</th>
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
				<td class="td_mng">
					<?php echo $row['ct_status']?>
				</td>
			</tr>
			<?php
			}
			if ($i == 0)
				echo "<tr><td colspan='5' class=\"empty_table\">자료가 없습니다.</td></tr>";
			?>
			</tbody>
			</table>

		</div>

	</div>

</div>

<div class="box-view-wrap">

	<div class="view-title">
		지점 요청 사항
	</div>
	
	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>요청사항</th>
			<td>
				<div id="bo_v_con"><?php echo get_view_thumbnail($r1['od_memo']); ?></div>
			</td>
		</tr>
		<tr>
			<th>신청현황</th>
			<td><?php echo $r1['od_status']?></td>
		</tr>
		<?php if($r1['od_admin_memo'] || $r1['od_status']!="접수"){?>
		<tr>
			<th>관리자답변</th>
			<td><?php echo $r1['od_admin_memo']?></td>
		</tr>
		<?php }?>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./games_request_list.php" class=" btn btn_02">목록</a>
</div>

<script>
$(function() {
    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>

<?
include_once ('../admin.tail.php');