<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<form name="frmDatalist" id="frmDatalist" action="./pop_branch_template_data_update.php" onsubmit="return frmDatalist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="uid" value="<?php echo $uid ?>">

<div class="contents type-3">

	<div class="inner-table-wrap type-2 scroll">

		<div class="table-tit-area2">

			<div class="btn-wrap-right marB20">

				<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>

			</div>

		</div><!--table-tit-area2-->

		<div class="content_item_bx">

			<div class="tbl_head01 tbl_wrap">

				<table>
				<caption><?php echo $g5['title']; ?> 목록</caption>
				<thead>
				<tr>
					<th>
						<label for="chkall" class="sound_only">게시판 전체</label>
						<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
					</th>
					<th>게임코드</th>
					<th>게임이름</th>
					<th>장르</th>
				</tr>
				</thead>
				<tbody>
				<?php
				for ($i=0; $row=sql_fetch_array($result); $i++) {
				$theme = explode("|",$row['games_theme']);
				?>
				<tr>
					<td class="td_chk">
						<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						<input type="hidden" name="data_cd[<?php echo $i ?>]" value="<?php echo $row['games_cd'] ?>" id="games_cd<?php echo $i ?>">
					</td>
					<td class="td_category"><?php echo $row['games_cd']?></td>
					<td class="td_category_large"><?php echo $row['games_nm']?></td>
					<td>
						<?php 
						for($j=0;$j<count($theme);$j++){
							echo get_code_name($theme[$j]);
							if(count($theme)>$j+1){
							echo " / ";
							}
						}
						?>
					</td>
				</tr>
				<?php
				}
				if ($i == 0)
					echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
				?>
				</tbody>
				</table>

				<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;uid='.$uid.'&amp;page='); ?>

			</div>

		</div>

	</div>

</div>

</form>