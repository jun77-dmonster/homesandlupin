<?php
$sub_menu = '100000';
include_once('./_common.php');

@include_once('./safe_check.php');
if(function_exists('social_log_file_delete')){
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');

$r1 = sql_query("select * from {$DM['VOICE_CUSTOMER_TABLE']} order by customer_reg_dt desc limit 0, 5 ");
$colspan = "3";

$r2 = sql_query("select * from {$DM['QNA_TABLE']} order by reg_dt desc limit 0, 5 ");
?>

<div style="padding:20px;">
	
<div id="index_right">
	
	<div class="title_wrap">
		<span class="table-tit">고객의 소리</span>

		<div class="btn-wrap-left" style='width:calc(88% - 0px);'>
			<button type="button" class="crmBtn type-white" onclick="location.href='./management/voice_customer_list.php'">더보기</button>
		</div>
	</div>

	<div class="content_wrap">

		<table class="ncp_tbl marT15">
		<thead>
		<tr>
			<th>지점</th>
			<th>내용</th>
			<th>등록일자</th>
		</tr>
		</thead>
		<tbody>
		<?php
			for ($i=0; $row=sql_fetch_array($r1); $i++) {
		?>
		<tr>
			<td class="td_category"><?php echo get_branch_name($row['branch_cd'])?></td>
			<td class="td_addr"><a href="#"><?php echo conv_subject($row['customer_content'],50,'...')?></a></td>
			<td class="td_datetime"><?php echo substr($row['customer_reg_dt'],0,10)?></td>
		</tr>
		<?
		}
		if ($i == 0)
		echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">등록된 고객의 소리가 없습니다</td></tr>";

		?>
		</tbody>
		</table>

	</div>
	
	<div class="title_wrap marT20">
		<span class="table-tit">지점 문의</span>

		<div class="btn-wrap-left" style='width:calc(100% - 80px);'>
			<button type="button" class="crmBtn type-white" onclick="location.href='./business/branch_questions_list.php'">더보기</button>
		</div>
	</div>

	<div class="content_wrap">

		<table class="ncp_tbl marT15">
		<thead>
		
		<tr>
			<th>지점</th>
			<th>제목</th>
			<th>등록일자</th>
			<th>답변</th>
		</tr>
		</thead>
		<tbody>
		<?php
			for ($i=0; $row=sql_fetch_array($r2); $i++) {

			switch($row['qna_status']){
				case "Q" : $txt = "접수"; break;
				case "C" : $txt = "답변대기"; break;
				case "A" : $txt = "답변완료"; break;
			}
		?>
		<tr>
			<td class="td_category"><?php echo get_branch_name($row['branch_cd'])?></td>
			<td class="td_addr"><a href="./business/branch_questions_view.php?uid=<?php echo $row['uid']?>"><?php echo $row['qna_subject']?></a></td>
			<td class="td_datetime"><?php echo substr($row['reg_dt'],0,10)?></td>
			<td class="td_mng"><?php echo $txt?></td>
		</tr>
		<?
		}
		if ($i == 0)
		echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">등록된 고객의 소리가 없습니다</td></tr>";

		?>
		</tbody>
		</table>

	</div>

</div>


<?php
include_once ('./admin.tail.php');