<?php
$sub_menu = '400200';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";

	$row = sql_fetch("select * from {$DM['QNA_TABLE']} where uid='{$uid}'");

	$file = sql_fetch("select * from {$DM['BF_TABLE']} where bd_id='qna' and uid='{$uid}'");
}

$g5['title'] = '본사 문의하기'.$title;
include_once ('../admin.head.php');
?>

<form name="frmBranchQuestion" method="post" action="./questions_write_update.php" onsubmit="return frmBranchQuestionChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid?>">
<input type="hidden" name="bo_table" value="qna">


<div class="box-view-wrap">

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>	
		<tr>
			<th>문의구분</th>
			<td>
				<div class="inputbox-wrap">
				<select name="qna_gubun" style="width:200px;">
				<option value="P1000" <?php echo ($code=="P1000")?"selected":""?>>지점 정보</option>
				<option value="P1001" <?php echo ($code=="P1001")?"selected":""?>>지점 이용안내</option>
				<option value="P1002" <?php echo ($code=="P1002")?"selected":""?>>지점 추천게임정보</option>
				<option value="P1003" <?php echo ($code=="P1003")?"selected":""?>>FAQ</option>
				<option value="P1004" <?php echo ($code=="P1004")?"selected":""?>>팝업</option>
				<option value="P1005" <?php echo ($code=="P1005")?"selected":""?>>게임</option>
				<option value="P1006" <?php echo ($code=="P1006")?"selected":""?>>식음료</option>
				</select>
				</div>
			</td>
		</tr>
		<!--
		<tr>
			<th>말머리</th>
			<td>
				<div class="inputbox-wrap">
				<select name="qna_category" style="width:200px;">
				<option value="">말머리</option>
				</select>
				</div>
			</td>
		</tr>
		-->
		<tr>
			<th>제목</th>
			<td>
				<input type="text" name="qna_subject" class="frm_input frm_input_full" value="<?php echo $row['qna_subject']?>">
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td><?php echo editor_html('qna_content', get_text(html_purifier($row['qna_content']), 0)); ?></td>
		</tr>
		<tr>
			<th>파일첨부</th>
			<td>
				<input type="file" name="bf_file[]" class="frm_input">
				 <?php if($w == 'u' && $file['bf_file']) { ?>
				 <span class="checkbox_item marR10">
					<input type="checkbox" id="bf_file_del" name="bf_file_del[0]" value="1"> <label for="bf_file_del"><?php echo $file['bf_source'];  ?> 파일 삭제</label>
				 </span>
				 <?php } ?>
			</td>
		</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./questions_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
function frmBranchQuestionChk(f){

	<?php echo get_editor_js('qna_content'); ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}
</script>

<?
include_once ('../admin.tail.php');