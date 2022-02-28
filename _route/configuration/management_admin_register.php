<?php
$sub_menu = '100200';
include_once('./_common.php');

if($w==""){
	$title=" 등록";
}else{
	$title=" 수정";

	$manager = sql_fetch("select * from {$DM['MANAGER_TABLE']} where manager_id='{$manager_id}'");

	$manager_email = explode("@",$manager['manager_email']);
}

$g5['title'] = '운영자 '.$title;
include_once ('../admin.head.php');
?>

<form name="frmManager" method="post" action="./management_admin_register_update.php" onsubmit="return frmManagerChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">

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
				<th>아이디</th>
				<td>
					<div class="inputbox-wrap">
						<input type="text" name="manager_id" class="frm_input required" value="<?php echo $manager['manager_id']?>" style='width:300px;' maxlength="20" placeholder="아이디 입력(20자이내)" required>
					</div>
				</td>
				<th>비밀번호</th>
				<td>
					<div class="inputbox-wrap">
						<input type="password" name="manager_pw" class="frm_input" value="" style='width:300px; text-align:left;' maxlength="16" placeholder="비밀번호 입력 10~16자리 이하로 설정" <?php ($w=="")?"requiredwkwp":""?>>
					</div>
				</td>
			</tr>
			<tr>
				<th>이름</th>
				<td>
					<div class="inputbox-wrap">
						<input type="text" name="manager_nm" class="frm_input required" style="width:300px; text-align:left;" maxlength="20" placeholder=
						"이름 입력 20자 이내" value="<?php echo $manager['manager_nm']?>" required>
					</div>
				</td>
				<th>닉네임</th>
				<td>
					<div class="inputbox-wrap">
						<input type="text" name="manager_nick_nm" class="frm_input" style="width:300px; text-align:left;" maxlength="20" placeholder=
						"닉네임 입력 20자 이내" value="<?php echo $manager['manager_nick_nm']?>">
					</div>
				</td>
			</tr>
			<tr>
				<th>로그인제한</th>
				<td colspan="3">
					<div class="inputbox-wrap">
						<label class="radio-inlilne">
							<input type="radio" name="login_limit_fl" value="F" <?php echo ($manager['login_limit_fl']=="F" || $w=="")?"checked":""?>> 로그인가능
						</label>
						<label class="radio-inlilne">
							<input type="radio" name="login_limit_fl" value="T" <?php echo ($manager['login_limit_fl']=="T")?"checked":""?>> 로그인제한
						</label>
					</div>
					<div class="notice-info">
						‘로그인제한’ 설정 시 해당 운영자는 관리자에 접속할 수 없습니다.
					</div>
				</td>
			</tr>
			<tr>
				<th>프로필이미지</th>
				<td colspan="3" class="form-inline">
					<input type="file" name="manager_image" class="frm_input" style='width:300px;'>
				</td>
			</tr>
			<tr>
				<th>직원여부</th>
				<td colspan="3">
					<div class="inputbox-wrap">
						<label class="radio-inlilne">
							<input type="radio" name="employee_fl" value="Y" <?php echo ($manager['employee_fl']=="Y" || $w=="")?"checked":""?>> 직원
						</label>
						<label class="radio-inlilne">
							<input type="radio" name="employee_fl" value="T" <?php echo ($manager['employee_fl']=="T")?"checked":""?>> 비정규직
						</label>
						<label class="radio-inlilne">
							<input type="radio" name="employee_fl" value="P" <?php echo ($manager['employee_fl']=="P")?"checked":""?>> 아르바이트
						</label>
						<label class="radio-inlilne">
							<input type="radio" name="employee_fl" value="D" <?php echo ($manager['employee_fl']=="D")?"checked":""?>> 파견직
						</label>
						<label class="radio-inlilne">
							<input type="radio" name="employee_fl" value="R" <?php echo ($manager['employee_fl']=="R")?"checked":""?>> 퇴사자
						</label>

					</div>
				</td>
			</tr>
			<tr>
				<th>휴대폰번호</th>
				<td>
					<div class="inputbox-wrap">
						<input type="text" name="cell_phone" class="frm_input required" style="width:300px; text-align:left;" placeholder="휴대폰번호 -없이 입력" value="<?php echo $manager['cell_phone']?>" required maxlength="13">
					</div>
				</td>
				<th>운영자등급</th>
				<td>
					<div class="inputbox-wrap">
						<select name="manager_level">
							<option value="">선택하세요</option>>
							<option value="1" <?php echo ($manager['manager_level']=="1")?"selected":""?>>1</option>>
							<option value="2" <?php echo ($manager['manager_level']=="2")?"selected":""?>>2</option>>
							<option value="3" <?php echo ($manager['manager_level']=="3")?"selected":""?>>3</option>>
							<option value="4" <?php echo ($manager['manager_level']=="4")?"selected":""?>>4</option>>
							<option value="5" <?php echo ($manager['manager_level']=="5")?"selected":""?>>5</option>>
							<option value="6" <?php echo ($manager['manager_level']=="6")?"selected":""?>>6</option>>
							<option value="7" <?php echo ($manager['manager_level']=="7")?"selected":""?>>7</option>>
							<option value="8" <?php echo ($manager['manager_level']=="8")?"selected":""?>>8</option>>
							<option value="9" <?php echo ($manager['manager_level']=="9")?"selected":""?>>9</option>>
							<option value="10" <?php echo ($manager['manager_level']=="10")?"selected":""?>>10</option>>
						</select>
						(10은 최고 관리자. 한명만 가능)
					</div>
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td colspan="3">
					<div class="inputbox-wrap">
						<input type="text" name="manager_email1" data="운영자 이메일 아이디" class="frm_input full" value="<?php echo $manager_email[0]?>" placeholder="" maxlength="64" autocomplete="false" style='width:300px; text-align:left;'>	
					</div>
					<span class="sign-mid">@</span>
					<div class="inputbox-wrap">
						<input type="text" name="manager_email2" data="운영자 이메일 도메인" class="frm_input full" value="<?php echo $manager_email[1]?>" placeholder="" maxlength="255" autocomplete="false" style='width:200px; text-align:left;'>	
					</div>
				</td>
			</tr>
			<tr>
				<th>메모</th>
				<td colspan="3">
					<div class="inputbox-wrap">
						<textarea class="frm_input" name="memo" style='width:800px; height:150px;'><?php echo $manager['memo']?></textarea>
					</div>
				</td>
			</tr>
			</tbody>
		</table>

	</div><!--//box-cont-->

</div>

<div class="btn_fixed_top">
    <input type="submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
function frmManagerChk(f){

	
	return true;

}
</script>

<?
include_once ('../admin.tail.php');