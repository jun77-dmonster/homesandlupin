<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$branch_info = get_branch_info($branch_cd);

$g5['title'] = "{$branch_info['branch_nm']} 고객의 소리 관리";
include_once ('../../pop.admin.head.php');

$sql_common = " from {$DM['VOICE_CUSTOMER_TABLE']}";

$sql_search = " where branch_cd='{$branch_info['branch_cd']}' ";

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
    $sst = "uid";
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

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="10";
?>

<div class="layer-popup">

	<div class="wrapper type-1200">

		<div class="container-wrap">

			<div class="box-view-wrap">	
	
				<div class="view-title"><?php echo $branch_info['branch_nm']?> 등록된 고객의 소리 : <?php echo $total_count;?> 건</div>

				<div class="content-bottom-wrap2">

					<div class="contents type-3">

						<div class="inner-table-wrap type-2 scroll">

							<div class="tbl_head01 tbl_wrap">

								<table>
								<caption><?php echo $g5['title']; ?> 목록</caption>
								<thead>
								<tr>
									<!--
									<th scope="col">
										<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
									</th>
									-->
									<th>번호</th>
									<!--<th>지점</th>-->
									<th>룸번호</th>
									<th>내용</th>
									<th>등록구분</th>
									<th>아이피</th>
									<th>등록일</th>
								</tr>
								</thead>
								<tbody>
								<?php
								for ($i=0; $row=sql_fetch_array($result); $i++) {
								?>
								<tr>
									<!--
									<td class="td_chk">
										<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
										<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid<?php echo $i ?>">
									</td>
									-->
									<td class="td_num"><?php echo $row['uid']?></td>
									<!--<td class="td_code"></td>-->
									<td class="td_category"><?php echo $row['room_cd']?></td>
									<td class="td_addr"><?php echo $row['customer_content']?></td>
									<td class="td_category"><?php echo $row['write_gubun']?></td>
									<td class="td_category"><?php echo $row['write_ip']?></td>
									<td class="td_date"><?php echo substr($row['customer_reg_dt'],0,10)?></td>
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

		</div>

	</div>

</div>

<?
include_once ('../../pop.admin.tail.php');