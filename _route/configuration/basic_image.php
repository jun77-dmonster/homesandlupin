<?php
$sub_menu = '100110';
include_once('./_common.php');

$g5['title'] = '기본 운영 관리';
include_once ('../admin.head.php');
?>

<form name="frmConfig" method="post" action="./basic_image_update.php" onsubmit="return frmConfigChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="youtubeCode" id="youtubeCode" value="<?php echo get_youtube_code($route['sc_operation_guide_movie'])?>">

<div class="box-view-wrap">

	<div class="view-title">
		본사 기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">

			<colgroup>
				<col style='width:200px;'>
				<col style='width:500px'>
				<col style='width:auto'>
			</colgroup>
			<tr>
				<th>FAQ 상단 텍스트</th>
				<td colspan="2">
					<textarea name="sc_faq_text" class="frm_input"><?php echo $route['sc_faq_text']?></textarea>
				</td>
			</tr>
			<tr>
				<th>이용안내 기본 영상</th>
				<td>
					<div class="inputbox-wrap">
					<input type="text" name="sc_operation_guide_movie" class="frm_input" style='width:450px;' value="<?php echo $route['sc_operation_guide_movie']?>">
					</div>
				</td>
				<td>
					<div class="banner-preview-wrap" id="banner-preview-wrap" style='margin:50px auto; height: auto;'>

						<div class="banner-preview slick-initialized slick-slider">

							<div class="slide-item" style="width: 100%; display: inline-block;">

								<div id="preViewYoutube"></div>

								<span id="preViewYoutubeTitle" style='font-size:16px; display:inline-block; padding:10px; font-weight:bold;'></span>

							</div>

						</div>

					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 추천게임 2인</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="player2_file" class="frm_input" id="imgView1" style='width:450px;'>
					<?
					$player2_file = G5_DATA_PATH.'/basic/'.$route['sc_recommend_player2_img'];
					
					if(is_file($player2_file) && file_exists($player2_file)){
						$thumb = get_basic_thumbnail($route['sc_recommend_player2_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_recommend_player2_img']}>";
					?>
					<label for="player2_file_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="player2_file_del" id="player2_file_del" value="1">
					<span class="sit_wimg_limg1"><?php echo $thumb; ?>

					</span>
					<div id="limg1" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_recommend_player2_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg1_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg1');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 추천게임 3인</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="player3_file" class="frm_input" id="imgView2" style='width:450px;'>
					<?
					$player3_file = G5_DATA_PATH.'/basic/'.$route['sc_recommend_player3_img'];
					
					if(is_file($player3_file) && file_exists($player3_file)){
						$thumb = get_basic_thumbnail($route['sc_recommend_player3_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_recommend_player3_img']}>";
					?>
					<label for="player3_file_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="player3_file_del" id="player3_file_del" value="1">
					<span class="sit_wimg_limg2"><?php echo $thumb; ?>

					</span>
					<div id="limg2" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_recommend_player3_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg2_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg2');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 추천게임 4인</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="player4_file" class="frm_input" id="imgView3" style='width:450px;'>
					<?
					$player4_file = G5_DATA_PATH.'/basic/'.$route['sc_recommend_player4_img'];
					
					if(is_file($player4_file) && file_exists($player4_file)){
						$thumb = get_basic_thumbnail($route['sc_recommend_player4_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_recommend_player4_img']}>";
					?>
					<label for="player4_file_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="player4_file_del" id="player4_file_del" value="1">
					<span class="sit_wimg_limg3"><?php echo $thumb; ?>

					</span>
					<div id="limg3" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_recommend_player4_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg3_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg3');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 추천게임 5인</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="player5_file" class="frm_input" id="imgView4" style='width:450px;'>
					<?
					$player5_file = G5_DATA_PATH.'/basic/'.$route['sc_recommend_player5_img'];
					
					if(is_file($player5_file) && file_exists($player5_file)){
						$thumb = get_basic_thumbnail($route['sc_recommend_player5_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_recommend_player5_img']}>";
					?>
					<label for="player5_file_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="player5_file_del" id="player5_file_del" value="1">
					<span class="sit_wimg_limg4"><?php echo $thumb; ?>

					</span>
					<div id="limg4" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_recommend_player5_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg4_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg4');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 추천게임 6인</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="player6_file" class="frm_input" id="imgView5" style='width:450px;'>
					<?
					$player6_file = G5_DATA_PATH.'/basic/'.$route['sc_recommend_player6_img'];
					
					if(is_file($player6_file) && file_exists($player6_file)){
						$thumb = get_basic_thumbnail($route['sc_recommend_player6_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_recommend_player6_img']}>";
					?>
					<label for="player6_file_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="player6_file_del" id="player6_file_del" value="1">
					<span class="sit_wimg_limg5"><?php echo $thumb; ?>

					</span>
					<div id="limg5" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_recommend_player6_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg5_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg5');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 추천게임 7인</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="player7_file" class="frm_input" id="imgView6" style='width:450px;'>
					<?
					$player7_file = G5_DATA_PATH.'/basic/'.$route['sc_recommend_player7_img'];
					
					if(is_file($player7_file) && file_exists($player7_file)){
						$thumb = get_basic_thumbnail($route['sc_recommend_player7_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_recommend_player7_img']}>";
					?>
					<label for="player7_file_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="player7_file_del" id="player7_file_del" value="1">
					<span class="sit_wimg_limg6"><?php echo $thumb; ?>

					</span>
					<div id="limg6" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_recommend_player7_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg6_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg6');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>주문하기 화면</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="order_basic" class="frm_input" id="imgView7" style='width:450px;'>
					<?
					$order_basic = G5_DATA_PATH.'/basic/'.$route['sc_basic_order_img'];
					
					if(is_file($order_basic) && file_exists($order_basic)){
						$thumb = get_basic_thumbnail($route['sc_basic_order_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_basic_order_img']}>";
					?>
					<label for="order_basic_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="order_basic_del" id="order_basic_del" value="1">
					<span class="sit_wimg_limg7"><?php echo $thumb; ?>

					</span>
					<div id="limg7" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_basic_order_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg7_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg7');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>이용안내 화면</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="guide_basic" class="frm_input" id="imgView8" style='width:450px;'>
					<?
					$guide_basic = G5_DATA_PATH.'/basic/'.$route['sc_basic_guide_img'];
					
					if(is_file($guide_basic) && file_exists($order_basic)){
						$thumb = get_basic_thumbnail($route['sc_basic_guide_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_basic_guide_img']}>";
					?>
					<label for="order_basic_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="guide_basic_del" id="order_basic_del" value="1">
					<span class="sit_wimg_limg8"><?php echo $thumb; ?>

					</span>
					<div id="limg8" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_basic_order_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg8_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg8');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>WIFE/운영시간 화면</th>
				<td colspan="2">
					<div class="inputbox-wrap">
					<input type="file" name="wife_basic" class="frm_input" id="imgView9" style='width:450px;'>
					<?
					$wife_basic = G5_DATA_PATH.'/basic/'.$route['sc_basic_wife_img'];
					
					if(is_file($wife_basic) && file_exists($wife_basic)){
						$thumb = get_basic_thumbnail($route['sc_basic_wife_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/basic/{$route['sc_basic_wife_img']}>";
					?>
					<label for="wife_basic_del"><span class="sound_only">이미지 </span>파일삭제</label>
					<input type="checkbox" name="wife_basic_del" id="wife_basic_del" value="1">
					<span class="sit_wimg_limg9"><?php echo $thumb; ?>

					</span>
					<div id="limg9" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/basic/<?php echo $route['sc_basic_wife_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg9_view" class="btn_frmline sit_wimg_view">이미지 확인</button>').appendTo('.sit_wimg_limg9');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			
		</table>

	</div>


</div>

<div class="btn_fixed_top">
    <input type="submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
$(function() {

	youtebeData($("#youtubeCode").val());

	preView = $('<img>',{
					'src' : youtubeMqImage
	});

	$(preView).appendTo('#preViewYoutube');

	$('#preViewYoutubeTitle').text(youtubeTitle);


	$("#preViewYoutube").click(function(e){ 
            var url = "<?php echo $route['sc_operation_guide_movie']?>";  
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

function frmConfigChk(f){

	return true;

}

var f = document.frmConfig;
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
include_once ('../admin.tail.php');