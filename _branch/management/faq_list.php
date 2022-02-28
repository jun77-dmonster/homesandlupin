<?php
$sub_menu = '200100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['FAQ_TABLE']} ";

$sql_search = " where (1) and delete_fl='F' and branch_cd IN('B0000','{$branch['branch_cd']}')  ";

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

$g5['title'] = 'FAQ';
include_once ('../admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 8;
?>

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

					<button type="button" class="crmBtn type-white" onclick="popQna('<?php echo $DM['QNA_CODE3']?>')">지점문의</button>

				</div>

			</div>

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					
					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th>번호</th>
						<th>지점</th>
						<th>카테고리</th>
						<th>제목</th>
						<th>유형</th>
						<th>등록일</th>
						<th>정렬순서</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = '<a href="./faq_form.php?'.$qstr.'&amp;w=u&amp;uid='.$row['uid'].'" class="btn btn_03">수정</a>';
					?>
					<tr>
						<td class="td_cnt"><?php echo $row['uid']?></td>
						<td class="td_cnt"><?php echo ($row['branch_cd']=="B0000")?"전체지점":get_branch_name($row['branch_cd'])?></td>
						<td class="td_category"><?php echo get_code_name($row['category_cd'])?></td>
						<td><?php echo $row['subject']?></td>
						<td class="td_category"><?php echo ($row['is_main']=="T")?"Best":""?></td>
						<td class="td_datetime"><?php echo substr($row['reg_dt'],0,10)?></td>
						<td class="td_mng">
							<?php echo $row['display_order']; ?>
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

<?
include_once ('../admin.tail.php');