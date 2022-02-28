<?php
$sub_menu = '200400';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";
	$row = sql_fetch("select * from {$DM['POPUP_TABLE']} where nw_uid='{$nw_uid}'");
}

$branch_info = '';
$sql = " select branch_cd, branch_nm  from {$DM['BRANCH_TABLE']} where branch_withdrawal_fl='F' ";
$r1 = sql_query($sql);

for ($i=0; $c1=sql_fetch_array($r1); $i++)
{
    $branch_info .= "<option value=\"{$c1['branch_cd']}\">$nbsp{$c1['branch_nm']}</option>\n";
}

$g5['title'] = '팝업 '.$title;
include_once ('../admin.head.php');


?>

<form name="frmPopup" method="post" action="./popup_register_update.php" onsubmit="return frmPopupChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="nw_id" value="<?php echo $uid?>">

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
				<select name="branch_cd" style="width:250px;">
					<option value="B0000" <?php echo ($row['branch_cd']=="B0000")?"selected":""?>>전체지점</option>
					<?php echo conv_selected_option2($branch_info, $row['branch_cd']); ?>
				<select>
				</div>
			</td>
		</tr>
		<tr>
			<th>시간</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="nw_disable_hours" class="frm_input required" required value="<?php echo ($w=="")?"24":$row['nw_disable_hours']?>" size="4" maxlength="2"> <span>필수 고객이 다시 보지 않음을 선택할 시 몇 시간동안 팝업레이어를 보여주지 않을지 설정합니다.</span>
				</div>
			</td>
		</tr>
		<tr>
			<th>시작일시</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="nw_begin_time" value="<?php echo $row['nw_begin_time']?>" id="nw_begin_time" class="frm_input" style="width:250px;"  maxlength="10">
				<input type="checkbox" name="nw_begin_chk" value="<?php echo date("Y-m-d", G5_SERVER_TIME); ?>" id="nw_begin_chk" onclick="if (this.checked == true) this.form.nw_begin_time.value=this.form.nw_begin_chk.value; else this.form.nw_begin_time.value = this.form.nw_begin_time.defaultValue;">
				<label for="nw_begin_chk">시작일시를 오늘로</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>종료일시</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="nw_end_time" value="<?php echo $row['nw_end_time']?>" id="nw_end_time" class="frm_input" style="width:250px;" maxlength="10">
				<input type="checkbox" name="nw_end_chk" value="<?php echo date("Y-m-d", G5_SERVER_TIME+(60*60*24*7)); ?>" id="nw_end_chk" onclick="if (this.checked == true) this.form.nw_end_time.value=this.form.nw_end_chk.value; else this.form.nw_end_time.value = this.form.nw_end_time.defaultValue;">
				<label for="nw_end_chk">종료일시를 오늘로부터 7일 후로</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>팝업 넓이</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="nw_width" value="<?php echo $row['nw_width'] ?>" id="nw_width" required class="frm_input required" size="5"> px
				</div>
			</td>
		</tr>
		<tr>
			<th>팝업 높이</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="nw_height" value="<?php echo $row['nw_height'] ?>" id="nw_height" required class="frm_input required" size="5"> px
				</div>
			</td>
		</tr>
		<tr>
			<th>팝업 제목</th>
			<td>
				<input type="text" name="nw_title" value="<?php echo get_sanitize_input($row['nw_title']); ?>" id="nw_title" required class="frm_input frm_input_full required" size="80">
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td><?php echo editor_html('nw_content', get_text(html_purifier($row['nw_content']), 0)); ?></td>
		</tr>
		</tbody>

		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./popup_list.php" class=" btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>
<script>
function frmPopupChk(f){

	errmsg = "";
    errfld = "";

    <?php echo get_editor_js('nw_content'); ?>

    check_field(f.nw_subject, "제목을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;

	document.getElementById("btn_submit").disabled = "disabled";

	return true;

}
</script>
<?
include_once ('../admin.tail.php');