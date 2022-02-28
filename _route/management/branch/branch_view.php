<?php
$sub_menu = '200510';
include_once('./_common.php');

$branch_info = get_branch_info($branch_cd);

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = $branch_info['branch_nm'].' 지점 상세보기';
include_once ('../../admin.head.php');

$row = sql_fetch(" select t1.*, t2.* from {$DM['BRANCH_TABLE']} as t1 left join {$DM['BASE_GUIDE_TABLE']} as t2 on t1.branch_cd=t2.branch_cd where t1.branch_cd='{$branch_cd}' and t2.guide_use_fl='T' and t2.guide_delete_fl='F' ");
?>

<div class="box-view-wrap">

	<div class="view-title">
		지점 기본 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>지점코드</th>
			<td><?php echo $branch_cd?></td>
			<th>지점이름</th>
			<td><?php echo $row['branch_nm']?></td>
		</tr>
		<tr>
			<th>지점아이디</th>
			<td><?php echo $row['branch_manager_id']?></td>
			<th>지점장 이름</th>
			<td><?php echo $row['branch_manager_nm']?></td>
		</tr>
		<tr>
			<th>지점 연락처</th>
			<td><?php echo $row['branch_phone']?></td>
			<th>지점 주소</th>
			<td>우)<?php echo $row['branch_addr_zip']?> <?php echo $row['branch_addr_basic']?> <?php echo $row['branch_addr_detail']?> </td>
		</tr>
		</table>

	</div>

</div>

<?
$r1 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='{$branch_cd}' and room_delete_fl='F'");
?>

<div class="box-view-wrap">

	<div class="view-title">
		지점 룸 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tr>
			<th>생성된 룸</th>
			<td>
				<?php echo $r1['cnt']?>개
				<button type="button" class="crmBtn type-white" onclick="displayBranchRoom('<?php echo $row['branch_cd']?>')">룸 정보 확인 </button>
			</td>
		</tr>
		</table>

	</div>

</div>

<?
$r2 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_GAEMS_TABLE']} where branch_cd='{$branch_cd}'");
?>

<div class="box-view-wrap">

	<div class="view-title">
		지점 등록된 게임
	</div>

	<div class="box-cont">

		
			<table class="ncp_tbl">
			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tr>
				<th>등록된 게임</th>
				<td>
					<?php echo $r2['cnt']?>개
					<button type="button" class="crmBtn type-white" onclick="displayGame('<?php echo $row['branch_cd']?>')">등록 게임 확인 </button>
				</td>
			</tr>
			<tr>
				<th>추천 게임</th>
				<td>
					
				</td>
			</tr>
			<tr>
				<th>게임 일괄 등록</th>
				<td>
					<button type="button" class="crmBtn type-white" onclick="displayGame('<?php echo $row['branch_cd']?>')">게임 엑셀 일괄 등록 </button>
				</td>
			</tr>
			<tr>
				<th>지점 게임 복사</th>
				<td>
					<button type="button" class="crmBtn type-white" onclick="displayGame('<?php echo $row['branch_cd']?>')">타지점 게임 복사 </button>
				</td>
			</tr>
			</table>

		
	</div>

</div>

<?
$r3 = sql_fetch("select count(*) as cnt from {$DM['BRANCH_BEVERAGE_TABLE']} where branch_cd='{$branch_cd}'");
?>

<div class="box-view-wrap">

	<div class="view-title">
		지점 식음료 정보
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tr>
				<th>등록된 식음료</th>
				<td>
					<?php echo $r3['cnt']?>개
					<button type="button" class="crmBtn type-white" onclick="displayBeverage('<?php echo $row['branch_cd']?>')">등록 식음료 확인 </button>
				</td>
			</tr>
		</table>

	</div>

</div>

<?
$r4 = sql_fetch("select count(*) as cnt from {$DM['VOICE_CUSTOMER_TABLE']} where branch_cd='{$branch_cd}'");
?>

<div class="box-view-wrap">

	<div class="view-title">
		지점 고객의 소리
	</div>

	<div class="box-cont">

		<table class="ncp_tbl">
			<colgroup>
				<col style='width:200px;'>
				<col>
			</colgroup>
			<tr>
				<th>등록된 고객의 소리</th>
				<td>
					<?php echo $r4['cnt']?> 건
					<button type="button" class="crmBtn type-white" onclick="displayCustomer('<?php echo $row['branch_cd']?>')">등록 고객의 소리 확인 </button>
				</td>
			</tr>
		</table>

	</div>

</div>

<div class="btn_fixed_top">
    <a href="./branch_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
</div>

<script>
function displayBranchRoom(branch_cd){

	var _width	= '1400';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_branch_room_list.php?branch_cd="+branch_cd;

	var new_win = window.open(href, "branch_room_list", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}

function displayGame(branch_cd){

	var _width	= '1400';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_branch_game_list.php?branch_cd="+branch_cd;

	var new_win = window.open(href, "branch_room_list", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}

function displayBeverage(branch_cd){

	var _width	= '1400';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_beverage_list.php?branch_cd="+branch_cd;

	var new_win = window.open(href, "pop_beverage_list", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}

function displayCustomer(branch_cd){

	var _width	= '1400';
    var _height = '800';
 
    // 팝업을 가운데 위치시키기 위해 아래와 같이 값 구하기
    var _left = Math.ceil(( window.screen.width - _width )/2);
    var _top = Math.ceil(( window.screen.height - _height )/2); 

	href="./pop_beverage_customer_list.php?branch_cd="+branch_cd;

	var new_win = window.open(href, "pop_beverage_list", "left="+_left+",top="+_top+",width="+_width+", height="+_height+", scrollbars=1");
    new_win.focus();

}
</script>
<?
include_once ('../../admin.tail.php');