<?php
$sub_menu = '200400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

//게임 난이도
$game_level = '';
$game_level_code = '01002';
$sql = " select * from {$DM['CODE_TABLE']} where item_cd like '{$game_level_code}%' and length(item_cd)='8' ";
$r1_cnt = sql_fetch("select count(*) as cnt from {$DM['CODE_TABLE']} where item_cd like '{$game_level_code}%' and length(item_cd)='8'");
$r1 = sql_query($sql);

//필터링
$game_filtering = '';
$game_filtering_code = '01005';
$sql = "select * from {$DM['CODE_TABLE']} where item_cd like '{$game_filtering_code}%' and length(item_cd)='8'";
$r2_cnt = sql_fetch("select count(*) as cnt from {$DM['CODE_TABLE']} where item_cd like '{$game_filtering_code}%' and length(item_cd)='8'");
$r2 = sql_query($sql);

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

$sql_common = " from {$DM['BRANCH_GAEMS_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd ";

$sql_search = " where t1.branch_cd='{$branch['branch_cd']}' and t1.branch_use_fl='T' ";

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

/*필터링인원 시작*/
for($i=0;$i<$r2_cnt['cnt'];$i++){

	if ($_REQUEST['g_filter'.$i]) // 선택한 배열값이 없다면 배열을 끝까지 만들 필요가 없기 때문에 조건문을 생성해준다.

    {

        ${'g_filter'.$i} = $_REQUEST['g_filter'.$i]; 

        $g_filter[$i] = $_REQUEST['g_filter'.$i]; // 각 변수에 받아온 값 넣기

    }

}

if (sizeof($g_filter)>0) // 선택한 값이 1개라도 있는 경우
{

    for($i=0;$i<$r2_cnt['cnt'];$i++){ 

        if($g_filter[$i]){ // 선택한 체크박스를 한개씩 붙여서 나열한다.

            $opt .= "'".$g_filter[$i]."',"; // 작은 따옴표와 콤마를 붙여서 문자열을 만들어준다.

        }

    }

    $opt = substr($opt, 0, -1); // 문자열 마지막 문자(콤마) 삭제

    $sql_search .= " AND search_filtering_play_cnt in ({$opt})";

}
/*필터링인원 끝*/

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
    $sst = "t1.branch_games_reg_dt";
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

$g5['title'] = '게임 관리';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="11";
?>

<div class="box-view-wrap">

	<div class="search_box search_field">

		<form id="searchForm" name="fsearch" method="get">
		<input type="hidden" name="today" value="<?php echo G5_TIME_YMD?>">

		<table class="ncp_tbl" style='margin:20px 0 20px 0;'>
			<colgroup>
				<col style='width:120px;'>
				<col>
				<col style='width:140px;'>
			</colgroup>
			<tr>
				<th scope="row">검색어</th>
				<td>
					<select class="small" name="sfl" style='width:200px;'>
						<option value="games_nm" <?php echo ($sfl=="games_nm")?"selected":""?>>게임이름</option>
						<option value="games_cd" <?php echo ($sfl=="games_cd")?"selected":""?>>게임코드</option>
						<option value="games_hash_tag" <?php echo ($sfl=="games_hash_tag")?"selected":""?>>해시태그</option>
					</select>
					<div class="inputbox-wrap">
						<input type="text" name="stx" class="frm_input" value="<?php echo $stx?>" style="width:650px">
					</div>
				</td>
				<td rowspan="5" class="search_btn_wrap">
					<div class="search_btn_box">
						<button class="tbBtn type-red">검색</button>
						<button type="button" class="tbBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">초기화</button>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row">게임난이도</th>
				<td>

					<div class="inputbox-wrap">
						<?php for($i=0;$s1=sql_fetch_array($r1);$i++){?>
						<span class="checkbox_item marR10">
							<input type="checkbox" name="g_level<?php echo $i?>"  value="<?php echo $s1['item_cd']?>" <?php echo (${'g_level'.$i}==$s1['item_cd'])?"checked":""?> id="g_level<?php echo $i?>">
							<label for="g_level<?php echo $i?>" ><?php echo $s1['item_nm']?></label>
						</span>
						<?php }?>
					</div>

				</td>
			</tr>
			<tr>
				<th scope="row">필터링인원</th>
				<td>
					
					<div class="inputbox-wrap">
						<?php for($i=0;$s2=sql_fetch_array($r2);$i++){?>
						<span class="checkbox_item marR10">
							<input type="checkbox" name="g_filter<?php echo $i?>"  value="<?php echo $s2['item_cd']?>" <?php echo (${'g_filter'.$i}==$s2['item_cd'])?"checked":""?> id="g_filter<?php echo $i?>">
							<label for="g_filter<?php echo $i?>" ><?php echo $s2['item_nm']?></label>
						</span>
						<?php }?>
					</div>

				</td>
			</tr>
			<tr>
				<th scope="row">플레이시간</th>
				<td>
					
					<div class="inputbox-wrap">
						<?php for($i=0;$s3=sql_fetch_array($r3);$i++){?>
						<span class="checkbox_item marR10">
							<input type="checkbox" name="g_playtime<?php echo $i?>"  value="<?php echo $s3['item_cd']?>" <?php echo (${'g_playtime'.$i}==$s3['item_cd'])?"checked":""?> id="g_playtime<?php echo $i?>">
							<label for="g_playtime<?php echo $i?>" ><?php echo $s3['item_nm']?></label>
						</span>
						<?php }?>
					</div>

				</td>
			</tr>
			<tr>
				<th scope="row">장르테마</th>
				<td>
					<div class="inputbox-wrap">
						<?php for($i=0;$s4=sql_fetch_array($r4);$i++){?>
						<span class="checkbox_item marR10">
							<input type="checkbox" name="g_theme<?php echo $i?>"  value="<?php echo $s4['item_cd']?>" <?php echo (${'g_theme'.$i}==$s4['item_cd'])?"checked":""?> id="g_theme<?php echo $i?>">
							<label for="g_theme<?php echo $i?>" ><?php echo $s4['item_nm']?></label>
						</span>
						<?php }?>
					</div>
				</td>
			</tr>
		</table>

		</form>

	</div>

