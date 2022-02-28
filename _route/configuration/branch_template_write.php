<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

if($w==""){
	$title = " 등록";
}else{
	$title = " 수정";
	
	$row = sql_fetch("select * from {$DM['B_TEMPLATE_TABLE']} where uid='{$uid}'");
}

$g5['title'] = '지점 생성 템플릿 '.$title;
include_once ('../admin.head.php');
?>

<form name="frmTemplate" method="post" action="./branch_template_write_update.php" onsubmit="return frmTemplateChk(this)" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid?>">

<div class="box-view-wrap">

	<div class="view-title">
		템플릿 기본 정보
	</div>

	<div class="box-cont">
	
		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>구분</th>
			<td>
				<div class="inputbox-wrap">
					<select name="template_gubun">
						<option value="GAME" <?php echo ($row['template_gubun']=="GAME" || $w=="")?"selected":""?>>게임</option>
						<option value="RGAME" <?php echo ($row['template_gubun']=="RGAME")?"selected":""?>>추천게임</option>
						<option value="BEVERAGE"  <?php echo ($row['template_gubun']=="BEVERAGE")?"selected":""?>>식음료</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<th>템플릿 코드</th>
			<td>
				<div class="inputbox-wrap">
				<?php if($w==""){?>
				<input type="text" name="template_code" value="<?php echo get_template_uniqid()?>" class="frm_input" style="width:500px; text-align:left;">
				<?php }else{?>
				<input type="text" name="template_code" value="<?php echo $row['template_code']?>" class="frm_input" style="width:500px; text-align:left;" readonly>
				<?php }?>
				</div>
			</td>
		</tr>
		<tr>
			<th>템플릿 제목</th>
			<td>
				<div class="inputbox-wrap">
				<input type="text" name="template_title" class="frm_input required" required value="<?php echo $row['template_title']?>" style='width:500px;'>
				</div>
			</td>
		</tr>
		<tr>
			<th>사용여부</th>
			<td>
				<div class="inputbox-wrap">
				<select name="template_use_fl">
					<option value="T" <?php echo ($row['template_use_fl']=="T")?"selected":""?>>사용</option>
					<option value="F" <?php echo ($row['template_use_fl']=="F")?"selected":""?>>미사용</option>
				</select>
				</div>
			</td>
		</tr>
		<?php if($uid){?>
		<tr>
			<th>등록된 <?php echo ($row['template_gubun']=="game")?"게임":"식음료"?></th>
			<td>
				<?php echo $row['template_data_cnt']?>개 
				<?php if($row['template_data_cnt']>0){?>
				<button type="button" class="crmBtn type-white" onclick="dataMngList('<?php echo $uid?>')">Data 관리</button>
				<?php }?>
				<button type="button" class="crmBtn type-white" onclick="dataMngReg('<?php echo $uid?>')">Data 등록</button>
			</td>
		</tr>
		<?php }?>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./branch_template_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>
<script>
function frmTemplateChk(f){

	document.getElementById("btn_submit").disabled = "disabled";
	return true;

}

function dataMngList(uid){

	var _width	= '1200';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_branch_template_data.php?uid="+uid;

	var new_win = window.open(href, "pop_branch_template_data", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}

function dataMngReg(uid){

	var _width	= '1200';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_branch_template_write.php?uid="+uid;

	var new_win = window.open(href, "pop_branch_template_write", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>
<?
include_once ('../admin.tail.php');