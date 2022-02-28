<?php
$sub_menu = '100200';
include_once('./_common.php');
include_once(G5_LIB_PATH."/register.lib.php");

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$manager_id = isset($_POST['manager_id']) ? strip_tags(clean_xss_attributes($_POST['manager_id'])) : '';
$manager_email1 = isset($_POST['manager_email1']) ? strip_tags(clean_xss_attributes($_POST['manager_email1'])) : '';
$manager_email2 = isset($_POST['manager_email2']) ? strip_tags(clean_xss_attributes($_POST['manager_email2'])) : '';

$cell_phone = isset($_POST['cell_phone']) ? strip_tags(clean_xss_attributes($_POST['cell_phone'])) : '';
if($cell_phone) {
    $result = exist_mb_hp($cell_phone, $manager_id);
    if ($result)
        alert($result);
}

$manager_nick_nm = isset($_POST['manager_nick_nm']) ? trim(strip_tags($_POST['manager_nick_nm'])) : '';
$manager_email = get_email_address($manager_email1."@".$manager_email2);

if ($msg = valid_mb_nick($manager_nick_nm))     alert($msg, "", true, true);

$posts = array();
$check_keys = array(
'manager_nm',
'login_limit_fl',
'employee_fl',
'manager_level'
);

foreach( $check_keys as $key ){
    $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
}

$memo = isset($_POST['memo']) ? $_POST['memo'] : '';

$sql_common = "  manager_nm			= '{$posts['manager_nm']}',
                 manager_nick_nm	= '{$manager_nick_nm}',
                 employee_fl		= '{$posts['employee_fl']}',
                 cell_phone			= '$cell_phone',
                 manager_email		= '$manager_email',
                 manager_level		= '{$posts['manager_level']}',
                 memo				= '$memo',
                 login_limit_fl		= '{$posts['login_limit_fl']}'";


if($w==""){
	
	//신규등록
	$mg = get_manager($manager_id);

	if (isset($mg['manager_id']) && $mg['manager_id'])
        alert('이미 존재하는 운영자아이디입니다.\\nＩＤ : '.$mg['manager_id'].'\\n이름 : '.$mg['manager_nm'].'\\n닉네임 : '.$mg['manager_nick_nm'].'\\n메일 : '.$mg['manager_email']);

	// 닉네임중복체크
    $sql = " select manager_id, manager_nm, manager_nick_nm, manager_email from {$DM['MANAGER_TABLE']} where mb_nick = '{$manager_nick_nm}' ";
    $row = sql_fetch($sql);
    if (isset($row['manager_id']) && $row['manager_id'])
        alert('이미 존재하는 닉네임입니다.\\nＩＤ : '.$mg['manager_id'].'\\n이름 : '.$mg['manager_nm'].'\\n닉네임 : '.$mg['manager_nick_nm'].'\\n메일 : '.$mg['manager_email']);

    // 이메일중복체크
    $sql = " select  manager_id, manager_nm, manager_nick_nm, manager_email from {$DM['MANAGER_TABLE']} where manager_email = '{$manager_email}' ";
    $row = sql_fetch($sql);
    if (isset($row['manager_id']) && $row['manager_id'])
        alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$mg['manager_id'].'\\n이름 : '.$mg['manager_nm'].'\\n닉네임 : '.$mg['manager_nick_nm'].'\\n메일 : '.$mg['manager_email']);
	
	//sql_query(" insert into {$DM['MANAGER_TABLE']} set manager_id = '{$manager_id}', manager_pw = '".get_encrypt_string($manager_pw)."', manager_reg_dt = '".G5_TIME_YMDHIS."', mb_ip = '{$_SERVER['REMOTE_ADDR']}', {$sql_common} ");

	$sql = " insert into {$DM['MANAGER_TABLE']} 
				set manager_id = '{$manager_id}',
					manager_pw = '".get_encrypt_string($manager_pw)."',
					manager_reg_dt = '".G5_TIME_YMDHIS."',
					manaer_reg_ip = '{$_SERVER['REMOTE_ADDR']}',
					{$sql_common}
	";

	echo $sql;

	sql_query($sql);

}else if($w=="u"){
	//수정
	$mg = get_manager($manager_id);

	if (! (isset($mg['manager_id']) && $mg['manager_id']))
        alert('존재하지 않는 회원자료입니다.');

	/*
	if ($is_admin != 'super' && $mg['mb_level'] >= $member['mb_level'])
        alert('자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.');
	*/

	/*if ($is_admin !== 'super' && is_admin($mg['manager_id']) === 'super' ) {
        alert('최고관리자의 비밀번호를 수정할수 없습니다.');
    }
	*/

	/*
	if ($mb_id === $member['mb_id'] && $_POST['mb_level'] != $mb['mb_level'])
        alert($mb['mb_id'].' : 로그인 중인 관리자 레벨은 수정 할 수 없습니다.');
	*/

	// 닉네임중복체크

	
	$sql = " select manager_id, manager_nm, manager_nick_nm, manager_email from {$DM['MANAGER_TABLE']} where manager_nick_nm = '{$manager_nick_nm}' and manager_id <> '$manager_id' ";
    $row = sql_fetch($sql);
    if (isset($row['manager_id']) && $row['manager_id'])
        alert('이미 존재하는 닉네임입니다.\\nＩＤ : '.$row['manager_id'].'\\n이름 : '.$row['manager_nm'].'\\n닉네임 : '.$row['manager_nick_nm'].'\\n메일 : '.$row['manager_email']);


    // 이메일중복체크
	$sql = " select  manager_id, manager_nm, manager_nick_nm, manager_email from {$DM['MANAGER_TABLE']} where manager_email = '{$manager_email}' and manager_id <> '$manager_id'   ";
    $row = sql_fetch($sql);
    if (isset($row['manager_id']) && $row['manager_id'])
        alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$mg['manager_id'].'\\n이름 : '.$mg['manager_nm'].'\\n닉네임 : '.$mg['manager_nick_nm'].'\\n메일 : '.$mg['manager_email']);

	if ($manager_pw)
        $sql_password = " , manager_pw = '".get_encrypt_string($manager_pw)."' ";
    else
        $sql_password = "";

	$sql = " update {$DM['MANAGER_TABLE']}
                set manager_mod_dt = '".G5_TIME_YMDHIS."',
					{$sql_common}
                    {$sql_password}
                where manager_id = '{$manager_id}' ";


    sql_query($sql);

}else{

	alert('제대로 된 값이 넘어오지 않았습니다.');

}

//goto_url('./management_admin_register.php?'.$qstr.'&amp;w=u&amp;manager_id='.$manager_id, false);
