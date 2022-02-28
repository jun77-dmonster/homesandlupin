<?php
$sub_menu = '400100';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";

	$row = sql_fetch("select * from {$DM['NOTICE_TABLE']} where uid='{$uid}'");

	$file = sql_fetch("select * from {$DM['BF_TABLE']} where bd_id='notice' and uid='{$uid}'");
}

$g5['title'] = '지점 공지사항 '.$title;
include_once ('../admin.head.php');

$colspan = 7;

$bsql = sql_query("select * from {$DM['BRANCH_TABLE']} where branch_withdrawal_fl='F'");
?>

<form name="frmNotice" method="post" action="./branch_notice_write_update.php" onsubmit="return frmNoticeChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid?>">
<input type="hidden" name="bo_table" value="notice">

<div class="box-view-wrap">

	<div class="box-cont">

		<table class="ncp_tbl">

			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>지점구분</th>
				<td>
					<div class="inputbox-wrap">
						<select name="notice_gubun">
							<option value="B0000">지점전체</option>
							<?php
							for($i=0;$b1=sql_fetch_array($bsql);$i++){
							?>
							<option value="<?php echo $b1['branch_cd']?>" <?php echo ($b1['branch_cd']==$row['notice_gubun'])?"selected":""?>><?php echo $b1['branch_nm']?></option>
							<?php }?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th>말머리</th>
				<td>
					<div class="inputbox-wrap">
						<select name="notice_category">
							<option value="">말머리선택</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th>제목</th>
				<td>
					<input type="text" name="notice_title" class="frm_input frm_input_full" value="<?php echo $row['notice_title']?>">
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td>
					<?php echo editor_html('notice_content', get_text(html_purifier($row['notice_content']), 0)); ?>
				</td>
			</tr>
			<tr>
				<th>첨부파일</th>
				<td>
					<input type="file" name="bf_file[]" class="frm_input">
					 <?php if($w == 'u' && $file['bf_file']) { ?>
					 <span class="checkbox_item marR10">
						<input type="checkbox" id="bf_file_del" name="bf_file_del[0]" value="1"> <label for="bf_file_del"><?php echo $file['bf_source'].'('.$file['bf_size'].')';  ?> 파일 삭제</label>
					 </span>
					 <?php } ?>
				</td>
			</tr>
			</tbody>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./branch_notice_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>	

</form>
<script>
function frmNoticeChk(f){

	// 회원아이디 검사
    if (f.w.value == "") {
		
		if (!f.notice_gubun.value) {
            alert("지점 구분을 선택하세요");
            f.notice_gubun.focus();
            return false;
        }

    }

	<?php echo get_editor_js('notice_content'); ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}
</script>
<?
include_once ('../admin.tail.php');