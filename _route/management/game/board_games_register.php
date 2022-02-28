<?php
$sub_menu = '200610';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";

	$row = sql_fetch("select * from {$DM['BOARD_GAMES_TABLE']} where games_cd='{$games_cd}'");
}

$g5['title'] = '보드게임 '.$title;
include_once ('../../admin.head.php');

//게임 난이도
$game_level = '';
$game_level_code = '01002';
$sql = " select * from {$DM['CODE_TABLE']} where item_cd like '{$game_level_code}%' and length(item_cd)='8' ";
$r1 = sql_query($sql);

for ($i=0; $c1=sql_fetch_array($r1); $i++)
{
    $game_level .= "<option value=\"{$c1['item_cd']}\">$nbsp{$c1['item_nm']}</option>\n";
}

//장르테마
$game_theme = '';
$game_theme_code = '01001';

$game_theme = sql_query("select * from {$DM['CODE_TABLE']} where item_cd like '{$game_theme_code}%' and length(item_cd)='8'");

//필터링인원
$game_filtering = '';
$game_filtering_code = '01005';

$r3 = sql_query("select * from {$DM['CODE_TABLE']} where item_cd like '{$game_filtering_code}%' and length(item_cd)='8'");
for ($i=0; $c1=sql_fetch_array($r3); $i++)
{
    $game_filtering .= "<option value=\"{$c1['item_cd']}\">$nbsp{$c1['item_nm']}</option>\n";
}

//플레이타임
$play_time = '';
$play_time_code = '01003';

$r1 = sql_query("select * from {$DM['CODE_TABLE']} where item_cd like '{$play_time_code}%' and length(item_cd)='8'");

for ($i=0; $c1=sql_fetch_array($r1); $i++)
{
    $play_time .= "<option value=\"{$c1['item_cd']}\">$nbsp{$c1['item_nm']}</option>\n";
}

//설명시간
$explain_time = '';
$explain_time_code = '01004';

$r2 = sql_query("select * from {$DM['CODE_TABLE']} where item_cd like '{$explain_time_code}%' and length(item_cd)='8'");

for ($i=0; $c1=sql_fetch_array($r2); $i++)
{
    $explain_time .= "<option value=\"{$c1['item_cd']}\">$nbsp{$c1['item_nm']}</option>\n";
}


//장르테마
$games_theme = '';
$games_theme_code = '01001';
$sql = "select * from {$DM['CODE_TABLE']} where item_cd like '{$games_theme_code}%' and length(item_cd)='8'";
$r4 = sql_query($sql);
$r4_cnt = sql_fetch("select count(*) as cnt from {$DM['CODE_TABLE']} where item_cd like '{$games_theme_code}%' and length(item_cd)='8'");
?>
<!--
<script src="<?php echo G5_JS_URL?>/jquery.sumoselect.min.js"></script>
<link href="<?php echo G5_ROUTE_URL?>/css/sumoselect.min.css" rel="stylesheet" />

<script type="text/javascript">
  $(document).ready(function () {			
	
	
	$('#games_theme').SumoSelect({ okCancelInMulti: true, placeholder: '게임 장르/테마를 선택해주세요 (중복가능)' });
	$('#search_filtering_play_cnt').SumoSelect({ okCancelInMulti: true, placeholder: '필터링인원 선택해주세요 (중복 가능)' });
	
	var t1 = $('#gametheme').val();
	t1 = t1.split("|");
	
	for(var i = 0; i<t1.length; i++){
		$('#games_theme')[0].sumo.selectItem(t1[i]);	
	}

	var t2 = $('#gamefiltering').val();
	t2 = t2.split("|");
	
	for(var i = 0; i<t2.length; i++){
		$('#search_filtering_play_cnt')[0].sumo.selectItem(t2[i]);	
	}


   });
</script>
-->

<form name="frmBoardGame" method="post" action="./board_games_register_update.php" onsubmit="return frmBoardGameChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<input type="hidden" name="gametheme" id="gametheme" value="<?php echo $row['games_theme']?>" data-value="<?php echo $row['games_theme']?>">
<!--<input type="hidden" name="gamefiltering" id="gamefiltering" value="<?php echo $row['search_filtering_play_cnt']?>">-->
<input type="hidden" name="youtubeCode" id="youtubeCode" value="<?php echo get_youtube_code($row['games_youtube'])?>">

