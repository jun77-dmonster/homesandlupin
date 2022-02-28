<?php
$sub_menu = '200100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";
	$row = sql_fetch("select * from {$DM['BASE_GUIDE_TABLE']} where branch_cd='{$branch_cd}'");
}

//지점코드
$branch_info = '';
if($w==""){
	$sql = " select branch_cd, branch_nm  from {$DM['BRANCH_TABLE']} where branch_cd not in ( select branch_cd from {$DM['BASE_GUIDE_TABLE']}  where guide_use_fl='T' and guide_delete_fl='F' )";
}else{
	$sql = " select branch_cd, branch_nm  from {$DM['BRANCH_TABLE']} where branch_withdrawal_fl='F' ";
}

$r1 = sql_query($sql);

for ($i=0; $c1=sql_fetch_array($r1); $i++)
{
    $branch_info .= "<option value=\"{$c1['branch_cd']}\">$nbsp{$c1['branch_nm']}</option>\n";
}




$g5['title'] = '지점별 이용안내 '.$title;
include_once ('../admin.head.php');
?>

<form name="frmGuide" method="post" action="./base_guide_register_update.php" onsubmit="return frmGuideChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">

	<div class="view-title">
		지점 기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:150px;'>
			<col>
			<col style='width:150px;'>
			<col>
		</colgroup>
		<tr>
			<th>지점선택</th>
			<td>
				<div class="inputbox-wrap">
				<select name="branch_cd" style="width:250px;">
					<option value="">지점선택</option>
					<?php echo conv_selected_option2($branch_info, $row['branch_cd']); ?>
				<select>
				</div>
			</td>
			<th></th>
			<td></td>
		</tr>
		<tr>
			<th>주문하기 화면</th>
			<td colspan="3">
				<div class="inputbox-wrap">
				<input type="file" name="basic_order_img" class="frm_input" style="width:250px;">
				<?php
				$basic_order_img = G5_DATA_PATH."/branch/".$row['guide_basic_order_img'];

				if(is_file($basic_order_img) && file_exists($basic_order_img)){
					$thumb = get_branch_thumbnail($row['guide_basic_order_img'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_basic_order_img'].'" class="shop_item_preview_image" >';
				?>
				<label for="basic_order_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
				<input type="checkbox" name="basic_order_img_del" id="basic_order_img_del" value="1">
				<span class="sit_wimg_limg0"><?php echo $thumb; ?></span>
				<div id="limg0" class="banner_or_img">
                    <?php echo $img_tag; ?>
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
                <script>
                $('<button type="button" id="it_limg0_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg0');
                </script>
				<?php }?>
				</div>
			</td>
		</tr>
		<tr>
			<th>이용안내</th>
			<td>
				<div class="inputbox-wrap">
				<input type="file" name="guide_file1" class="frm_input"style="width:250px;">
				<?php
				$guide_file1 = G5_DATA_PATH."/branch/".$row['guide_file1'];

				if(is_file($guide_file1) && file_exists($guide_file1)){
					$thumb = get_branch_thumbnail($row['guide_file1'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_file1'].'" class="shop_item_preview_image" >';
				?>
				<label for="guide_file1_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
				<input type="checkbox" name="guide_file1_del" id="guide_file1_del" value="1">
				<span class="sit_wimg_limg1"><?php echo $thumb; ?></span>
				<div id="limg1" class="banner_or_img">
                    <?php echo $img_tag; ?>
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
                <script>
                $('<button type="button" id="it_limg1_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg1');
                </script>
				<?php }?>
				</div>
			</td>
			<th>wife/운영시간</th>
			<td>
				<div class="inputbox-wrap">
				<input type="file" name="guide_file2" class="frm_input"style="width:250px;">
				<?php
				$guide_file2 = G5_DATA_PATH."/branch/".$row['guide_file2'];

				if(is_file($guide_file2) && file_exists($guide_file2)){
					$thumb = get_branch_thumbnail($row['guide_file2'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_file2'].'" class="shop_item_preview_image" >';
				?>
				<label for="guide_file2_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
				<input type="checkbox" name="guide_file2_del" id="guide_file2_del" value="1">
				<span class="sit_wimg_limg2"><?php echo $thumb; ?></span>
				<div id="limg2" class="banner_or_img">
                    <?php echo $img_tag; ?>
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
                <script>
                $('<button type="button" id="it_limg2_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg2');
                </script>
				<?php }?>
				</div>
			</td>
		</tr>
		<tr>
			<th>이용안내 <br>기본 영상</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="branch_operation_guide_movie" class="frm_input" value="<?php echo $row['guide_operation_guide_movie']?>" style="width:400px;">
				</div>
			</td>
			<th>유튜브미리보기</th>
			<td>
				<div class="banner-preview-wrap" id="banner-preview-wrap" style='margin:50px auto; height: auto;'>

					<div class="banner-preview slick-initialized slick-slider">
		
						<div class="slide-item" style="width: 100%; display: inline-block;">

							<?php if($row['guide_operation_guide_movie']){?>
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
		</table>

	</div>

	<div class="view-title">
		지점별 추천게임 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
			
			<colgroup>
				<col style='width:200px;'>
				<col>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>인원별 <br>추천게임 2인</th>
				<td>
					<div class="inputbox-wrap">
					<input type="file" name="player2_img" class="frm_input">
					<?php
					$player2_img = G5_DATA_PATH."/branch/".$row['guide_player2_img'];

					if(is_file($player2_img) && file_exists($player2_img)){
						$thumb = get_branch_thumbnail($row['guide_player2_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player2_img'].'" class="shop_item_preview_image" >';
					?>
					<label for="player2_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
					<input type="checkbox" name="player2_img_del" id="player2_img_del" value="1">
					<span class="sit_wimg_limg3"><?php echo $thumb; ?></span>
					<div id="limg3" class="banner_or_img">
						<?php echo $img_tag; ?>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg3_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg3');
					</script>
					<?php }?>
					</div>
				</td>
				<th>인원별 <br>추천게임 3인</th>
				<td>
					<div class="inputbox-wrap">
					<input type="file" name="player3_img" class="frm_input">
					<?php
					$player3_img = G5_DATA_PATH."/branch/".$row['guide_player3_img'];

					if(is_file($player3_img) && file_exists($player3_img)){
						$thumb = get_branch_thumbnail($row['guide_player3_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player3_img'].'" class="shop_item_preview_image" >';
					?>
					<label for="player3_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
					<input type="checkbox" name="player3_img_del" id="player3_img_del" value="1">
					<span class="sit_wimg_limg4"><?php echo $thumb; ?></span>
					<div id="limg4" class="banner_or_img">
						<?php echo $img_tag; ?>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg4_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg4');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 <br>추천게임 4인</th>
				<td>
					<div class="inputbox-wrap">
					<input type="file" name="player4_img" class="frm_input">
					<?php
					$player4_img = G5_DATA_PATH."/branch/".$row['guide_player4_img'];

					if(is_file($player4_img) && file_exists($player4_img)){
						$thumb = get_branch_thumbnail($row['guide_player4_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player4_img'].'" class="shop_item_preview_image" >';
					?>
					<label for="player4_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
					<input type="checkbox" name="player4_img_del" id="player4_img_del" value="1">
					<span class="sit_wimg_limg5"><?php echo $thumb; ?></span>
					<div id="limg5" class="banner_or_img">
						<?php echo $img_tag; ?>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg5_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg5');
					</script>
					<?php }?>
					</div>
				</td>
				<th>인원별 <br>추천게임 5인</th>
				<td>
					<div class="inputbox-wrap">
					<input type="file" name="player5_img" class="frm_input">
					<?php
					$player5_img = G5_DATA_PATH."/branch/".$row['guide_player5_img'];

					if(is_file($player5_img) && file_exists($player5_img)){
						$thumb = get_branch_thumbnail($row['guide_player5_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player5_img'].'" class="shop_item_preview_image" >';
					?>
					<label for="player5_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
					<input type="checkbox" name="player5_img_del" id="player5_img_del" value="1">
					<span class="sit_wimg_limg6"><?php echo $thumb; ?></span>
					<div id="limg6" class="banner_or_img">
						<?php echo $img_tag; ?>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg6_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg6');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>인원별 <br>추천게임 6인</th>
				<td>
					<div class="inputbox-wrap">
					<input type="file" name="player6_img" class="frm_input">
					<?php
					$player6_img = G5_DATA_PATH."/branch/".$row['guide_player6_img'];

					if(is_file($player6_img) && file_exists($player6_img)){
						$thumb = get_branch_thumbnail($row['guide_player6_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player6_img'].'" class="shop_item_preview_image" >';
					?>
					<label for="player6_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
					<input type="checkbox" name="player6_img_del" id="player6_img_del" value="1">
					<span class="sit_wimg_limg7"><?php echo $thumb; ?></span>
					<div id="limg7" class="banner_or_img">
						<?php echo $img_tag; ?>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg7_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg7');
					</script>
					<?php }?>
					</div>
				</td>
				<th>인원별 <br>추천게임 7인이상</th>
				<td>
					<div class="inputbox-wrap">
					<input type="file" name="player7_img" class="frm_input">
					<?php
					$player7_img = G5_DATA_PATH."/branch/".$row['guide_player7_img'];

					if(is_file($player7_img) && file_exists($player7_img)){
						$thumb = get_branch_thumbnail($row['guide_player7_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player7_img'].'" class="shop_item_preview_image" >';
					?>
					<label for="player7_img_del"><span class="sound_only">대표이미지 </span>파일삭제</label>
					<input type="checkbox" name="player7_img_del" id="player7_img_del" value="1">
					<span class="sit_wimg_limg8"><?php echo $thumb; ?></span>
					<div id="limg8" class="banner_or_img">
						<?php echo $img_tag; ?>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg8_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg8');
					</script>
					<?php }?>
					</div>
				</td>
			</tr>
			
			</tbody>

		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./base_guide_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
var f = document.frmGuide;

<?php if ($w == 'u') { ?>
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
        if(width > 450) {
            var img_width = 450;
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
<?php } ?>

$(function() {

	if($("#youtubeCode").val()){
		youtebeData($("#youtubeCode").val());

		preView = $('<img>',{
						'src' : youtubeMqImage
		});

		$(preView).appendTo('#preViewYoutube');

		$('#preViewYoutubeTitle').text(youtubeTitle);


		$("#preViewYoutube").click(function(e){ 
				var url = "<?php echo $row['guide_operation_guide_movie']?>";  
				window.open(url, "_blank");
		});
	}


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

function frmGuideChk(f){

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}
</script>
<?
include_once ('../admin.tail.php');