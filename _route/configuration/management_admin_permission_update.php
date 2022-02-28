<?php
$sub_menu = '100210';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$au_menu = isset($_POST['au_menu']) ? preg_replace('/[^0-9a-z_]/i', '', $_POST['au_menu']) : '';
$post_r = isset($_POST['r']) ? preg_replace('/[^0-9a-z_]/i', '', $_POST['r']) : '';
$post_w = isset($_POST['w']) ? preg_replace('/[^0-9a-z_]/i', '', $_POST['w']) : '';
$post_d = isset($_POST['d']) ? preg_replace('/[^0-9a-z_]/i', '', $_POST['d']) : '';

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$manager = get_manager($manager_id);
if (!$manager['manager_id'])
    alert('존재하는 회원아이디가 아닙니다.');

check_admin_token();

include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if (!chk_captcha()) {
    alert('자동등록방지 숫자가 틀렸습니다.');
}

$sql = " insert into {$DM['MANAGER_AUTH_TABLE']}
            set manager_id  = '$manager_id',
                au_menu		= '$au_menu',
                au_auth		= '{$post_r},{$post_w},{$post_d}' ";

$result = sql_query($sql);

if (!$result) {
    $sql = " update {$DM['MANAGER_AUTH_TABLE']}
                set au_auth = '{$post_r},{$post_w},{$post_d}'
              where manager_id   = '$manager_id'
                and au_menu = '$au_menu' ";

    sql_query($sql);
}

goto_url('./management_admin_permission.php?'.$qstr);