<div class="box-view-wrap">

	<div class="view-title">
		게임 기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>게임코드</th>
			<td>
				<div class="inputbox-wrap">
				<?php if($w==""){?>
				<input type="text" name="games_cd" value="<?php echo get_game_uniqid()?>" class="frm_input" style="width:350px; text-align:left;">
				<?php }else{?>
				<input type="text" name="games_cd" value="<?php echo $row['games_cd']?>" class="frm_input" style="width:300px; text-align:left;" readonly>
				<?php }?>
				</div>
			</td>
			<th>게임이름</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="games_nm" value="<?php echo $row['games_nm']?>" class="frm_input required" required style="width:300px; text-align:left;">
				</div>
			</td>
		</tr>
		
		<tr>
			<th>게임난이도</th>
			<td colspan="3">
				<div class="inputbox-wrap">
					<select name="games_level" style='width:300px;'>
					<?php echo conv_selected_option2($game_level, $row['games_level']); ?>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<th>장르/테마</th>
			<td colspan="3">
				<div class="inputbox-wrap">
					<?php for($j=0;$s4=sql_fetch_array($game_theme);$j++){?>
					<span class="checkbox_item marR05">
						<input type="checkbox" name="g_theme[<?php echo $j?>]" data-value="<?php echo $s4['item_cd']?>"  class="game_theme" value="<?php echo $s4['item_cd']?>">
						<label for="g_theme<?php echo $j?>" ><?php echo $s4['item_nm']?></label>
					</span>
					<?php }?>
					<!--
					<select name="games_theme[]" id="games_theme" class="required" required multiple="multiple" style='width:300px;'>
					<?php for($i=0;$m1=sql_fetch_array($game_theme);$i++){?>
					<option value="<?php echo $m1['item_cd']?>"><?php echo $m1['item_nm']?></option>
					<?php }?>
					</select>
					-->
				</div>
			</td>
		</tr>
		<tr>
			<th>추천인원</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="recommend_player_min_cnt" class="frm_input required" required value="<?php echo $row['recommend_player_min_cnt']?>" style='width:100px;' placeholder="최소인원">
				~
				<input type="text" name="recommend_player_max_cnt" class="frm_input required" required value="<?php echo $row['recommend_player_max_cnt']?>" style='width:100px;' placeholder="최대인원">
				</div>
			</td>
			<th>플레이인원</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="player_min_cnt" class="frm_input required" required value="<?php echo $row['player_min_cnt']?>" style='width:100px;' placeholder="최소인원">
				~
				<input type="text" name="player_max_cnt" class="frm_input required" required value="<?php echo $row['player_max_cnt']?>" style='width:100px;' placeholder="최대인원">
				</div>
			</td>
			<!--
			<th>필터링인원</th>
			<td>
				<div class="inputbox-wrap">
					<select name="search_filtering_play_cnt" class="required" required id="search_filtering_play_cnt" style='width:300px;'>
					<option value="">필터링인원 선택</option>
					<?php echo conv_selected_option2($game_filtering, $row['search_filtering_play_cnt']); ?>
					</select>
				</div>
			</td>
			-->
		</tr>
		<tr>
			<th>플레이시간</th>
			<td colspan="3">
				<div class="inputbox-wrap">
					<select name="play_time" id="play_time" class="required" required style='width:300px;'>
					<option value="">플레이시간 선택</option>
					<?php echo conv_selected_option2($play_time, $row['play_time']); ?>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<th>직원호출</th>
			<td>
				<div class="inputbox-wrap">
				<select name="staff_call" style='width:300px;'>
					<option value="T" <?php echo ($row['staff_call']=="T")?"selected":""?>>직원설명요청</option>
					<option value="F" <?php echo ($row['staff_call']=="F")?"selected":""?>>설명불가(공부중입니다)</option>
				</select>
				</div>
			</td>
			<th>설명시간</th>
			<td>
				<div class="inputbox-wrap">
					<select name="explain_time" id="explain_time" class="required" required style='width:300px;'>
					<option value="">설명시간 선택</option>
					<?php echo conv_selected_option2($explain_time, $row['explain_time']); ?>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<th>게임유형</th>
			<td colspan="3">
				<span class="radio_wrap">
					<input type="checkbox" name="best_icon" id="best_icon" value="T" <?php echo ($row['best_icon']=="T")?"checked":""?>>
					<label for="best_icon">베스트게임 선정</label>
					<input type="checkbox" name="new_icon" id="new_icon" value="T" <?php echo ($row['new_icon']=="T")?"checked":""?>>
					<label for="new_icon">New 게임 선정</label>
				</span>
			</td>
		</tr>
		<tr>
			<th>해시태그</th>
			<td colspan="3">
				<input type="text" name="games_hash_tag" value="<?php echo $row['games_hash_tag']?>" class="frm_input frm_input_full" style="text-align:left;" placeholder="#태그,#태그2,#태그3 최대 9개까지 가능하면 태그와 태그사이 , 를 입력해주세요">
			</td>
		</tr>
		</table>

	</div>

	<div class="view-title">
		게임 이미지
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
			<col style='width:auto;'>
		</colgroup>
		<tr>
			<th>게임이미지</th>
			<td>
				<div class="inputbox-wrap">
				<input type="file" name="game_file" id="game_file" class="frm_input" style="width:500px;">
				<?php if($w==="u" && $row['games_img_file']){?>
				<label for="game_file_del"><span class="sound_only">게임이미지 </span>파일삭제</label>
				<input type="checkbox" name="game_file_del" id="game_file_del" value="1">
				<?php }?>
				</div>
			</td>
			<td>
				<div class="banner-preview-wrap" id="banner-preview-wrap" style='margin:50px auto; height: auto;'>

					<div class="banner-preview slick-initialized slick-slider">

						<div class="slide-item" style="width: 100%; display: inline-block;">
							<?
							$game_file = G5_DATA_PATH."/boardgames/".$row['games_img_file'];	
							?>
							<div class="img_banner_wrap">
							<?php if($w==="u" && $row['games_img_file'] ){?>
							<img src="<?php echo G5_DATA_URL?>/boardgames/<?php echo $row['games_img_file']?>" id="banner_img">
							<?php }else{?>
							<img src="<?php echo G5_ROUTE_URL?>/img/img_slide_sample01.png" id="banner_img">
							<?php }?>
							</div>

						</div>

					</div>

				</div>
			</td>
		</tr>
		</table>

	</div>

	<div class="view-title">
		게임 요약 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
			<col style='width:auto;'>
		</colgroup>
		<tr>
			<th>설명영상_YOUTUBE</th>
			<td>	
				<div class="inputbox-wrap">
				<input type="text" name="games_youtube" class="frm_input" value="<?php echo $row['games_youtube']?>" style="width:500px">
				</div>
			</td>
			<td>
				<div class="banner-preview-wrap" id="banner-preview-wrap" style='margin:50px auto; height: auto;'>

					<div class="banner-preview slick-initialized slick-slider">

						<div class="slide-item" style="width:100%; display: inline-block;">

							<!--
							<div class="img_banner_wrap">

							<img src="<?php echo G5_ROUTE_URL?>/img/img_slide_sample01.png" id="banner_img">

							</div>
							-->
							<?php if($row['games_youtube']){?>
							<div id="preViewYoutube"></div>

							<span id="preViewYoutubeTitle" style='font-size:16px; display:inline-block; padding:10px; font-weight:bold;'></span>
							<?php }else{?>
							<img src="<?php echo G5_ROUTE_URL?>/img/img_slide_sample01.png" id="banner_img">
							<?php }?>

						</div>

					</div>

				</div>
			</td>
		</tr>
		<tr>
			<th>게임설명(텍스트)</th>
			<td colspan="2">
				<textarea name="games_content" class="frm_input frm_input_full" style='height:100px;'><?php echo $row['games_content']?></textarea>
			</td>
		</tr>
		<tr>
			<th>게임요약(이미지)</th>
			<td colspan="2">
				<?php echo editor_html('games_summaray', get_text(html_purifier($row['games_summaray']), 0)); ?>
			</td>
		</tr>
		</table>

	</div>
	
