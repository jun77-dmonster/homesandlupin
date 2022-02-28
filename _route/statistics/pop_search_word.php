<?php
$sub_menu = '900100';
include_once('./_common.php');

$g5['title'] = "검색 테스트";
include_once ('../pop.admin.head.php');

if($stx){
	
	
	$c1 = sql_fetch("select count(*) as cnt from {$DM['SEARCHWORD_TABLE']} where search_word='".trim($stx)."' and branch_cd='$branch_cd' and room_cd='{$room_cd}' and date_format(search_reg_dt,'%Y-%m-%d')='".G5_TIME_YMD."'");

	if($c1['cnt']==0){
	
		$sql = "insert into {$DM['SEARCHWORD_TABLE']} 
					set search_word		=	'{$stx}',
						branch_cd		=	'{$branch_cd}',
						room_cd			=	'{$room_cd}',
						search_reg_dt	=	'".G5_TIME_YMDHIS."'";

		echo $sql;

		sql_query($sql);

	}else{
	
		$sql = "update {$DM['SEARCHWORD_TABLE']} 
					set cnt	= cnt+1
					where branch_cd='{$branch_cd}' and room_cd='{$room_cd}' and search_word='{$stx}' and date_format(search_reg_dt,'%Y-%m-%d')='".G5_TIME_YMD."'";

		sql_query($sql);

	}

}

///지점
$bsql = sql_query("select * from {$DM['BRANCH_TABLE']} where branch_withdrawal_fl='F'");

$rsql = sql_query("select * from {$DM['BRANCH_ROOM_TABLE']} where branch_cd='B9168'");
?>

<div class="layer-popup">
	
	<div class="wrapper type-1200">
		
		<div class="container-wrap">

			<form id="searchForm" name="fsearch" method="get">

				<div class="box-view-wrap">

					<div class="view-title"><?php echo $subject['theme_nm']?> 검색 테스트 </div>

					<div class="box-cont type-3">

						<table class="ncp_tbl">

							<colgroup>
							<col style="width:200px;">
							<col style="width:auto;">
							<col style="width:140px;">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row">지점</th>
									<td>
										<div class="inputbox-wrap">
										<select name="branch_cd" style="width:200px;">
											<?php
											for($i=0;$b1=sql_fetch_array($bsql);$i++){
											?>
											<option value="<?php echo $b1['branch_cd']?>" <?php echo ($b1['branch_cd']==$row['branch_cd'])?"selected":""?>><?php echo $b1['branch_nm']?></option>
											<?php }?>
										</select>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">룸번호</th>
									<td>
										<div class="inputbox-wrap">
										<select name="room_cd" style="width:200px;">
											<?php
											for($i=0;$r1=sql_fetch_array($rsql);$i++){
											?>
											<option value="<?php echo $r1['room_cd']?>" <?php echo ($r1['room_cd']==$row['room_cd'])?"selected":""?>>룸<?php echo $r1['room_no']?></option>
											<?php }?>
										</select>
										</div>
									</td>
								</tr>
								<tr>
									<th scope="row">검색어</th>
									<td>
										<div class="inputbox-wrap">
											<input type="text" name="stx" class="frm_input" value="<?php echo $stx?>" style='width:400px'>
										</div>
									</td>
									<td rowspan="2" class="search_btn_wrap">
										<div class="search_btn_box" style="text-align:center;">
											<button type="submit" class="tbBtn type-red">검색</button>
										</div>
									</td>
								</tr>
							</tbody>

						</table>


						<!--페이징-->

					</div>

				</div>

			</form>

		</div>

	</div>

</div>

<?
include_once ('../pop.admin.tail.php');