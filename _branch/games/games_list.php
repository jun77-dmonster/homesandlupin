<?php
$sub_menu = '500100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

//게임 난이도
$game_level = '';
$game_level_code = '01002';
$sql = " select * from {$DM['CODE_TABLE']} where item_cd like '{$game_level_code}%' and length(item_cd)='8' ";
$r1_cnt = sql_fetch("select count(*) as cnt from {$DM['CODE_TABLE']} where item_cd like '{$game_level_code}%' and length(item_cd)='8'");
$r1 = sql_query($sql);

//플레이시간
$play_time = '';
$play_time_code = '01003';
$sql = "select * from {$DM['CODE_TABLE']} where item_cd like '{$play_time_code}%' and length(item_cd)='8'";
$r3_cnt = sql_fetch("select count(*) as cnt from {$DM['CODE_TABLE']} where item_cd like '{$play_time_code}%' and length(item_cd)='8'");
$r3 = sql_query($sql);

//장르테마
$games_theme = '';
$games_theme_code = '01001';
$sql = "select * from {$DM['CODE_TABLE']} where item_cd like '{$games_theme_code}%' and length(item_cd)='8'";
$r4 = sql_query($sql);
$r4_cnt = sql_fetch("select count(*) as cnt from {$DM['CODE_TABLE']} where item_cd like '{$games_theme_code}%' and length(item_cd)='8'");

$sql_common = " from {$DM['BOARD_GAMES_TABLE']} ";

$sql_search = " where games_delete_fl='F' and branch_display_fl='T' and games_cd not in (select games_cd from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch['branch_cd']}' ) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'games_cd' :
        case 'games_nm' :
        case 'games_hash_tag' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

/*게임난이도 시작*/
for($i=0;$i<$r1_cnt['cnt'];$i++){

	if ($_REQUEST['g_level'.$i]) // 선택한 배열값이 없다면 배열을 끝까지 만들 필요가 없기 때문에 조건문을 생성해준다.

    {

        ${'g_level'.$i} = $_REQUEST['g_level'.$i]; 

        $g_level[$i] = $_REQUEST['g_level'.$i]; // 각 변수에 받아온 값 넣기

    }

}

if (sizeof($g_level)>0) // 선택한 값이 1개라도 있는 경우
{

    for($i=0;$i<$r1_cnt['cnt'];$i++){ 

        if($g_level[$i]){ // 선택한 체크박스를 한개씩 붙여서 나열한다.

            $opt .= "'".$g_level[$i]."',"; // 작은 따옴표와 콤마를 붙여서 문자열을 만들어준다.

        }

    }

    $opt = substr($opt, 0, -1); // 문자열 마지막 문자(콤마) 삭제

    $sql_search .= " AND games_level in ({$opt})";

}
/*게임난이도 끝*/

/*플레이타임 시작*/
for($i=0;$i<$r3_cnt['cnt'];$i++){

	if ($_REQUEST['g_playtime'.$i]) // 선택한 배열값이 없다면 배열을 끝까지 만들 필요가 없기 때문에 조건문을 생성해준다.

    {

        ${'g_playtime'.$i} = $_REQUEST['g_playtime'.$i]; 

        $g_playtime[$i] = $_REQUEST['g_playtime'.$i]; // 각 변수에 받아온 값 넣기

    }

}

if (sizeof($g_playtime)>0) // 선택한 값이 1개라도 있는 경우
{

    for($i=0;$i<$r3_cnt['cnt'];$i++){ 

        if($g_playtime[$i]){ // 선택한 체크박스를 한개씩 붙여서 나열한다.

            $opt .= "'".$g_playtime[$i]."',"; // 작은 따옴표와 콤마를 붙여서 문자열을 만들어준다.

        }

    }

    $opt = substr($opt, 0, -1); // 문자열 마지막 문자(콤마) 삭제

    $sql_search .= " AND play_time in ({$opt})";

}
/*플레이타임 끝*/


