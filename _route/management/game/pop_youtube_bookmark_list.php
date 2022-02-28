<?php
$sub_menu = '200510';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$game_info = get_game_info($games_cd);

$g5['title'] = "게임 설명영상 책갈피";
include_once ('../../pop.admin.head.php');

$sql_common = " from {$DM['GAMES_YOUTUBE_TIMESTAMP_TABLE']} ";

$sql_search = " where games_cd='{$games_cd}' ";

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

$rows = 10;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan="7";

?>

<div class="layer-popup">

	<div class="type-800">

		<div class="view-title"><?php echo $game_info['games_nm']?> >  등록된 책갈피 : <?php echo $total_count;?> 건</div>

		<div class="content-bottom-wrap2">

			<form name="fYoutubeBookMarklist" id="fYoutubeBookMarklist" action="./pop_youtube_bookmark_list_update.php" onsubmit="return fYoutubeBookMarklist_submit(this);" method="post">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="token" value="">
			<input type="hidden" name="games_cd" value="<?php echo $games_cd ?>">

				<div class="contents type-3">

					<div class="inner-table-wrap type-2 scroll">

						<div class="table-tit-area2">

							<div class="btn-wrap-right marB20">
	
								<button type="button" class="crmBtn type-white" onclick="location.href='./pop_youtube_bookmark_preview.php?games_cd=<?php echo $games_cd?>'">책갈피 미리보기</button>
								<button type="button" class="crmBtn type-white" onclick="location.href='./pop_youtube_bookmark_write.php?games_cd=<?php echo $games_cd?>'">책갈피 등록</button>
								<button type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="crmBtn type-white">선택수정</button>
								<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>


							</div>

						</div><!--table-tit-area2-->

						<div class="content_item_bx">
							
							<div class="tbl_head01 tbl_wrap">

								<table>
								<caption><?php echo $g5['title']; ?> 목록</caption>
								<thead>
								<tr>
									<th scope="col">
										<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
									</th>
									<!--<th>썸네일</th>-->
									<th>제목</th>
									<th>책갈피</th>
									<th>사용유무</th>
									<th>게임세팅</th>
									<th>미리보기</th>
									<th>관리</th>
								</tr>
								</thead>
								<tbody>
								<?php
								for ($i=0; $row=sql_fetch_array($result); $i++) {
									$s_mod = "<a href='./pop_youtube_bookmark_write.php?games_cd={$row['games_cd']}&amp;w=u&amp;uid={$row['uid']}' class='board_copy btn btn_02'>수정</a>";
									$youtube_dir = G5_DATA_URL.'/youtubemark';
									$youtube_img = $youtube_dir."/".$row['youtube_img_thumb'];						

									$game_info = get_game_info($row['games_cd']);
								?>
								<tr>
									<td class="td_chk">
										<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
										<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid<?php echo $i ?>">
									</td>
									<!--<td class="td_img3"><img src="<?php echo $youtube_img?>" style='width:100px;'></td>-->
									<td class="td_addr"><?php echo $row['youtube_thumb_title']?></td>
									<td class="td_category"><?php echo $row['youtube_paly_min']?>:<?php echo $row['youtube_paly_sec']?></td>
									<td class="td_category">
										<select name="display_fl[<?php echo $i?>]">
											<option value="T" <?php echo ($row['display_fl']=="T")?"selected":""?>>사용</option>
											<option value="F" <?php echo ($row['display_fl']=="F")?"selected":""?>>미사용</option>
										</select>
									</td>
									<td class="td_category">
										<select name="youtube_setting_fl[<?php echo $i?>]">
											<option value="T" <?php echo ($row['youtube_setting_fl']=="T")?"selected":""?>>적용</option>
											<option value="F" <?php echo ($row['youtube_setting_fl']=="F")?"selected":""?>>미적용</option>
										</select>
									</td>
									<td class="td_category">
										<?php
										$time = ($row['youtube_paly_min']*60)+$row['youtube_paly_sec'];
										$url = $game_info['games_youtube']."&t=".$time."s";

										echo "<a href='".$url."' target='_blank'><img src='".G5_ROUTE_URL."/img/youtube_icon.png' style='width:30px;'></a>";
										?>
									</td>
									<td class="td_mng"><?php echo $s_mod?></td>
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

				<!--페이징-->


			</form>

			

		</div>
		
	</div>

</div>

<script>
function fYoutubeBookMarklist_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 책갈피를 정말 삭제시키겠습니까?")) {
            return false;
        }
    }

    return true;

}
</script>

<?
include_once ('../../pop.admin.tail.php');