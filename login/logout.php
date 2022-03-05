
<?php
include "../common.php";
//unset($_COOKIE['ss_branch_key']);
//unset($_COOKIE['branch_cdcommon']);
//unset($_COOKIE['branch_cd']);
//unset($_COOKIE['room_no']);
//unset($_COOKIE['room_cd']);
//unset($_COOKIE['room_string']);
//unset($_COOKIE['branch_string']);
//setcookie('ss_branch_key', '', (time() + 8600) * 30, "/");
//setcookie('branch_cdcommon', '', (time() + 8600) * 30, "/");
//setcookie('branch_cd', '', (time() + 8600) * 30, "/");
//setcookie('room_no', '', (time() + 8600) * 30, "/");
//setcookie('room_cd', '', (time() + 8600) * 30, "/");
//setcookie('room_string', '', (time() + 8600) * 30, "/");
//setcookie('branch_string', '', (time() + 8600) * 30, "/");



session_start();
session_destroy();

echo "<script>window.location.href='/index.php'</script>";

?>