</div>

<div class="btn_fixed_top">
    <a href="./board_games_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>
<script>
function frmBoardGameChk(f){


	if($(".game_theme:checked").length>2){

		alert("게임 장르/테마는 최대 2개까지만 선택이 가능합니다");
		return false;

	}
	
	document.getElementById("btn_submit").disabled = "disabled";

	<?php echo get_editor_js('games_summaray'); ?>

	return true;

}

$(document).ready(function () {

	check_value = $('#gametheme').attr('data-value');

	gametheme2 = check_value.split('|');

	// 콤마로 구분된 텍스트 값을 배열로 변환시킴
	for (j=0; j < gametheme2.length; j++) {

		for (i=0 ; i < $('.game_theme').length ; i++) {
			
			if($('.game_theme')[i].value == gametheme2[j]) {
			
				$('.game_theme')[i].setAttribute('checked', 'checked');

			}

		}

	}

});

$(function() {
	$("#game_file").on('change', function(){
		readURL(this);
	});

	$('#banner_img').width("500px");
});

function readURL(input) {
	if (input.files && input.files[0]) {
	var reader = new FileReader();

	reader.onload = function (e) {
			$('#banner_img').attr('src', e.target.result);
			$('#banner_img').width("400px");
		}

	  reader.readAsDataURL(input.files[0]);
	}
}

$(function() {

	youtebeData($("#youtubeCode").val());

	preView = $('<img>',{
					'src' : youtubeMqImage
	});

	$(preView).appendTo('#preViewYoutube');

	$('#preViewYoutubeTitle').text(youtubeTitle);


	$("#preViewYoutube").click(function(e){ 
            var url = "<?php echo $row['games_youtube']?>";  
            window.open(url, "_blank");
	});


});

function youtebeData() {
    youtubeXhr = new XMLHttpRequest();
    youtubeXhr.open('GET', 'https://noembed.com/embed?url=https://www.youtube.com/watch?v=' + arguments[0], 0);
    youtubeXhr.send();
    youtubeTitle = youtubeXhr.responseText.split('"title":"')[1].split('"')[0];
    youtubeHqImage = youtubeXhr.responseText.split('"thumbnail_url":"')[1].split('"')[0];
    youtubeMqImage = youtubeHqImage.replace('hq', 'mq');
    youtubeSdImage = youtubeHqImage.replace('hq', 'sd');
}




</script>
<?
include_once ('../../admin.tail.php');