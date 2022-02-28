<?php
$sub_menu = '400300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$g5['title'] = '지점 추천게임 요청 상세보기';
include_once ('../admin.head.php');

$r1 = sql_fetch("select * from {$DM['GAME_REQUEST_TABLE']} where od_id='{$od_id}'");


$result = sql_query(" select * from {$DM['GAME_CART_TABLE']} as t1 join {$DM['BOARD_GAMES_TABLE']} as t2 on t1.games_cd=t2.games_cd where t1.od_id='{$od_id}'");

$colspan = 4;

?>



<div class="box-view-wrap">

	<div class="box-cont">

		<form name="requestView" id="requestView" action="./branch_games_request_view_update.php" onsubmit="return requestView_submit(this);" method="post">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="token" value="">
		<input type="hidden" name="od_id" value="<?php echo $od_id?>">
		
		<div class="table-tit-area">

			<span class="table-tit">요청 게임 현황 </span>

			<div class="btn-wrap-left">

				<!--<button type="button" class="crmBtn type-white" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']?>'">전체목록</button>-->
				<button type="submit" name="act_button" value="선택등록" onclick="document.pressed=this.value"  class="crmBtn type-white">선택등록</button>
				<?php if($r1['od_status']=="선택등록"){?>
				<button type="button" name="act_button" value="일괄등록" onclick="noAllConfirm()"  class="crmBtn type-white">일괄등록</button>
				<?php }else{?>
				<button type="submit" name="act_button" value="일괄등록" onclick="document.pressed=this.value"  class="crmBtn type-white">일괄등록</button>
				<?php }?>

			</div>

		</div><!--//table-tit-area-->
		
		<div class="tbl_head01 tbl_wrap marB30">

			<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<thead>
			<tr>
				<th scope="col">
					<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
				</th>
				<th>게임이미지</th>
				<th>게임명(코드)</th>
				<th>장르</th>
				<th>난이도</th>
				<th>추천인원</th>
				<th>상태</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$s_mod = "<a href='./games_request_view.php?od_id={$row['od_id']}' class='board_copy btn btn_03'>보기</a>";
				$games_dir = G5_DATA_URL.'/boardgames';
				$game_img = $games_dir."/".$row['games_img_file'];
				$theme = explode("|",$row['games_theme']);
				$game = get_game_info($row['games_cd']);
			?>
			<tr>
				<td class="td_chk">
					<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>" <?php echo ($row['ct_result']=="T")?"disabled":""?>>
					<input type="hidden" name="ct_id[<?php echo $i ?>]" value="<?php echo $row['ct_id'] ?>" id="ct_id<?php echo $i ?>">
					<input type="hidden" name="games_cd[<?php echo $i ?>]" value="<?php echo $row['games_cd'] ?>" id="games_cd<?php echo $i ?>">
					<input type="hidden" name="branch_cd[<?php echo $i ?>]" value="<?php echo $row['branch_cd'] ?>" id="branch_cd<?php echo $i ?>">
				</td>
				<td class="td_img3"><img src="<?php echo $game_img?>" style='width:80px;'></td>
				<td class="td_addr"><?php echo $game['games_nm']?> (<?php echo $row['games_cd']?>)</td>
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
				<td class="td_category"><?php echo get_code_name($row['games_level'])?></td>
				<td class="td_category"><?php echo $row['recommend_player_min_cnt']?>명 ~ <?php echo $row['recommend_player_max_cnt']?>명</td>
				<td class="td_mng">
					<?php echo $row['ct_status']?>
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

		</form>
		
		<form name="frmRequest" id="frmRequest" action="./branch_games_request_update.php" onsubmit="return frmRequest_submit(this);" method="post">
		<input type="hidden" name="od_id2" value="<?php echo $od_id?>">
		<table class="ncp_tbl" style='border-bottom:1px solid #ccc;'>
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>지점</th>
			<td><?php echo get_branch_name($r1['branch_cd'])?></td>
			<th>신청일자</th>
			<td><?php echo $r1['od_time']?></td>
		</tr>
		<tr>
			<th>요청사항</th>
			<td colspan="3">
				<div id="bo_v_con"><?php echo get_view_thumbnail($r1['od_memo']); ?></div>
			</td>
		</tr>
		<tr>
			<th>관리자답변</th>
			<td colspan="3">
				<textarea class="frm_input" name="od_admin_memo"><?php echo $r1['od_admin_memo']?></textarea>
			</td>
		</tr>
		</table>

		<div class="btn_fixed_top">
			<a href="./branch_games_request_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
			<input type="submit" id="btn_submit" value="저장" class="ftBtn type-red" accesskey="s">
		</div>

		</form>

	</div>
	

</div>


<script>
function requestView_submit(f){

	if(document.pressed == "선택등록") {
	
		if (!is_checked("chk[]")) {
			alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
			return false;
		}

	}

    if(document.pressed == "선택등록") {
        if(!confirm("선택한 게임을 수락 하시겠습니까?\n\n선택한 게임만 해당 지점에 등록이 되며 신청 현황은 개별 수정해야 합니다")) {
            return false;
        }
    }

	if(document.pressed == "일괄등록") {
        if(!confirm("모든 게임을 일괄수락 하시겠습니까?\n\n신청한 모든 게임이 해당 지점에 등록이 되며 신청 현황은 자동 수정됩니다 ")) {
            return false;
        }
    }

    return true;

}

function frmRequest_submit(f){

	return true;

}

function noAllConfirm(){

	alert("선택등록 한 경우 일괄 등록을 할 수 없습니다");

}
</script>

<?
include_once ('../admin.tail.php');