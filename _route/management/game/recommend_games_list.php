<?php
$sub_menu = '200640';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['RECOMMEND_GAME_TABLE']} as t1 join  {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd";

$sql_search = " where (1) ";

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
    $sst = "t1.display_order";
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

$g5['title'] = '추천게임 목록';
include_once ('../../admin.head.php');

$sql = " select t1.uid, t1.branch_gubun, t1.games_cd, t1.display_order, t1.main_display_fl, t2.games_nm, t2.games_img_file, t2.games_youtube, t2.staff_call, t2.recommend_player_cnt, t2.player_cnt, t2.play_time, t2.explain_time, t2.search_filtering_play_cnt, t2.games_level, t2.games_theme, t2.games_search_cnt, t2.branch_register_cnt   {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="10";

?>	

<form name="recommendGameList" id="recommendGameList" action="./recommend_games_list_update.php" onsubmit="return recommendGameList_submit(this);" method="post">
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

				<span class="table-tit">등록된 추천 게임 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>
					<!--<button type="button" class="crmBtn type-white" onclick="location.href='./branch_register.php'">신규 지점 등록</button>-->

				</div>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th scope="col" rowspan="2">
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th rowspan="2">게임 이미지</th>
						<th rowspan="2">게임이름 (게임코드)</th>
						<th colspan="5">게임정보</th>
						<th rowspan="2">필터링인원</th>
						<th rowspan="2">메인출력</th>
						<th rowspan="2">출력순서</th>
					</tr>
					<tr>
						<th>게임난이도</th>
						<th>장르테마</th>
						<th>추천인원</th>
						<th>플레이인원</th>
						<th>플레이시간</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$games_dir = G5_DATA_URL.'/boardgames';
						$game_img = $games_dir."/".$row['games_img_file'];						
						//$game_img = get_games_image($row['games_cd'], 100, 100);
						$theme = explode("|",$row['games_theme']);
						$filter = explode("|",$row['search_filtering_play_cnt']);
						
						$s_mod = "<a href='./board_games_register.php?w=u&amp;games_cd={$row['games_cd']}' class='board_copy btn btn_02'>수정</a>";
						
						$recommend  = sql_fetch("select count(*) as cnt from {$DM['RECOMMEND_GAME_TABLE']} where games_cd='{$row['games_cd']}'");
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid<?php echo $i ?>">
						</td>
						<td class="td_img2"><img src="<?php echo $game_img?>" style='width:100px;'></td>
						<td class="td_addr"><?php echo $row['games_nm']?></td>
						<td class="td_num_c4"><?php echo get_code_name($row['games_level'])?></td>
						<td>
							<?php 
							for($j=0;$j<count($theme);$j++){
								echo get_code_name($theme[$j]);
								if(count($theme)>$j+1){
								echo " / ";
								}
							}
							?>
						</td>
						<td class="td_num_c4"><?php echo $row['recommend_player_cnt']?></td>
						<td class="td_num_c4"><?php echo $row['player_cnt']?></td>
						<td class="td_num_c4"><?php echo get_code_name($row['play_time'])?></td>
						<td class="td_category_large2">
							<?php 
							for($k=0;$k<count($filter);$k++){
								echo get_code_name($filter[$k]);
								if(count($filter)>$k+1){
								echo " / ";
								}
							}
							?>
						</td>
						<td>
							<select name="main_display_fl[<?php echo $i?>]">
								<option value="T" <?php echo ($row['main_display_fl']=="T")?"selected":""?>>출력</option>
								<option value="F" <?php echo ($row['main_display_fl']=="F")?"selected":""?>>미출력</option>
							</select>
						</td>
						<td>
							<input type="text" name="display_order[<?php echo $i?>]" class="frm_input" style='width:50px;' value="<?php echo $row['display_order']?>">
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

</form>
<script>
function recommendGameList_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 게임을 추천게임에서 정말 삭제시키겠습니까?")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../../admin.tail.php');