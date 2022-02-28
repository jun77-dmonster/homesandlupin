<?php
$sub_menu = '200200';
include_once('./_common.php');


include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";

	$row = sql_fetch("select * from {$DM['FAQ_TABLE']} where uid='{$uid}'");
}
$group_cd = "03001";
$cate = sql_query("select * from {$DM['CODE_TABLE']} where group_cd='{$group_cd}' and length(item_cd)=8");


$bsql = sql_query("select * from {$DM['BRANCH_TABLE']} where branch_withdrawal_fl='F'");

$g5['title'] = '자주묻는질문 '.$title;
include_once ('../admin.head.php');


?>

<form name="frmFaq" method="post" action="./faq_register_update.php" onsubmit="return frmFaqChk(this)" enctype="multipart/form-data">
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
				<th>구분</th>
				<td>
					<div class="inputbox-wrap">
						<select name="category_cd">
							<option value="">구분</option>
							<?php
							for($i=0;$category=sql_fetch_array($cate);$i++){
							?>
							<option value="<?php echo $category['item_cd']?>" <?php echo ($category['item_cd']==$row['category_cd'])?"selected":""?>><?php echo $category['item_nm']?></option>
							<?php }?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th>지점구분</th>
				<td>
					<div class="inputbox-wrap">
						<select name="branch_cd">
							<option value="B0000">지점전체</option>
							<?php
							for($i=0;$b1=sql_fetch_array($bsql);$i++){
							?>
							<option value="<?php echo $b1['branch_cd']?>" <?php echo ($b1['branch_cd']==$row['branch_cd'])?"selected":""?>><?php echo $b1['branch_nm']?></option>
							<?php }?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th>BEST</th>
				<td>
					<span class="radio_wrap">
						<input type="checkbox" name="is_main" id="Best" value="T" <?php echo ($row['is_main']=="T")?"checked":""?>>
						<label for="Best">Best 메인 노출</label>
					</span>
				</td>
			</tr>
			<tr>
				<th>제목</th>
				<td>
					<input type="text" name="subject" class="frm_input frm_input_full required" required style='text-align:left;' maxlength="100" value="<?php echo $row['subject']?>">
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td>
					<textarea class="frm_input frm_input_full required" required name="content" style='height:150px; text-align:left;'><?php echo $row['content']?></textarea>
				</td>
			</tr>
			<tr>
				<th>답변</th>
				<td>
					<!--<textarea class="frm_input required" required name="answer" style='width:800px; height:150px; text-align:left;'><?php echo $row['answer']?></textarea>-->
					<?php echo editor_html('answer', get_text(html_purifier($row['answer']), 0)); ?>
				</td>
			</tr>
			</tbody>


		</table>

	</div><!--//box-cont-->

</div><!--//box-view-wrap-->

<div class="btn_fixed_top">
    <a href="./faq_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>	

</form>

<script>
function frmFaqChk(f){

	// 회원아이디 검사
    if (f.w.value == "") {
		
		if (!f.category_cd.value) {
            alert("카테고리 구분을 선택하세요");
            f.category_cd.focus();
            return false;
        }
    }

	<?php echo get_editor_js('answer'); ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}
</script>
<?
include_once ('../admin.tail.php');