/*장르테마 시작*/
for($i=0;$i<$r4_cnt['cnt'];$i++){

	if ($_REQUEST['g_theme'.$i]) // 선택한 배열값이 없다면 배열을 끝까지 만들 필요가 없기 때문에 조건문을 생성해준다.

    {

        ${'g_theme'.$i} = $_REQUEST['g_theme'.$i]; 

        $g_theme[$i] = $_REQUEST['g_theme'.$i]; // 각 변수에 받아온 값 넣기

    }

}

if (sizeof($g_theme)>0) // 선택한 값이 1개라도 있는 경우
{
	$where = array();

	for($i=0;$i<$r4_cnt['cnt'];$i++){ 

        
		if($g_theme[$i]){ // 선택한 체크박스를 한개씩 붙여서 나열한다.

            
			$where[] =  " games_theme like '%{$g_theme[$i]}%'";
			
			//$opt .= "".$g_theme[$i]."|"; // 작은 따옴표와 콤마를 붙여서 문자열을 만들어준다.

        }

    }

	if ($where) {
		$sql_search2 = implode(' or ', $where);
	}

	

    //$opt = substr($opt, 0, -1); // 문자열 마지막 문자(콤마) 삭제

    $sql_search .= " AND ($sql_search2)";

}
/*장르테마 끝*/

if (!$sst) {
    $sst = "games_reg_dt";
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

$g5['title'] = '본사 추천 게임';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="7";
?>

<div class="box-view-wrap">

	<div class="search_box search_field">

	<form id="searchForm" name="fsearch" method="get">
	<input type="hidden" name="today" value="<?php echo G5_TIME_YMD?>">

		

	</form>

	</div>

</div>

<form name="gameList" id="gameList" action="./games_list_update.php" onsubmit="return gameList_submit(this);" method="post">
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

				<span class="table-tit">추천 게임 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록
					<?php if(get_session('ss_cart_id')){?>
					<button type="button" class="crmBtn type-white" onclick="location.href='./games_cart.php'">요청목록
					<?php }?>
					<button type="submit" name="act_button" value="선택담기" onclick="document.pressed=this.value"  class="crmBtn type-white">선택담기</button>
					<!--
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>
					<!--<button type="button" class="crmBtn type-white" onclick="location.href='./branch_register.php'">신규 지점 등록</button>-->

				</div>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

					<div class="local_desc01 local_desc">
					
						 <p style='font-size:12px; font-weight:bold;'>
							추천 게임 목록에 출력되는 게임은 지점에 등록된 게임을 제외한 게임들이 출력이 됩니다.
							<br><br>
							<strong>바로 요청</strong>은 하나의 게임 / <strong>게임 담기</strong>는 여러 게임을 선택하여 본사에 요청을 하면 본사에서 확인 후 지점에 요청하신 게임을 추가 등록해 드립니다.
							<br><br>
							요청 중인 게임은 목록에는 나타나지만 신청은 할 수 없습니다.
						</p>

					</div><!--local_desc01 local_desc-->

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
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$games_dir = G5_DATA_URL.'/boardgames';
						$game_img = $games_dir."/".$row['games_img_file'];
						$theme = explode("|",$row['games_theme']);

						$r2 = sql_fetch("select count(*) as cnt from {$DM['GAME_CART_TABLE']} where games_cd='{$row['games_cd']}' and ct_status in('신청','접수')");
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>" <?php echo ($r2['cnt']==0)?"":"disabled"?>>
							<input type="hidden" name="games_cd[<?php echo $i ?>]" value="<?php echo $row['games_cd'] ?>" id="games_cd<?php echo $i ?>">
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
						<td class="td_mng">
							<?php if($r2['cnt']==0){?>
							<button type="button" class='board_copy btn btn_03' onclick="gameDirect('<?php echo $row['games_cd']?>')">바로요청</button>
							<?php }else{?>
							<button type="button" class='board_copy btn btn_01'>요청중</button>
							<?php }?>
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
function gameList_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    return true;
	
}

function gameDirect(games_cd){

	location.href="./games_direct_update.php?games_cd="+games_cd;

}
</script>
<?
include_once ('../admin.tail.php');