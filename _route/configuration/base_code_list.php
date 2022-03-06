<?php
$sub_menu = '100300';
include_once('./_common.php');

$g5['title'] = '코드관리';
include_once ('../admin.head.php');

auth_check_menu($auth, $sub_menu, 'r');

$categroup = sql_query("select * from {$DM['CODE_TABLE']} where length(item_cd)=2");

if($categoryGroupCd=="" && $groupCd==""){
	$categoryGroupCd = "01";
	$groupCd = "01001";

}

//2차카테고리
$groupResult = sql_query("select * from {$DM['CODE_TABLE']} where category_group_cd='{$categoryGroupCd}' and length(item_cd)=5");

$sql_common = " from {$DM['CODE_TABLE']} ";

$sql_search = " where group_cd='{$groupCd}' and length(item_cd)=8";

if (!$sst) {
	$sst = "item_cd";
	$sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);
	
$colspan = 7;

?>

<div class="box-view-wrap">

	<div class="search_box search_field">

		<table class="ncp_tbl" style='margin:20px 0 20px 0;'>
			<colgroup>
				<col style='width:140px;'>
				<col>
				<col style='width:140px;'>
				<col>
			</colgroup>
			<tr>
				<th scope="row">구분</th>
				<td>
					<div class="inputbox-wrap">
					<select name="categoryGroupCd" onchange="categoryGroup(this.value)" style='width:300px;'>
						<?php for($i=0;$r1= sql_fetch_array($categroup);$i++){?>
						<option value="<?php echo $r1['item_cd']?>" <?php echo ($r1['item_cd']==$categoryGroupCd)?"selected":""?>><?php echo $r1['item_nm']?></option>
						<?php }?>
					</select>
					</div>
				</td>
				<th scope="row">코드그룹</th>
				<td>
					<div class="inputbox-wrap">
					<select name="groupCode" onchange="Group('<?php echo $categoryGroupCd ?>',this.value)"  style='width:300px;'>
						<option value="">그룹선택</option>
						<?php for($i=0;$r2= sql_fetch_array($groupResult);$i++){?>
						<option value="<?php echo $r2['item_cd']?>" <?php echo ($r2['item_cd']==$groupCd)?"selected":""?>><?php echo $r2['item_nm']?></option>
						<?php }?>
					</select>
					</div>
				</td>
			</tr>
		</table>

	</div><!--//search_box search_field-->

</div><!--검색 시작-->

<form name="fcodslist" id="fcodslist" action="./base_code_list_update.php" onsubmit="return fcodelist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="categoryGroup" value="<?php echo $categoryGroupCd?>">
<input type="hidden" name="groupCd" value="<?php echo $groupCd?>">
<div class="box-view-wrap">
	
	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">등록된 카테고리 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white" onclick="codeWrite('<?php echo $groupCd?>')">코드추가</button>
					<!--<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>-->
					<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="crmBtn type-white">선택수정</button>

				</div>

			</div><!--//table-tit-area-->

			<div class="content_item_bx">
				
				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th scope="col">
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th>번호</th>
						<th>코드번호</th>
						<th>항목명</th>
						<th>사용설정</th>
						<th>출력순서</th>
						<!--<th>관리</th>-->
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$mod = "./manager_form.php?{$qstr}&amp;w=u&amp;manager_id={$row['manager_id']}";
						$j=$i+1;
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="item_cd[<?php echo $i ?>]" value="<?php echo $row['item_cd'] ?>" id="item_cd_<?php echo $i ?>">
						</td>
						<td class="td_num"><?php echo $j?></td>
						<td class="td_category"><?php echo $row['item_cd']?></td>
						<td><input type="text" name="item_nm[<?php echo $i ?>]" class="frm_input frm_input_sfull" value="<?php echo $row['item_nm']?>"></td>
						<td class="td_category">
							<select name="use_fl[<?php echo $i?>]">
								<option value="T" <?php echo ($row['use_fl']=='T')?"selected":""?>>사용</option>
								<option value="F" <?php echo ($row['use_fl']=='F')?"selected":""?>>미사용</option>
							</select>
						</td>
						<td class="td_category">
							<input type="text" name="item_order[<?php echo $i?>]" class="frm_input" size="3" value="<?php echo $row['item_order']?>">
						</td>
						<!--
						<td class="td_mng">
							
						</td>
						-->
					</tr>
					<?
					}
					if ($i == 0)
					echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">등록된 분류가 없습니다.</td></tr>";
					?>
					</tbody>
					</table>

				</div><!--//tbl_head01 tbl_wrap-->
				
			</div><!--//content_item_bx-->

			<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

		</div><!--//mall-orders-view-->

	</div><!--//mall-products-view-->

</div>
</form>

<script>
var f = document.fcodslist;

function categoryGroup(str){
	
	location.href="./base_code_list.php?categoryGroupCd="+str;

}

function Group(str1,str2){
	
	location.href="./base_code_list.php?categoryGroupCd="+str1+"&groupCd="+str2;

}

function codeWrite(groupCd){

	if(f.groupCd.value){
		location.href="./base_code_form.php?groupCd="+groupCd	
	}else{
		alert("코드그룹을 선택해 주세요");
		f.groupCd.focus();
		return false;
	}
	
}


function fcodelist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?
include_once ('../admin.tail.php');