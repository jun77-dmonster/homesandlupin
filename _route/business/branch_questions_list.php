<?php
$sub_menu = '400200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '지점 문의하기';
include_once ('../admin.head.php');

$sql_common = " from {$DM['QNA_TABLE']} ";

$sql_search = " where (1) and display_fl='T' and delete_fl='F' ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'qna_subject' :
        case 'qna_content' :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
		case 'branch_cd' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "uid";
    $sod = "desc";
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

$colspan="8";
?>

<form name="questionslist" id="questionslist" action="./branch_questions_list_update.php" onsubmit="return questions_submit(this);" method="post">
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

				<span class="table-tit">등록된 문의사항 총 <span class="num"><?php echo $total_count ?></span> 건</span>

				<div class="btn-wrap-left">

					<!--<button type="button" class="crmBtn type-white" onclick="location.href='./branch_questions_register.php'">테스트등록</button>-->
					<button type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="crmBtn type-white">선택삭제</button>

				</div><!--//btn-wrap-left-->

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th scope="col">
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th>지점</th>
						<th>문의구분</th>
						<th>상품</th>
						<th>제목</th>
						<th>문의상태</th>
						<th>조회수</th>
						<th>작성일</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$s_mod = '<a href="./branch_questions_view.php?'.$qstr.'&amp;uid='.$row['uid'].'" class="btn btn_03">상세보기</a>';

						switch($row['qna_status']){
						
							case "Q" : $txt = "접수"; break;
							case "C" : $txt = "답변대기"; break;
							case "A" : $txt = "답변완료"; break;

						}

						$qna_gubun = array_search($row['qna_gubun'],$branch_gubun);
					?>
					<tr>
						<td class="td_chk">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
							<input type="hidden" name="uid[<?php echo $i ?>]" value="<?php echo $row['uid'] ?>" id="uid_<?php echo $i ?>">
						</td>
						<td class="td_category"><?php echo ($row['branch_cd']=="B0000")?"전체지점":get_branch_name($row['branch_cd'])?></td>
						<td class="td_category"><?php echo $qna_gubun?></td>
						<td class="td_img3">
						<?php 
							if($row['qna_gubun']==$DM['QNA_CODE5']){
								$goods = sql_fetch("select * from {$DM['BOARD_GAMES_TABLE']} where games_cd='{$row['goods_cd']}'");
								$goods_dir = G5_DATA_URL.'/boardgames';
								$goods_img = $goods_dir."/".$goods['games_img_file'];
								$goods_title = $goods['games_nm'];
						?>
							<?php if($goods['games_img_file']){?>
							<img src="<?php echo $goods_img?>" style='width:100px;'><br>
							<span><?php echo $goods_title?><br> (코드 : <?php echo $row['goods_cd']?>)</span>
							<?php }?>
						<?	}else{
								$goods = sql_fetch("select * from {$DM['BEVERAGE_TABLE']} where beverage_cd='{$row['goods_cd']}'");
								$goods_dir = G5_DATA_URL.'/beverage';
								$goods_img = $goods_dir."/".$goods['beverage_file'];
								$goods_title = $goods['beverage_kor_nm'];
						?>
							<?php if($goods['beverage_file']){?>
							<img src="<?php echo $goods_img?>" style='width:100px;'><br>
							<span><?php echo $goods_title?><br> (코드 : <?php echo $row['goods_cd']?>)</span>
							<?php }?>
						<?	} ?>
						</td>
						<td class="td_addr"><?php echo $row['qna_subject']?></td>
						<td class="td_cnt"><?php echo $txt?></td>
						<td class="td_cnt"><?php echo $row['hit_cnt']?></td>
						<td class="td_datetime"><?php echo $row['reg_dt']?></td>
						<td class="td_mng"><?php echo $s_mod;?></td>
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
function questions_submit(f){

	if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 공지사항을 정말 삭제시키겠습니까?")) {
            return false;
        }
    }

    return true;

}
</script>
<?
include_once ('../admin.tail.php');