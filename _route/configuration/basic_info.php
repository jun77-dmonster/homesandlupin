<?php
$sub_menu = '100100';
include_once('./_common.php');

$g5['title'] = '기본 환경 설정';
include_once ('../admin.head.php');

add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
?>

<form name="frmConfig" method="post" action="./basic_info_update.php" onsubmit="return frmConfigChk(this)">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">

	<div class="view-title">
		기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
			<colgroup>
				<col style='width:190px;'>
				<col style='width:auto'>
				<col style='width:190px;'>
				<col style='width:auto'>
			</colgroup>
			<tr>
				<th>사이트명</th>
				<td>
					<div class="inputbox-wrap">
						<input type="text" name="site_nm" id="site_nm" class="frm_input full required" required data="사이트명" value="<?php echo $route['site_nm']?>" placeholder="사이트명 입력" maxlength="45" autocomplete="false"  style='width:350px; text-align:left;' >	
					</div>
				</td>
				<th>최고관리자</th>
				<td>
					<div class="inputbox-wrap">
					<?php echo get_member_id_select('sc_admin', 10, $route['sc_admin'], 'required') ?>
					</div>
				</td>
			</tr>
			<tr>
				<th>접근가능IP</th>
				<td>
					<div class="inputbox-wrap">
					<p class="marB05">입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)</p>
					<textarea name="sc_possible_ip" id="sc_possible_ip" style='width:350px; height:100px;'><?php echo get_sanitize_input($route['sc_possible_ip']); ?></textarea>
					</div>
				</td>
				<th>접근차단IP</th>
				<td>
					<div class="inputbox-wrap">
					<p class="marB05">입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)</p>
					<textarea name="sc_intercept_ip" id="sc_intercept_ip" style='width:350px; height:100px;'><?php echo get_sanitize_input($route['sc_intercept_ip']); ?></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<th>아이디,닉네임,금지단어</th>
				<td>
					<div class="inputbox-wrap">
					<p class="marB05">회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분</p>
					<textarea name="sc_prohibit_id" id="sc_prohibit_id" style='width:350px; height:100px;'><?php echo get_sanitize_input($route['sc_prohibit_id']); ?></textarea>
					</div>
				</td>
				<th>입력금지메일</th>
				<td>
					<div class="inputbox-wrap">
					<p class="marB05">입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com</p>
					<textarea name="sc_prohibit_email" id="sc_prohibit_email" style='width:350px; height:100px;'><?php echo get_sanitize_input($route['sc_prohibit_email']); ?></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<th>단어필터링</th>
				<td colspan="3">
					<p class="marB05">입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.</p>
					<textarea name="sc_filter" id="sc_filter" style='width:800px; height:100px;'><?php echo get_sanitize_input($route['sc_filter']); ?></textarea>
				</td>
			</tr>
			<tr>
				<th>이미지 업로드 확장자</th>
				<td>
					<div class="inputbox-wrap">
					<input type="text" name="sc_image_extension" value="<?php echo get_sanitize_input($route['sc_image_extension']); ?>" id="sc_image_extension" class="frm_input" style='width:350px;'>
					</div>
				</td>
				<th>앱 버전</th>
				<td>
					<div class="inputbox-wrap">
					<input type="text" name="app_version" class="frm_input" value="<?php echo $route['app_version']?>" placeholder="추후 앱 업데이트 할 때 비교를 합니다" style='width:350px; text-align:left;'> 
					</div>
				</td>
			</tr>
		</table>

	</div>

	<div class="view-title">
		회사 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col style='width:auto'>
			<col style='width:200px;'>
			<col style='width:auto'>
		</colgroup>
		<tr>
			<th>상호명</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="com_nm" id="com_nm" data="상호명" class="frm_input full " value="<?php echo $route['com_nm']?>" placeholder="상호명 입력" autocomplete="false" style='width:350px;  text-align:left;' >	
				</div>
			</td>
			<th>대표자명</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="ceo_nm" id="ceo_nm" data="대표자명" class="frm_input full " value="<?php echo $route['ceo_nm']?>" placeholder="대표자명 입력" maxlength="10" autocomplete="false" style='width:350px;  text-align:left;' >	
				</div>
			</td>
		</tr>
		<tr>
			<th>고객센터 전화</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="cscenter_number" id="cscenter_number" data="고객센터전화" class="frm_input full " value="<?php echo $route['cscenter_number']?>" placeholder="고객센터전화 입력" maxlength="10" autocomplete="false" style='width:350px;  text-align:left;' >	
				</div>
			</td>
			<th>고객센터 이메일</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="cscenter_email" id="cscenter_email" data="고객센터 이메일" class="frm_input full " value="<?php echo $route['cscenter_email']?>" placeholder="고객센터 이메일" maxlength="10" autocomplete="false" style='width:350px;  text-align:left;' >	
				</div>
			</td>
		</tr>
		<tr>
			<th>운영시간</th>
			<td colspan="3">
				<div class="inputbox-wrap">
				<textarea name="cscenter_time" class="frm_input" style='width:800px; height:100px;'><?php echo $route['cscenter_time']?></textarea>
				</div>
			</td>
		</tr>
		<tr>
			<th>사업장 주소</th>
			<td colspan="3">
				<div class="mb-2">
					<div style='width:100%;'>
					<div class="inputbox-wrap">
						<input type="text" name="biz_addr_zip" data="우편번호" id="biz_addr_zip" class="frm_input" maxlength="5" value="<?php echo $route['biz_addr_zip']?>" style='width:120px; text-align:left;'>
					</div>
					<button type="button" class="double_click_allow type-white" onclick="win_zip2('frmConfig', 'biz_addr_zip', 'biz_addr_basic', 'biz_addr_road_basic');">우편번호 찾기</button>
					</div>
				</div>

				<div class="mb-2">
					<div class="inputbox-wrap">
						<input type="text" name="biz_addr_basic" data="지번기본주소" id="biz_addr_basic" class="frm_input" maxlength="100" value="<?php echo $route['biz_addr_basic']?>" readonly style='width:334px; text-align:left;'>
					</div>
					<div class="inputbox-wrap">
						<input type="text" name="biz_addr_detail" data="지번상세주소" id="biz_addr_detail" class="frm_input" maxlength="100" value="<?php echo $route['biz_addr_detail']?>" style='width:300px; text-align:left;' placeholder="지번 상세주소 입력">
					</div>
				</div>

				<div class="mb-2">
					<div class="inputbox-wrap">
						<input type="text" name="biz_addr_road_basic" data="도로명기본주소" id="biz_addr_road_basic" class="frm_input" maxlength="100" value="<?php echo $route['biz_addr_road_basic']?>" readonly style='width:334px; text-align:left;'>
					</div>
					<div class="inputbox-wrap">
						<input type="text" name="biz_addr_road_detail" data="도로명상세주소" id="biz_addr_road_detail" class="frm_input" maxlength="100" value="<?php echo $route['biz_addr_road_detail']?>" style='width:300px; text-align:left;' placeholder="도로명 상세주소 입력">
					</div>
				</div>
			</td>
		</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <input type="submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
function frmConfigChk(f){


	
	return true;

}
</script>
<?
include_once ('../admin.tail.php');