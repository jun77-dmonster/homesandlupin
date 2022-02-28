<?php
$sub_menu = '100210';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '운영자 권한 관리';
include_once ('../admin.head.php');

$sql_common = " from {$DM['MANAGER_AUTH_TABLE']} a join {$DM['MANAGER_TABLE']} b on (a.manager_id=b.manager_id) ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.au_menu";
    $sod = "";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";

$result = sql_query($sql);

$colspan = 5;
?>

<div class="box-view-wrap">

	<div class="search_box search_field">
		
		<form name="fsearch" id="fsearch">
		<input type="hidden" name="sfl" value="a.manager_id" id="sfl">	
			<table class="ncp_tbl" style='margin-top:15px; margin-bottom:15px;'>
			
				<colgroup>
					<col style='width:120px;'>
					<col>
					<col style='width:140px;'>
				</colgroup>
				<tbody>
				<tr>
					<th scope="row">회원검색</th>
					<td><input type="text" name="stx" value="<?php echo $stx?>" class="frm_input frm_input_sfull"></td>
					<td class="search_btn_wrap">
						<div class="search_btn_box">
							
							<button type="submit" class="tbBtn type-red">검색</button>

						</div>
					</td>
				</tr>
				</tbody>

			</table>

		</form>

	</div><!--//search_box search_field-->

</div>

<div class="box-view-wrap">

	<div class="mall-products-view">
		
		<div class="mall-orders-view">

			<div class="table-tit-area">

				<span class="table-tit">설정된 관리권한 <span class="num">0</span> 명</span>

				<div class="btn-wrap-left">

					<button type="button" class="crmBtn type-white">전체목록</button>
					<button type="button" class="crmBtn type-white">선택삭제</button>

				</div><!--//btn-wrap-left-->

			</div><!--//table-tit-area-->

			<div class="content_item_bx">

				<div class="tbl_head01 tbl_wrap">

					<table>
					<caption><?php echo $g5['title']; ?> 목록</caption>
					<thead>
					<tr>
						<th scope="col"><input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></th>
						<th scope="col">회원아이디</th>
						<th scope="col">닉네임</th>
						<th scope="col">메뉴</th>
						<th scope="col">권한</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$count = 0;
					for ($i=0; $row=sql_fetch_array($result); $i++)
					{
						$is_continue = false;
						// 회원아이디가 없는 메뉴는 삭제함
						if($row['manager_id'] == '') {
							sql_query(" delete from {$DM['MANAGER_AUTH_TABLE']} where au_menu = '{$row['au_menu']}' ");
							$is_continue = true;
						}

						// 메뉴번호가 바뀌는 경우에 현재 없는 저장된 메뉴는 삭제함
						if (!isset($auth_menu[$row['au_menu']]))
						{
							sql_query(" delete from {$DM['MANAGER_AUTH_TABLE']} where au_menu = '{$row['au_menu']}' ");
							$is_continue = true;
						}

						if($is_continue)
							continue;

						$manager = get_manager($row['manager_id']);

						$bg = 'bg'.($i%2);
					?>
					<tr class="<?php echo $bg; ?>">
						<td class="td_chk">
							<input type="hidden" name="au_menu[<?php echo $i ?>]" value="<?php echo $row['au_menu'] ?>">
							<input type="hidden" name="manager_id[<?php echo $i ?>]" value="<?php echo $row['manager_id'] ?>">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						</td>
						<td class="td_mbid"><a href="?sfl=a.manager_id&amp;stx=<?php echo $row['manager_id'] ?>"><?php echo $row['manager_id'] ?></a></td>
						<td class="td_auth_mbnick"><?php echo $manager['manager_nick_nm']?></td>
						<td>
							<?php echo $row['au_menu'] ?>
							<?php echo $auth_menu[$row['au_menu']] ?>
						</td>
						<td class="td_mng_l"><?php echo $row['au_auth'] ?></td>
					</tr>
					<?php
						$count++;
					}

					if ($count == 0)
						echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
					?>
					</tbody>
					</table>

				</div>

			</div><!--//content_item_bx-->

		</div><!--//mall-orders-view-->

	</div>

<?php
//if (isset($stx))
//    echo '<script>document.fsearch.sfl.value = "'.$sfl.'";</script>'."\n";

if (strstr($sfl, 'manager_id'))
    $manager_id = $stx;
else
    $manager_id = '';
?>
</div><!--//box-view-wrap-->

<form name="fauthlist2" id="fauthlist2" action="./management_admin_permission_update.php" method="post" autocomplete="off" onsubmit="return fauth_add_submit(this);">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="box-view-wrap">
	
	<div class="view-title">
		관리 권한 추가
	</div>

	<div class="box-cont">

		<div class="local_desc01 local_desc">
			
			 <p>
				다음 양식에서 회원에게 관리권한을 부여하실 수 있습니다.<br>
				권한 <strong>r</strong>은 읽기권한, <strong>w</strong>는 쓰기권한, <strong>d</strong>는 삭제권한입니다.
			</p>

		</div><!--local_desc01 local_desc-->

		<table class="ncp_tbl">
			
		<colgroup>
			<col style='width:200px;'>
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="manager_id">회원아이디</label></th>
			<td>
				<input type="text" name="manager_id" value="<?php echo $manager_id ?>" id="manager_id" required class="required frm_input">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="au_menu">접근가능메뉴</label></th>
			<td>
				<select id="au_menu" name="au_menu" required class="required">
					<option value=''>선택하세요</option>
                    <?php
                    foreach($auth_menu as $key=>$value)
                    {
                        if (!(substr($key, -3) == '000' || $key == '-' || !$key))
                            echo '<option value="'.$key.'">'.$key.' '.$value.'</option>';
                    }
                    ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">권한지정</th>
			<td>
				<input type="checkbox" name="r" value="r" id="r" checked>
                <label for="r">r (읽기)</label>
                <input type="checkbox" name="w" value="w" id="w">
                <label for="w">w (쓰기)</label>
                <input type="checkbox" name="d" value="d" id="d">
                <label for="d">d (삭제)</label>
			</td>
		</tr>
		<tr>
			<th scope="row">자동등록방지</th>
			<td>
				<?php
                include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
                $captcha_html = captcha_html();
                $captcha_js   = chk_captcha_js();
                echo $captcha_html;
                ?>
			</td>
		</tr>
		</tbody>
		</table>

		<div class="btn_confirm01 btn_confirm">
			<input type="submit" value="추가" class="btn_submit btn">
		</div>

	</div>

</div>
</form>

<script>
function fauth_add_submit(f){
    
    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    return true;
}

function fauthlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?
include_once ('../admin.tail.php');