<?php
$sub_menu = '100100';
include_once('./_common.php');

$g5['title'] = '지점 환경 설정';
include_once ('../admin.head.php');

add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

$row = sql_fetch("select t1.*, t2.* from DM_T_BRANCH as t1 join DM_T_BASE_GUIDE as t2 on t1.branch_cd=t2.branch_cd where t1.branch_cd='{$branch['branch_cd']}' and t2.guide_use_fl='T' and t2.guide_delete_fl='F' ");

?>

<form name="frmConfig" method="post" action="./basic_info_update.php" onsubmit="return frmConfigChk(this)">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<?php if($row['guide_operation_guide_movie']){?>
<input type="hidden" name="youtubeCode" id="youtubeCode" value="<?php echo get_youtube_code($row['guide_operation_guide_movie'])?>">
<?php }else{?>
<input type="hidden" name="youtubeCode" id="youtubeCode" value="<?php echo get_youtube_code($route['sc_operation_guide_movie'])?>">
<?php }?>

<div class="box-view-wrap">

	<div class="table-tit-area">

		<span class="table-tit">지점 정보 </span>

		<div class="btn-wrap-left">

			<button type="button" class="crmBtn type-white" onclick="popQna('<?php echo $DM['QNA_CODE0']?>')">지점문의</button>

		</div>

	</div><!--//table-tit-area-->

	<div class="box-cont">

		<table class="ncp_tbl">
			<colgroup>
				<col style='width:190px;'>
				<col style='width:auto'>
				<col style='width:190px;'>
				<col style='width:auto'>
			</colgroup>
			<tr>
				<th>지점 코드</th>
				<td>
					<div class="inputbox-wrap">
					<?php echo $row['branch_cd']?>
					</div>
				</td>
				<th>지점 이름</th>
				<td>
					<div class="inputbox-wrap">
					<?php echo $row['branch_nm']?>
					</div>
				</td>
			</tr>
			<tr>
				<th>지점 아이디</th>
				<td>
					<div class="inputbox-wrap">
					<?php echo $row['branch_manager_id']?>
					</div>
				</td>
				<th>지점 비밀번호</th>
				<td>
					<div class="inputbox-wrap">
					비밀번호 변경은 지점 관리자 문의를 통해 변경 바랍니다
					</div>
				</td>
			</tr>
			<tr>
				<th>지점장 이름</th>
				<td>
					<div class="inputbox-wrap">
					<?php echo $row['branch_manager_nm']?>
					</div>
				</td>
				<th>지점 연락처</th>
				<td>
					<div class="inputbox-wrap">
					<?php echo $row['branch_phone']?>
					</div>
				</td>
			</tr>
			<tr>
				<th>지점 주소</th>
				<td colspan="3">
					<div class="inputbox-wrap">
					<?php if($row['branch_addr_zip'] && $row['branch_addr_basic'] && $row['branch_addr_detail'] ){?>
					우) <?php echo $row['branch_addr_zip']?><br>
					주소 : <?php echo $row['branch_addr_basic']?> <?php echo $row['branch_addr_detail']?>
					<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>지점 소개</th>
				<td colspan="3">
					<div class="inputbox-wrap">
					<?php echo $row['branch_content']?>
					</div>
				</td>
			</tr>
			<tr>
				<th>생성됨 룸</th>
				<td colspan="3"><?php echo $row['branch_room_cnt']?></td>
			</tr>
		</table>

	</div>

</div>

