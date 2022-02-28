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

switch($row['qna_gubun']){
							
	case "{$DM['QNA_CODE0']}" : $gubun = "지점 정보"; break;
	case "{$DM['QNA_CODE1']}" : $gubun = "지점 이용안내"; break;
	case "{$DM['QNA_CODE2']}" : $gubun = "지점 추천게임정보"; break;
	case "{$DM['QNA_CODE3']}" : $gubun = "FAQ"; break;
	case "{$DM['QNA_CODE4']}" : $gubun = "팝업"; break;
	case "{$DM['QNA_CODE5']}" : $gubun = "게임"; break;
	case "{$DM['QNA_CODE6']}" : $gubun = "식음료"; break;

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
				<td>
					<?php echo $gubun;?>
				</td>
			</tr>
			<tr>
				<th>문의상품</th>
				<td></td>
			</tr>
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
			<?php if($row['qna_status']=="C"){?>
			<tr>
				<th>관리자 확인일자</th>
				<td><?php echo $row['admin_confirm_dt']?></td>
			</tr>
			<?php }?>
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
    <a href="./questions_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<?php if($row['qna_status']=="Q"){?>
	<a href="./questions_write.php?<?php echo $qstr ?>&amp;w=u&amp;uid=<?php echo $uid?>" class="btn btn_03">수정</a>
	<?php }?>
</div>	

<Script>
$(function() {
    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
<?
include_once ('../admin.tail.php');