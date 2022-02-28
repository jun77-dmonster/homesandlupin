<?php
$sub_menu = '200200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$DM['FAQ_TABLE']} ";

$sql_search = " where (1) and delete_fl='F' ";

if (!$sst) {
    $sst = "display_order";
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

$g5['title'] = "FAQ 정렬";
include_once ('../pop.admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 5;
?>

<form name="faqOrderlist" id="faqOrderlist" action="./pop_faq_order_list_update.php" onsubmit="return questions_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="layer-popup">

	<div class="wrapper type-1200">

		<div class="container-wrap">

			<div class="box-view-wrap2">	


				<div style='width:1130px; padding:20px; margin:0 auto;'>
					
					<div class="table-tit-area" style='border-bottom:1px solid #ccc;'>

						<span class="table-tit">FAQ 정렬 </span>

						<div class="btn-wrap-right">

							<button type="submit" name="act_button" value="저장" onclick="document.pressed=this.value" class="crmBtn type-white">저장</button>
							<button type="button" name="act_button" id="topup"  class="crmBtn type-white">맨위로</button>
							<button type="button" name="act_button" id="up"  class="crmBtn type-white">위로</button>
							<button type="button" name="act_button" id="down"  class="crmBtn type-white">아래로</button>
							<button type="button" name="act_button" id="lastdown"  class="crmBtn type-white">맨아래로</button>

						</div><!--//btn-wrap-left-->

					</div><!--//table-tit-area-->
					
					<!--
					<div class="view-title" style='border-bottom:1px solid #ccc;'>FAQ 정렬</div>

					<div align="right" style="margin-right: 20px">
						<input type="button" id="up" value="△">
						<input type="button" id="down" value="▽">
					</div>
					-->

					<div class="content-bottom-wrap2">

						<div class="contents type-3">

							<div class="inner-table-wrap type-2 scroll">

								<div class="tbl_head01 tbl_wrap">

									<table>
									<caption><?php echo $g5['title']; ?> 목록</caption>
									<thead>
									<tr id="header">
										<th scope="col">
											<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
										</th>
										<th>정렬순서</th>
										<th>지점</th>
										<th>카테고리</th>
										<th>제목</th>
										<!--<th>관리</th>-->
									</tr>
									</thead>
									<tbody>
									<?php
									for ($i=0; $row=sql_fetch_array($result); $i++) {
									?>
									<tr>
										<td class="td_chk">
											<input type="checkbox" name="id">
										</td>
										<td class="td_num">
											<input type="text" name="display_order" value="<?php echo $i?>" class="frm_input">
										</td>
										<td class="td_category"><?php echo ($row['branch_cd']=="B0000")?"전체지점":get_branch_name($row['branch_cd'])?></td>
										<td class="td_category"><?php echo get_code_name($row['category_cd'])?></td>
										<td class="td_addr"><?php echo $row['subject']?></td>
										<!--
										<td class="td_mng_l">
											
											<button type="button" class="crmBtn type-white" onclick="moveUp(this)">위로</button>
											<button type="button" class="crmBtn type-white" onclick="moveDown(this)">아래로</button>
											
										</td>
										-->
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

</div>


<script type="text/javascript">
$(document).ready(function() {
	
	changNum();
	
	$('#down').click(function(){
		var checkedCount = $("input[name=id]:checked").length;
		if (checkedCount > 1 ) {
			alert("이동하려는 행을 하나만 선택해주세요")
		} 
		else if(checkedCount == 0) {
			alert("이동 하려는 행을 선택해주세요")
		}
		else {
			var element = $("input[name=id]:checked").parent().parent();
			moveRowDown(element)
		}
	});
	
	$('#up').click(function(){
		var checkedCount = $("input[name=id]:checked").length;
		if (checkedCount > 1 ) {
			alert("이동하려는 행을 하나만 선택해주세요")
		} 
		else if(checkedCount == 0) {
			alert("이동하려는 행을 선택해주세요")
		}
		else {
			var element = $("input[name=id]:checked").parent().parent();
			moveRowUp(element)
		}
	});

	$('#topup').click(function(){
		var checkedCount = $("input[name=id]:checked").length;
		if (checkedCount > 1 ) {
			alert("이동하려는 행을 하나만 선택해주세요")
		} 
		else if(checkedCount == 0) {
			alert("이동하려는 행을 선택해주세요")
		}
		else {
			var element = $("input[name=id]:checked").parent().parent();
			moveTop(element);
		}
	});

});

var moveRowUp = function(element) {
	if( element.prev().html() != null  && element.prev().attr("id") != "header"){
		element.insertBefore(element.prev());
		changNum();
	} else {
		alert("최상단입니다.")
	}
};

var moveRowDown = function(element) {
	if( element.next().html() != null ){
		element.insertAfter(element.next());
		changNum();
	}  else {
		alert("최하단입니다.")
	}
};

var changNum = function() {
	var num = 0;
	$('input[name=display_order]').each(function(){
		num++;
		$(this).val(num);
	});
};

var moveTop= function(element) {

	alert(element.closest("tr"));

};

/*
function moveTop(el) {
	//var $tr = $(el).closest("tr");
	//$tr.closest("table").find("tr:first").before($tr);
}
*/

function moveBottom(el) {
	var $tr = $(el).closest("tr");
	$tr.closest("table").find("tr:last").after($tr);
  }
</script>
  </body>
<?
include_once ('../pop.admin.tail.php');