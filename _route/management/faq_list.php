<?php
$sub_menu = '200200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['FAQ_TABLE']} ";

$sql_search = " where (1) and delete_fl='F' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'subject' :
        case 'content' :
        case 'answer' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "display_order";
    $sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$g5['title'] = '자주묻는질문';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 9;
?>

<!--
<div class="tab-wrap">
	<ul class="tab-menu">
		<li class="on"><a href="./faq_list.php">FAQ</a></li>
		<li><a href="./faq_type.php">FAQ 환경 관리</a></li>
	</ul>
</div>
-->


<form name="faqlist" id="faqlist" action="./faq_list_update.php" onsubmit="return faqlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">
	
	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">
	
				<span class="table-tit">등록된 자주묻는 질문 <span class="num"><?php echo $total_count?></span> 건</span>

				<div class="btn-wrap-left">

					<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 수정</button>
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value"  class="crmBtn type-white">선택 삭제</button>
					<button type="button" class="crmBtn type-white" onclick="location.href='./faq_register.php'">신규 등록</button>
					<button type="button" class="crmBtn type-white" onclick="faqOrder()">정렬 수정</button>

				</div>

			</div>

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
						<th>지점</th>
						<th>카테고리</th>
						<th>제목</th>
						<!--<th>유형</th>-->
						<th>등록일</th>
						<th>출력유무</th>
						<th>정렬순서</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = '<a href="./faq_register.php?'.$qstr.'&amp;w=u&amp;uid='.$row['uid'].'" class="btn btn_03">수정</a>';
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid_<?php echo $i ?>">
						</td>
						<td class="td_cnt"><?php echo $row['uid']?></td>
						<td class="td_cnt"><?php echo ($row['branch_cd']=="B0000")?"전체지점":get_branch_name($row['branch_cd'])?></td>
						<td class="td_category"><?php echo get_code_name($row['category_cd'])?></td>
						<td><?php echo $row['subject']?></td>
						<!--<td class="td_category"><?php echo ($row['is_main']=="T")?"Best":""?></td>--->
						<td class="td_datetime"><?php echo substr($row['reg_dt'],0,10)?></td>
						<td class="td_mng">
							<select name="display_fl[<?php echo $i?>]">
								<option value="T" <?php echo ($row['display_fl']=="T")?"selected":""?>>출력</option>
								<option value="F" <?php echo ($row['display_fl']=="F")?"selected":""?>>미출력</option>
							</select>
						</td>
						<td class="td_mng">
							<?php echo $row['display_order'] ?>
							<!--<input type="text" name="display_order[<?php echo $i?>]" class="frm_input" maxlength="3" style="width:60px;" value="<?php echo ($row['display_order']=="")?"0":$row['display_order']?>">-->
						</td>
						<td class="td_mng">
							<?php echo $s_mod?>
						</td>
					</tr>
					<?php
					}
					if ($i == 0)
						echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
					?>
					</tbody>
					</table>
	
				</div>

			</div>

		</div>

	</div>

</div>

</form>

<script>
function faqlist_submit(f){

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

function faqOrder(){

	var _width	= '1200';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_faq_order_list.php";

	var new_win = window.open(href, "pop_faq_order_list", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>

<?
include_once ('../admin.tail.php');