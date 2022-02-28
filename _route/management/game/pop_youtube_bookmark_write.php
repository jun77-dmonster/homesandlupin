<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$game_info = get_game_info($games_cd);

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";

	$row = sql_fetch("select * from {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} where uid='{$uid}'");
}

$g5['title'] = "게임 설명영상 책갈피".$title;

include_once ('../../pop.admin.head.php');

$youtube_url = $game_info['games_youtube'];
$regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
preg_match($regExp, $youtube_url, $matches);
$youtube_id = $matches[7];

?>

<form name="frmYoutube" method="post" action="./pop_youtube_bookmark_write_update.php" onsubmit="return frmYoutubeChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid?>">

<div class="box-view-wrap"  style='width:780px;'>

	<div class="view-title">
		<?php echo $game_info['games_nm']?> >  책갈피 기본 정보
	</div>

	<div style="text-align:Center; padding:20px;">
	<iframe width="800" height="400" src="https://www.youtube.com/embed/<?php echo $youtube_id?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>게임명</th>
			<td>
				<?php echo $game_info['games_nm']?>
				<input type="hidden" name="games_cd" value="<?php echo $games_cd?>">
			</td>
		</tr>
		<tr>
			<th>썸네일제목</th>
			<td>
				<input type="text" name="youtube_thumb_title" class="frm_input frm_input_full" value="<?php echo $row['youtube_thumb_title']?>" maxlength="30">
			</td>
		</tr>
		<!--
		<tr>
			<th>썸네일이미지</th>
			<td>
				<input type="file" name="youtube_img_thumb" class="frm_input">
				<?php
					$youtube_img_thumb = G5_DATA_PATH.'/youtubemark/'.$row['youtube_img_thumb'];	

					if(is_file($youtube_img_thumb) && file_exists($youtube_img_thumb)){
						$thumb = get_youtube_thumbnail($row['youtube_img_thumb'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/youtubemark/{$row['youtube_img_thumb']}>";
				?>
				
				<label for="youtube_img_thumb_del"><span class="sound_only">썸네일 이미지 </span>파일삭제</label>
				<input type="checkbox" name="youtube_img_thumb_del" id="youtube_img_thumb_del" value="1">
				
					<span class="sit_wimg_limg1"><?php echo $thumb; ?></span>
					<div id="limg1" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/youtubemark/<?php echo $row['youtube_img_thumb']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg1_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg1');
					</script>
				<?php }?>
			</td>
		</tr>
		-->
		<tr>
			<th>영상위치 분</th>
			<td>
				<input type="text" name="youtube_paly_min" class="frm_input" value="<?php echo $row['youtube_paly_min']?>" style='width:100px;' maxlength="2"> 예) 해당 책갈피의 분을 숫자로 입력
			</td>
		</tr>
		<tr>
			<th>영상위치 초</th>
			<td>
				<input type="text" name="youtube_paly_sec" class="frm_input" value="<?php echo $row['youtube_paly_sec']?>" style='width:100px;' maxlength="2"> 예) 해당 책갈피의 초를 숫자로 입력
			</td>
		</tr>
		<tr>
			<th>게임세팅 책갈피 적용</th>
			<td>
				<select name="youtube_setting_fl">
					<option value="T" <?php echo ($row['youtube_setting_fl']=="T")?"selected":""?>>적용</option>
					<option value="F" <?php echo ($row['youtube_setting_fl']=="F" || $w=="")?"selected":""?>>미적용</option>
				</select>
				게임 영상이 다 끝나고 게임 세팅 바로가기에 사용될 책갈피를 선택하는 기능입니다
			</td>
		</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./pop_youtube_bookmark_list.php?<?php echo $qstr ?>&amp;games_cd=<?php echo $games_cd?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
function frmYoutubeChk(f){

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}

var f = document.frmYoutube;
$(".banner_or_img").addClass("sit_wimg");
$(function() {
    $(".sit_wimg_view").bind("click", function() {
        var sit_wimg_id = $(this).attr("id").split("_");
        var $img_display = $("#"+sit_wimg_id[1]);

        $img_display.toggle();

        if($img_display.is(":visible")) {
            $(this).text($(this).text().replace("확인", "닫기"));
        } else {
            $(this).text($(this).text().replace("닫기", "확인"));
        }

        var $img = $("#"+sit_wimg_id[1]).children("img");
        var width = $img.width();
        var height = $img.height();
        if(width > 700) {
            var img_width = 700;
            var img_height = Math.round((img_width * height) / width);

            $img.width(img_width).height(img_height);
        }
    });
    $(".sit_wimg_close").bind("click", function() {
        var $img_display = $(this).parents(".banner_or_img");
        var id = $img_display.attr("id");
        $img_display.toggle();
        var $button = $("#it_"+id+"_view");
        $button.text($button.text().replace("닫기", "확인"));
    });
});
</script>

<?
include_once ('../../pop.admin.tail.php');