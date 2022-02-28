<?php
$sub_menu = '1000100';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, 'r');

$branch_info = get_branch_info($branch['branch_cd']);

$g5['title'] = "{$branch_info['branch_nm']} 본사 문의";
include_once ('./pop.admin.head.php');

$categories = explode('|', $route['sc_qna_category']); // 구분자가 , 로 되어 있음

?>

<form name="fqna" id="fqna" action="./pop_qna_write_update.php" onsubmit="return fqnachk(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="code" value="<?php echo $code ?>">
<input type="hidden" name="goods_cd" value="<?php echo $goods_cd ?>">
<div class="layer-popup">

	<div class="wrapper type-800">

		<div class="container-wrap">

			<div class="box-view-wrap">	

				<div class="view-title"><?php echo $branch_info['branch_nm']?> 문의하기 </div>

			</div>

			<div class="content-bottom-wrap2">

			

				<div class="box-cont type-3">

					<table class="ncp_tbl" style='margin:50px 0 20px 0;'>
					<colgroup>
						<col style='width:120px;'>
						<col>
					</colgroup>
					<tr>
						<th>문의 구분</th>
						<td>
							<div class="inputbox-wrap">
							<?php echo array_search($code,$branch_gubun);?>
							</div>
						</td>
					</tr>
					<tr>
						<th>말머리</th>
						<td>
							<div class="inputbox-wrap">
							<select name="qna_category">
							<?php for($i=0;$i<count($categories);$i++){?>
							<option value="<?php echo $categories[$i]?>"><?php echo $categories[$i]?></option>
							<?php }?>
							</select>
							</div>
						</td>
					</tr>
					<?php if($code=="P1005" || $code=="P1006"){
						if($code=="P1005"){
							$goods = sql_fetch("select * from {$DM['BOARD_GAMES_TABLE']} where games_cd='{$goods_cd}'");
							$goods_dir = G5_DATA_URL.'/boardgames';
							$goods_img = $goods_dir."/".$goods['games_img_file'];
							$goods_title = $goods['games_nm'];
						}else{
							$goods = sql_fetch("select * from {$DM['BEVERAGE_TABLE']} where beverage_cd='{$goods_cd}'");
							$goods_dir = G5_DATA_URL.'/beverage';
							$goods_img = $goods_dir."/".$goods['beverage_file'];
							$goods_title = $goods['beverage_kor_nm'];
						}
					?>
					<tr>
						<th>상품</th>
						<td>
							<img src="<?php echo $goods_img?>" style='width:100px;'>
							<span><?php echo $goods_title?> (코드 : <?php echo $goods_cd?>)</span>
						</td>
					</tr>
					<?php }?>
					<tr>
						<th>제목</th>
						<td>
							<input type="text" name="qna_subject" class="frm_input frm_input_full">
						</td>
					</tr>
					<tr>
						<th>내용</th>
						<td><?php echo editor_html('qna_content', get_text(html_purifier($row['qna_content']), 0)); ?></td>
					</tr>
					<tr>
						<th>파일첨부</th>
						<td><input type="file" name="bf_file[]" class="frm_input"></td>
					</tr>
					</table>

				</div>

				

			</div>
			

		</div>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="#" onclick="window.close()" class="btn btn_02">닫기</a>
	<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
</div>

</form>

<script>
function fqnachk(f){

	<?php echo get_editor_js('qna_content'); ?>

	document.getElementById("btn_submit").disabled = "disabled";
	
	return true;

}
</script>
<?
include_once ('./pop.admin.tail.php');