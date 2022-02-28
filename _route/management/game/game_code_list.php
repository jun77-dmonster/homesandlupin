<?php
$sub_menu = '200610';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '게임코드관리';
include_once ('../../admin.head.php');

$gameCode = "10";

$sql_common = " from {$DM['CODE_TABLE']} ";

$sql_search = " where item_cd like '{$gameCode}%' and length(item_cd)=4 ";

if (!$sst) {
	$sst = "item_order";
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
	
$colspan = 7;
?>

<form name="fcodslist" id="fcodslist" action="./base_code_list_update.php" onsubmit="return fcodelist_submit(this);" method="post">
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
			
				<span class="table-tit">등록된 카테고리 <span class="num">0</span> 건</span>

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
						<th>코드</th>
						<th>카테고리명</th>
						<th>사용여부</th>
						<th>출력순서</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {

					$level = strlen($row['item_cd']) / 2 - 1;

					$p_ca_name = '';

					if ($level > 0) {
						$class = 'class="name_lbl"'; // 2단 이상 분류의 label 에 스타일 부여 - 지운아빠 2013-04-02
						// 상위단계의 분류명
						$p_ca_id = substr($row['item_cd'], 0, $level*2);
						$sql = " select item_nm from {$DM['CODE_TABLE']} where item_cd = '$p_ca_id' ";
						$temp = sql_fetch($sql);
						$p_ca_name = $temp['item_nm'].'의하위';
					} else {
						$class = '';
					}

					//$s_level = '<div><label for="ca_name_'.$i.'" '.$class.'><span class="sound_only">'.$p_ca_name.''.($level+1).'단 분류</span></label></div>';
					$s_level_input_size = 25 - $level *2; // 하위 분류일 수록 입력칸 넓이 작아짐 - 지운아빠 2013-04-02

					if ($level+2 < 5) $s_addr = '<a href="./game_code_register.php?item_cd='.$row['item_cd'].'&amp;'.$qstr.'" class="btn btn_03">추가</a> '; // 분류는 4단계까지만 가능
					else $s_addr = '';
					
					$mod = "./game_code_register.php?{$qstr}&amp;w=u&amp;item_cd={$row['item_cd']}";
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="item_cd[<?php echo $i ?>]" value="<?php echo $row['item_cd'] ?>" id="item_cd<?php echo $i ?>">
						</td>
						<td class="td_category_middle"><?php echo $row['item_cd']?></td>
						<td class="td_addr"><?php echo $row['item_nm']?></td>
						<td class="td_cnt"></td>
						<td class="td_cnt"></td>
						<td class="td_mng">
							<?php echo $s_addr?>
							<a href="<?php echo $mod?>" class="board_copy btn btn_02">수정</a>
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
include_once ('../../admin.tail.php');