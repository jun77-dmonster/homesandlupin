<?php
$sub_menu = '200610';
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


$sql_common = " from {$DM['BOARD_GAMES_TABLE']} ";

$sql_search = " where games_delete_fl='F' ";

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

$g5['title'] = '보드게임 목록';
include_once ('../../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="8";
?>

<div class="box-view-wrap">

	<div class="search_box search_field">

		<!--
		<div class="products_summary search_tab">

			<table class="ncp_tbl">
				<tbody>
				<tr>
					<td class="" style='width:25%'><a href="">전체 <?php echo $total_count?>건</a></td>
					<td class="" style='width:25%'><a href="">판매가능 <?php echo $availabel_count?>건</a></td>
					<td class="" style='width:25%'><a href="">판매중지 <?php echo $stop_count?>건</a></td>
					<td class="" style='width:25%'><a href="">판매금지 <?php echo $prohibition_count?>건</a></td>
				</tr>
				</tbody>
			</table>

		</div>
		-->

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
						<button type="submit" class="tbBtn type-red">검색</button>
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
			<!--
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
			-->
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

					<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록</button>
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택삭제</button>
					<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택수정</button>
					<!--<button type="submit" name="act_button" value="선택다운로드" onclick="document.pressed=this.value"  class="crmBtn type-white">선택엑셀다운로드</button>
					<button type="button" name="act_button" onclick="location.href='./board_games_excel.php'" class="crmBtn type-white">전체엑셀다운로드</a></button>
					-->

				</div>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th class="td_chk">
							<label for="chkall" class="sound_only">게시판 전체</label>
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th>게임코드</th>
						<th>게임이름</th>
						<th>장르</th>
						<th>유튜브영상</th>
						<th>책갈피</th>
						<th>해시태그</th>
						<th>지점노출</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$theme = explode("|",$row['games_theme']);
						$s_mod = "<a href='./board_games_register.php?w=u&amp;games_cd={$row['games_cd']}' class='board_copy btn btn_02'>정보수정</a>";
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="games_cd[<?php echo $i ?>]" value="<?php echo $row['games_cd'] ?>" id="games_cd<?php echo $i ?>">
							<input type="hidden" name="games_nm[<?php echo $i ?>]" value="<?php echo $row['games_nm'] ?>" id="games_nm<?php echo $i ?>">
						</td>
						<td class="td_auth"><?php echo $row['games_cd']?></td>
						<td class="td_category_large"><?php echo $row['games_nm']?></td>
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
						<td class="td_auth">
							<?php if($row['games_youtube']){
								echo "<a href='".$row['games_youtube']."' target='_blank'><img src='".G5_ROUTE_URL."/img/youtube_icon.png' style='width:30px;'></a>";
							}
							?>
						</td>
						<td class="td_auth">
							<?php if($row['games_youtube']){?>
							<button type="button" class="crmBtn type-white" onclick="displayYoutube('<?php echo $row['games_cd']?>')">책갈피</button>
							<?php }else{?>
							<button type="button" class="crmBtn type-white" onclick="NoYoutube()">책갈피</button>
							<?php }?>
						</td>
						<td><?php echo $row['games_hash_tag']?></td>
						<td class="td_auth">
							<select name="branch_display_fl[<?php echo $i?>]">
								<option value="T" <?php echo ($row['branch_display_fl']=="T")?"selected":""?>>지점노출</option>
								<option value="F" <?php echo ($row['branch_display_fl']=="F")?"selected":""?>>지점미노출</option>
							</select>
						</td>
						<td class="td_mng">
							<?php echo $s_mod?>
							<button type="button" class='board_copy btn btn_03' onclick="branchCopy('<?php echo $row['games_cd']?>')">게임복사</button>
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

			<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

		</div>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./board_games_register.php?<?php echo $qstr ?>" class="btn btn_01">신규 게임 등록</a>
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

function displayYoutube(games_cd){
	
	var _width	= '1400';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_youtube_bookmark_list.php?games_cd="+games_cd;

	var new_win = window.open(href, "pop_youtube_bookmark_list", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}

function NoYoutube(){
	alert("유튜브 영상을 먼저 등록해 주세요");
}

function branchCopy(games_cd){

	var _width	= '600';
    var _height = '600';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_branch_game_copy.php?games_cd="+games_cd;

	var new_win = window.open(href, "pop_branchg_copy", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>
<?
include_once ('../../admin.tail.php');