<div class="box-view-wrap">

	<div class="table-tit-area">

		<span class="table-tit">지점 이용안내 정보</span>

		<div class="btn-wrap-left">

			<button type="button" class="crmBtn type-white" onclick="popQna('<?php echo $DM['QNA_CODE1']?>')">지점문의</button>

		</div>

	</div><!--//table-tit-area-->

	<div class="notice-box">
		<ul>
			<li>지점별 이용안내가 등록되어 있지 않으면 본사관리자에서 등록된 정보가 사용이 됩니다</li>
		</ul>
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
			
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th>주문하기 화면</th>
			<td>
				<div class="inputbox-wrap">
				<?php
				if($row['guide_basic_order_img']){
					$basic_order_img = G5_DATA_PATH."/branch/".$row['guide_basic_order_img'];
				}else{
					$basic_order_img = G5_DATA_PATH."/basic/".$route['sc_basic_order_img'];
				}

				if(is_file($basic_order_img) && file_exists($basic_order_img)){
					if($row['guide_basic_order_img']){
						$thumb = get_branch_thumbnail($row['guide_basic_order_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_basic_order_img'].'" class="shop_item_preview_image" >';
					}else{
						$thumb = get_basic_thumbnail($route['sc_basic_order_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_basic_order_img'].'" class="shop_item_preview_image" >';
					}
				?>
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
				<?php
				if($row['guide_file1']){
					$guide_file1 = G5_DATA_PATH."/branch/".$row['guide_file1'];
				}else{
					$guide_file1 = G5_DATA_PATH."/basic/".$route['sc_basic_guide_img'];
				}

				if(is_file($guide_file1) && file_exists($guide_file1)){
					if($row['guide_file1']){
					$thumb = get_branch_thumbnail($row['guide_file1'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_file1'].'" class="shop_item_preview_image" >';
					}else{
					$thumb = get_basic_thumbnail($route['sc_basic_guide_img'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_basic_guide_img'].'" class="shop_item_preview_image" >';
					}

				?>
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
			
		</tr>
		<tr>
			<th>wife/운영시간</th>
			<td>
				<div class="inputbox-wrap">
				<?php
				if($row['guide_file2']){
					$guide_file2 = G5_DATA_PATH."/branch/".$row['guide_file2'];
				}else{
					$guide_file2 = G5_DATA_PATH."/basic/".$route['sc_basic_wife_img'];
				}

				if(is_file($guide_file2) && file_exists($guide_file2)){
					if($row['guide_file2']){
					$thumb = get_branch_thumbnail($row['guide_file2'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_file2'].'" class="shop_item_preview_image" >';
					}else{
					$thumb = get_basic_thumbnail($route['sc_basic_wife_img'], 50, 50);
					$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_basic_wife_img'].'" class="shop_item_preview_image" >';
					}
				?>
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
				<div class="banner-preview-wrap" id="banner-preview-wrap" style='margin:50px auto; height: auto;'>

					<div class="banner-preview slick-initialized slick-slider">
		
						<div class="slide-item" style="width: 100%; display: inline-block;">

							<?php if($row['guide_operation_guide_movie'] || $route['sc_operation_guide_movie']){?>
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
		</tbody>

		</table>

	</div>
	
</div>

<div class="box-view-wrap">

	<div class="table-tit-area">

		<span class="table-tit">지점 추천게임 정보</span>

		<div class="btn-wrap-left">

			<button type="button" class="crmBtn type-white" onclick="popQna('<?php echo $DM['QNA_CODE2']?>')">지점문의</button>

		</div>

	</div><!--//table-tit-area-->

	<div class="box-cont">

		<table class="ncp_tbl">
			
			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>인원별 <br>추천게임 2인</th>
				<td>
					<div class="inputbox-wrap">
					<?php
					if($row['guide_player2_img']){
					$player2_img = G5_DATA_PATH."/branch/".$row['guide_player2_img'];
					}else{
					$player2_img = G5_DATA_PATH."/basic/".$route['sc_recommend_player2_img'];
					}

					if(is_file($player2_img) && file_exists($player2_img)){
						if($row['guide_player2_img']){
						$thumb = get_branch_thumbnail($row['guide_player2_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player2_img'].'" class="shop_item_preview_image" >';
						}else{
						$thumb = get_basic_thumbnail($route['sc_recommend_player2_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_recommend_player2_img'].'" class="shop_item_preview_image" >';
						}
					?>
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
			</tr>
			<tr>
				<th>인원별 <br>추천게임 3인</th>
				<td>
					<div class="inputbox-wrap">
					<?php
					if($row['guide_player3_img']){
					$player3_img = G5_DATA_PATH."/branch/".$row['guide_player3_img'];
					}else{
					$player3_img = G5_DATA_PATH."/basic/".$route['sc_recommend_player3_img'];
					}

					if(is_file($player3_img) && file_exists($player3_img)){
						if($row['guide_player3_img']){
						$thumb = get_branch_thumbnail($row['guide_player3_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player3_img'].'" class="shop_item_preview_image" >';
						}else{
						$thumb = get_basic_thumbnail($route['sc_recommend_player3_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_recommend_player3_img'].'" class="shop_item_preview_image" >';
						}
					?>
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
					<?php
					if($row['guide_player4_img']){
					$player4_img = G5_DATA_PATH."/branch/".$row['guide_player4_img'];
					}else{
					$player4_img = G5_DATA_PATH."/basic/".$route['sc_recommend_player4_img'];
					}
					
					if(is_file($player4_img) && file_exists($player4_img)){
						if($row['guide_player4_img']){
						$thumb = get_branch_thumbnail($row['guide_player4_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player4_img'].'" class="shop_item_preview_image" >';
						}else{
						$thumb = get_basic_thumbnail($route['sc_recommend_player4_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_recommend_player4_img'].'" class="shop_item_preview_image" >';
						}
					?>
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
				
			</tr>
			<tr>
				<th>인원별 <br>추천게임 5인</th>
				<td>
					<div class="inputbox-wrap">
					<?php
					if($row['guide_player5_img']){
					$player5_img = G5_DATA_PATH."/branch/".$row['guide_player5_img'];
					}else{
					$player5_img = G5_DATA_PATH."/basic/".$route['sc_recommend_player5_img'];
					}

					if(is_file($player5_img) && file_exists($player5_img)){
						if($row['guide_player5_img']){
						$thumb = get_branch_thumbnail($row['guide_player5_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player5_img'].'" class="shop_item_preview_image" >';
						}else{
						$thumb = get_basic_thumbnail($route['sc_recommend_player5_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_recommend_player5_img'].'" class="shop_item_preview_image" >';
						}
					?>
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
					<?php
					if($row['guide_player6_img']){
					$player6_img = G5_DATA_PATH."/branch/".$row['guide_player6_img'];
					}else{
					$player6_img = G5_DATA_PATH."/basic/".$route['sc_recommend_player6_img'];
					}

					if(is_file($player6_img) && file_exists($player6_img)){
						if($row['guide_player6_img']){
						$thumb = get_branch_thumbnail($row['guide_player6_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player6_img'].'" class="shop_item_preview_image" >';
						}else{
						$thumb = get_basic_thumbnail($route['sc_recommend_player6_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_recommend_player6_img'].'" class="shop_item_preview_image" >';
						}
					?>
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
			</tr>
			<tr>
				<th>인원별 <br>추천게임 7인이상</th>
				<td>
					<div class="inputbox-wrap">
					<?php
					if($row['guide_player7_img']){
					$player7_img = G5_DATA_PATH."/branch/".$row['guide_player7_img'];
					}else{
					$player7_img = G5_DATA_PATH."/basic/".$route['sc_recommend_player7_img'];
					}

					if(is_file($player7_img) && file_exists($player7_img)){
						if($row['guide_player7_img']){
						$thumb = get_branch_thumbnail($row['guide_player7_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/branch/'.$row['guide_player7_img'].'" class="shop_item_preview_image" >';
						}else{
						$thumb = get_basic_thumbnail($route['sc_recommend_player7_img'], 50, 50);
						$img_tag = '<img src="'.G5_DATA_URL.'/basic/'.$route['sc_recommend_player7_img'].'" class="shop_item_preview_image" >';
						}
					?>
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

</form>

<script>
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


</script>

<?
include_once ('../admin.tail.php');