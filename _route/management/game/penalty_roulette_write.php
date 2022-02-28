<?php
$sub_menu = '200620';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){

	$title = " 등록";

}else{

	$title = " 수정";

	$row = sql_fetch("select * from {$DM['GAMES_PENALTY_TABLE']} where uid='{$uid}'");

}

$g5['title'] = '벌칙 룰렛 '.$title;
include_once ('../../admin.head.php');

$b1 = sql_query("select * from {$DM['BRANCH_TABLE']} where (1) and branch_withdrawal_fl='F'");

for ($i=0; $c1=sql_fetch_array($b1); $i++)
{
    $branch_code .= "<option value=\"{$c1['branch_cd']}\">$nbsp{$c1['branch_nm']}</option>\n";
}
?>

<form name="frmPenalty" method="post" action="./penalty_roulette_write_update.php" onsubmit="return frmPenaltyChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid?>">

<div class="box-view-wrap">

	<div class="view-title">
		룰렛 기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>구분</th>
			<td>
				<select name="gubun_apply" style='width:300px;'>
				<option value="B0000" <?php echo ($row['gubun_apply']=="B0000")?"selected":""?>>전체지점</option>
				<?php echo conv_selected_option2($branch_code, $row['gubun_apply']); ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" name="penalty_title" class="frm_input frm_input_full" value="<?php echo $row['penalty_title']?>">
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td>
				<?php echo editor_html('penalty_content', get_text(html_purifier($row['penalty_content']), 0)); ?>
			</td>
		</tr>
		<tr>
			<th>벌칙 이미지</th>
			<td>
				<input type="file" name="penalty_img" class="frm_input">
				<?php
					$penalty_img = G5_DATA_PATH.'/penalty/'.$row['penalty_img'];	

					if(is_file($penalty_img) && file_exists($penalty_img)){
						$thumb = get_penalty_thumbnail($row['penalty_img'], 100, 100);
						$img_tag = "<img src='".G5_DATA_URL."/penalty/{$row['youtube_img_thumb']}>";
				?>
				
				<label for="youtube_img_thumb_del"><span class="sound_only">썸네일 이미지 </span>파일삭제</label>
				<input type="checkbox" name="penalty_img_del" id="penalty_img_del" value="1">
				
					<span class="sit_wimg_limg1"><?php echo $thumb; ?></span>
					<div id="limg1" class="banner_or_img">
						<img src='<?php echo G5_DATA_URL?>/penalty/<?php echo $row['penalty_img']?>'>
						<button type="button" class="sit_wimg_close">닫기</button>
					</div>
					<script>
					$('<button type="button" id="it_limg1_view" class="btn_frmline sit_wimg_view marL05">이미지 확인</button>').appendTo('.sit_wimg_limg1');
					</script>
				<?php }?>
			</td>
		</tr>
		<tr>
			<th>메인 출력</th>
			<td>
				<select name="penalty_main_display_fl">
					<option value="T" <?php echo ($row['penalty_main_display_fl']=="T" || $w=="")?"selected":""?>>출력</option>
					<option value="F" <?php echo ($row['penalty_main_display_fl']=="F")?"selected":""?>>미출력</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>출력 순서</th>
			<td>
				<input type="text" name="penalty_order" class="frm_input" size="4" value="<?php echo ($row['penalty_order'])?$row['penalty_order']:"0"?>">
			</td>
		</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./penalty_roulette_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
function frmPenaltyChk(f){

	<?php echo get_editor_js('penalty_content'); ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}

var f = document.frmPenalty;
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
include_once ('../../admin.tail.php');