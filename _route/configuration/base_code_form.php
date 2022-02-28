<?php
$sub_menu = '100300';
include_once('./_common.php');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";
}

$g5['title'] = '코드 '.$title;
include_once ('../admin.head.php');

if($w==""){
	
	$c1 = sql_fetch("select item_cd from {$DM['CODE_TABLE']} where group_cd='{$groupCd}' and length(item_cd)=8 order by item_cd desc");

	if(!$c1['item_cd']){
		$item_cd=$groupCd."001";
	}else{
		
		$temp_code = substr($c1['item_cd'],5,3);
			
		$temp_code = intval($temp_code)+1;

		if( strlen($temp_code)=="1" ){
			$real_code = "00".$temp_code;
		}else if(strlen($temp_code)=="2"){
			$real_code = "0".$temp_code;
		}else{
			$real_code = $temp_code;
		}

		$item_cd = $groupCd.$real_code;
	}

}else{

	
}
?>

<form name="frmCode" method="post" action="./base_code_form_update.php" onsubmit="return frmCodeChk(this)">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">

	<div class="view-title">
		카테고리 기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
			
			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>코드번호</th>
				<td colspan="3">
					<div class="inputbox-wrap">
						<input type="text" name="item_cd" id="item_cd" class="frm_input full required" value="<?php echo $item_cd?>" maxlength="45" autocomplete="false"  style='width:334px; text-align:left;' readonly >	
					</div>
				</td>
			</tr>
			<tr>
				<th>코드항목</th>
				<td colspan="3">
					<div class="inputbox-wrap">
						<input type="text" name="item_nm" id="item_nm" class="frm_input full required" value="<?php echo $item_nm?>" maxlength="45" autocomplete="false"  style='width:334px; text-align:left;' required>	
					</div>
				</td>
			</tr>
			</tbody>

		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <input type="submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>
<script>
function frmCodeChk(f){

	return true;

}
</script>
<?
include_once ('../admin.tail.php');