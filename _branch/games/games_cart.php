<?php
$sub_menu = '500100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$tmp_cart_id = get_session('ss_cart_id');

if(!$tmp_cart_id){

	alert("요청 중인 게임이 없습니다","./games_list.php");
	
}

$sql_common = " from {$DM['GAME_CART_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd  ";

$sql_search = " where t1.od_id='{$tmp_cart_id}' ";

if (!$sst) {
    $sst = "t1.ct_id";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$g5['title'] = '게임 일괄 요청 목록';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="7";
?>

<form name="cartList" id="cartList" action="./games_cart_update.php" onsubmit="return cartList_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="od_id" value="<?php echo $tmp_cart_id?>">

<div class="box-view-wrap">
	
	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">요청 중인 게임 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='./games_request_form.php'">본사요청하기</button>
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>
					<button type="submit" name="act_button" value="비우기" onclick="document.pressed=this.value"  class="crmBtn type-white">비우기</button>
					

				</div>

			</div><!--//table-tit-area-->

			
			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th>
							<label for="chkall" class="sound_only">게시판 전체</label>
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
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
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>" <?php echo ($r2['cnt']==0)?"":"disabled"?>>
							<input type="hidden" name="games_cd[<?php echo $i ?>]" value="<?php echo $row['games_cd'] ?>" id="games_cd<?php echo $i ?>">
							<input type="hidden" name="ct_id[<?php echo $i ?>]" value="<?php echo $row['ct_id'] ?>" id="ct_id<?php echo $i ?>">
						</td>
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

</form>
<script>
function cartList_submit(f){

	if(document.pressed != "비우기") {
		if (!is_checked("chk[]")) {
			alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
			return false;
		}
	}

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 게임을 정말 삭제시키겠습니까?")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../admin.tail.php');