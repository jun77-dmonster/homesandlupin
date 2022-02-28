<?php
$sub_menu = '400100';
include_once('./_common.php');


auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '공지사항 상세보기';
include_once ('../admin.head.php');

$row = sql_fetch("select * from {$DM['NOTICE_TABLE']} where uid='{$uid}'");

echo "select * from {$DM['BF_TABLE']} where bd_id='notice' and uid='{$uid}'";

$file = sql_fetch("select * from {$DM['BF_TABLE']} where bd_id='notice' and uid='{$uid}'");

?>

<div class="box-view-wrap">

	<div class="box-cont">

		<table class="ncp_tbl">

			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th>지점구분</th>
				<td>
					<div class="inputbox-wrap">
						<select name="notice_gubun">
							<option value="B0000">지점전체</option>
							<?php
							for($i=0;$b1=sql_fetch_array($bsql);$i++){
							?>
							<option value="<?php echo $b1['branch_cd']?>" <?php echo ($b1['branch_cd']==$row['notice_gubun'])?"selected":""?>><?php echo $b1['branch_nm']?></option>
							<?php }?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th>말머리</th>
				<td>
					<div class="inputbox-wrap">
						<select name="notice_category">
							<option value="">말머리선택</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th>제목</th>
				<td>
					<input type="text" name="notice_title" class="frm_input frm_input_full" value="<?php echo $row['notice_title']?>">
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td>
					<div id="bo_v_con">
					<?php echo get_notice_thumbnail($row['notice_content']); ?>
					</div>
				</td>
			</tr>
			<tr>
				<th>첨부파일</th>
				<td>
					<input type="file" name="bf_file[]" class="frm_input">
					 <?php if($file['bf_file']) { ?>
					 <span class="checkbox_item marR10">
						<input type="checkbox" id="bf_file_del" name="bf_file_del[0]" value="1"> <label for="bf_file_del"><?php echo $file['bf_source'].'('.$file['bf_size'].')';  ?> 파일 삭제</label>
					 </span>
					 <?php } ?>
				</td>
			</tr>
			</tbody>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./notice_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
</div>	

<?
include_once ('../admin.tail.php');