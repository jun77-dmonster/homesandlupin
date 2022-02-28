<?php
define('G5_IS_BRANCH', true);
include_once ('../../common.php');
include_once(G5_BRANCH_PATH.'/admin.lib.php');

if( isset($token) ){
    $token = @htmlspecialchars(strip_tags($token), ENT_QUOTES);
}

run_event('admin_common');