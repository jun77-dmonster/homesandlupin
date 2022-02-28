<?php
$sub_menu = '400200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '지점 문의 상세보기';
include_once ('../admin.head.php');

$bd_id='qna';

$row = sql_fetch("select * from {$DM['QNA_TABLE']} where uid='{$uid}'");

$view = get_file2($bd_id,$uid);
 
$v_img_count = count($view[0]['file']);

if($row['qna_status']=="Q"){
	sql_query("update {$DM['QNA_TABLE']} set qna_status='C', admin_confirm_dt='".G5_TIME_YMDHIS."' where uid='{$uid}' ");
}
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
				<td><?php echo array_search($row['qna_gubun'],$branch_gubun)?></td>
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
			<?php if($row['qna_status']=="A"){?>
			<tr>
				<th>답변제목</th>
				<td><?php echo $row['answer_title']?></td>
			</tr>
			<tr>
				<th>답변</th>
				<td><?php echo $row['answer_content']?></td>
			</tr>
			<?php }?>
			</tbody>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./branch_questions_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<a href="./branch_questions_answer.php?<?php echo $qstr ?>&amp;w=a&amp;uid=<?php echo $uid?>" class="btn btn_03">답변</a>
	<!--<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">-->
</div>	

<Script>
$(function() {
    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
</script>
<?
include_once ('../admin.tail.php');