</div>

<form name="gameList" id="gameList" action="./board_games_list_update.php" onsubmit="return gameList_submit(this);" method="post">
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

				<span class="table-tit">등록된 게임 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록
					<!--<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>-->
					<!--
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
						<th rowspan="2">게임 이미지</th>
						<th>게임이름 (게임코드)</th>
						<!--<th>유튜브영상</th>-->
						<th colspan="5">게임정보</th>
						<!--<th rowspan="2">필터링인원</th>-->
						<th rowspan="2">문의</th>
					</tr>
					<tr>
						<th>해시태그</th>
						<!--<th>영상조회수</th>-->
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
						
						$s_mod = "";
					?>
					<tr>
						<td rowspan="2" class="td_img2"><img src="<?php echo $game_img?>" style='width:70px;'></td>
						<td class="td_addr"><?php echo $row['games_nm']?></td>
						<!--
						<td class="td_num_c3">
							<?php if($row['games_youtube']){
								echo "<a href='".$row['games_youtube']."' target='_blank'><img src='".G5_ROUTE_URL."/img/youtube_icon.png' style='width:30px;'></a>";
							}
							?>
						</td>
						-->
						<td rowspan="2" class="td_num_c4"><?php echo get_code_name($row['games_level'])?></td>
						<td rowspan="2">
							<?php 
							for($i=0;$i<count($theme);$i++){
								echo get_code_name($theme[$i]);
								if(count($theme)>$i+1){
								echo " / ";
								}
							}
							?>
						</td>
						<td rowspan="2" class="td_num_c4"><?php echo $row['recommend_player_min_cnt']?>~<?php echo $row['recommend_player_max_cnt']?>명</td>
						<td rowspan="2" class="td_num_c4"><?php echo $row['player_min_cnt']?>~<?php echo $row['player_max_cnt']?>명</td>
						<td rowspan="2" class="td_num_c4"><?php echo get_code_name($row['play_time'])?></td>
						<td rowspan="2" class="td_mng">
							<button type="button" onclick="popQna2('<?php echo $DM['QNA_CODE5']?>','<?php echo $row['games_cd']?>')" class='board_copy btn btn_02'>지점문의</button>
						</td>
					</tr>
					<tr>
						<td class="td_addr"><?php echo $row['games_hash_tag']?></td>
						<!--<td class="td_num_c3"><?php echo $row['games_youtube_play_cnt']?></td>-->
					</tr>
					<?php
					}
					if ($i == 0)
						echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
					?>
					</tbody>
					</table>
				</div>

				<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>


			</div>

		</div>

	</div>

</div>

<div class="btn_fixed_top">
    <!--<a href="./board_games_register.php?<?php echo $qstr ?>" class="btn btn_01">신규 게임 등록</a>-->
</div>	

</form>


<script>
function gameList_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 게임을 정말 삭제시키겠습니까?\n\n게임이 삭제되면 모든 지점에서 삭제가 됩니다")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../admin.tail.php');