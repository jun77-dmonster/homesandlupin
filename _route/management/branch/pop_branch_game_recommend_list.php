<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$branch_info = get_branch_info($branch_cd);

$g5['title'] = "{$branch_info['branch_nm']} 게임 관리";
include_once ('../../pop.admin.head.php');

$sql_common = " from {$DM['RECOMMEND_GAME_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd  ";

$sql_search = " where t1.branch_cd='{$branch_info['branch_cd']}' ";

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
    $sst = "t1.uid";
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
				
				<div class="view-title"><?php echo $branch_info['branch_nm']?> 등록된 추천 게임 : <?php echo $total_count;?> 건</div>

				
				<div class="content-bottom-wrap2">

				<form name="fPopBranchGamelist" id="fPopBranchGamelist" action="./pop_branch_game_recommend_list_update.php" onsubmit="return fPopBranchGamelist_submit(this);" method="post">
				<input type="hidden" name="sst" value="<?php echo $sst ?>">
				<input type="hidden" name="sod" value="<?php echo $sod ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<input type="hidden" name="token" value="">
				<input type="hidden" name="branch_cd" value="<?php echo $branch_cd ?>">

					<div class="contents type-3">

						<div class="inner-table-wrap type-2 scroll">

							<div class="table-tit-area2">

								<div class="btn-wrap-right marB20">

									
									<button type="button" class="crmBtn type-white" onclick="location.href='./pop_branch_games_recommend_register.php?branch_cd=<?php echo $branch_cd?>'">추천 게임 등록</button>
									<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>

								</div>

							</div><!--//table-tit-area-->
							
							<div class="tbl_head01 tbl_wrap">

								<table>
								<caption><?php echo $g5['title']; ?> 목록</caption>
								<thead>
								<tr>
									<th class="td_chk">
										<label for="chkall" class="sound_only">게시판 전체</label>
										<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
									</th>
									<th>게임코드</th>
									<th>게임이름</th>
									<th>장르</th>
									<th>유튜브영상</th>
									<!--<th>책갈피</th>-->
									<th>해시태그</th>
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
										<input type="hidden" name="games_cd[<?php echo $i ?>]" value="<?php echo $row['games_cd'] ?>" id="games_cd<?php echo $i ?>">
										<input type="hidden" name="games_nm[<?php echo $i ?>]" value="<?php echo $row['games_nm'] ?>" id="games_nm<?php echo $i ?>">
									</td>
									<td class="td_auth"><?php echo $row['games_cd']?></td>
									<td class="td_category_large"><?php echo $row['games_nm']?></td>
									<td class="td_category_large">
										<?php 
										for($j=0;$j<count($theme);$j++){
											echo get_code_name($theme[$j]);
											if(count($theme)>$j+1){
											echo " / ";
											}
										}
										?>
									</td>
									<td class="td_category">
										<?php if($row['games_youtube']){
											echo "<a href='".$row['games_youtube']."' target='_blank'><img src='".G5_ROUTE_URL."/img/youtube_icon.png' style='width:30px;'></a>";
										}
										?>
									</td>
									<!--
									<td class="td_category">
										<?php if($row['games_youtube']){?>
										<button type="button" class="crmBtn type-white" onclick="displayYoutube('<?php echo $row['games_cd']?>')">책갈피</button>
										<?php }else{?>
										<button type="button" class="crmBtn type-white" onclick="NoYoutube()">책갈피</button>
										<?php }?>
									</td>
									-->
									<td><?php echo $row['games_hash_tag']?></td>
								</tr>
								<?php
								}
								if ($i == 0)
									echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
								?>
								</tbody>
								</table>

							</div>

							<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>


						</div>

					</div>

				</form>

				</div>


			</div>

		</div>

	</div>

</div>

<script>
function fPopBranchGamelist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

	
	if(document.pressed == "선택삭제") {
        if(!confirm("선택한 게임을 정말 <?php echo $branch_info['branch_nm'];?> 지점에서 삭제 시키겠습니까?")) {
            return false;
        }
    }

	return true;

}
</script>

<?
include_once ('../../pop.admin.tail.php');