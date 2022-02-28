<?php
$sub_menu = '400200';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '지점 문의 답변달기';
include_once ('../admin.head.php');

$bd_id='qna';

$row = sql_fetch("select * from {$DM['QNA_TABLE']} where uid='{$uid}'");

$view = get_file2($bd_id,$uid);
 
$v_img_count = count($view[0]['file']);

?>
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="box-view-wrap">

	<div class="box-cont">

		<table class="ncp_tbl">

			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>문의지점</th>
				<td><?php echo get_branch_name($row['branch_cd'])?></td>
			</tr>
			<tr>
				<th>문의구분</th>
				<td><?php echo ($row['qna_gubun']=="board_game")?"보드게임":"식음료"?></td>
			</tr>
			<?php if($row['goods_cd']){?>
			<tr>
				<th>문의상품</th>
				<td>
					<?php 
						if($row['qna_gubun']==$DM['QNA_CODE5']){
							$goods = sql_fetch("select * from {$DM['BOARD_GAMES_TABLE']} where games_cd='{$row['goods_cd']}'");
							$goods_dir = G5_DATA_URL.'/boardgames';
							$goods_img = $goods_dir."/".$goods['games_img_file'];
							$goods_title = $goods['games_nm'];
					?>
						<?php if($goods['games_img_file']){?>
						<img src="<?php echo $goods_img?>" style='width:100px;'><br>
						<span><?php echo $goods_title?><br> (코드 : <?php echo $row['goods_cd']?>)</span>
						<?php }?>
					<?	}else{
							$goods = sql_fetch("select * from {$DM['BEVERAGE_TABLE']} where beverage_cd='{$row['goods_cd']}'");
							$goods_dir = G5_DATA_URL.'/beverage';
							$goods_img = $goods_dir."/".$goods['beverage_file'];
							$goods_title = $goods['beverage_kor_nm'];
					?>
						<?php if($goods['beverage_file']){?>
						<img src="<?php echo $goods_img?>" style='width:100px;'><br>
						<span><?php echo $goods_title?><br> (코드 : <?php echo $row['goods_cd']?>)</span>
						<?php }?>
					<?	} ?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<th>제목</th>
				<td><?php echo $row['qna_category']?> <?php echo $row['qna_subject']?></td>
			</tr>
			<tr>
				<th>내용</th>
				<td>
					<?php
					if($v_img_count) {
						 echo "<div id=\"bo_v_img\">\n";

							echo $view[0]['view'];
							/*
							foreach($view[0]['file'] as $view_file) {
								echo $view_file;
								echo get_file_thumbnail($view_file);
							}
							*/

						echo "</div>\n";
					}
					?>
					<div id="bo_v_atc">
						<div id="bo_v_con"><?php echo get_view_thumbnail($row['qna_content'],600)?></div>
					</div>
				</td>
			</tr>
			</tbody>
		</table>

	</div>

</div>

<form name="frmAnswer" method="post" action="./branch_questions_answer_update.php" onsubmit="return frmAnswerChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid?>">
	
<div class="box-view-wrap">

	<div class="box-cont">

		<table class="ncp_tbl">

			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>답변제목</th>
				<td>
					<input type="text" name="answer_title" class="frm_input frm_input_full" value="<?php echo $row['answer_title']?>">
				</td>
			</tr>
			<tr>
				<th>답변내용</th>
				<td>
					<?php echo editor_html('answer_content', get_text(html_purifier($row['answer_content']), 0)); ?>
				</td>
			</tr>
			</tbody>

		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./branch_questions_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<Script>
function frmAnswerChk(f){

	<?php echo get_editor_js('answer_content'); ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}
</script>
<?
include_once ('../admin.tail.php');