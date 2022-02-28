<?php
define('G5_IS_ROUTE', true);
include_once ('../common.php');


$branch_manager_id		= isset($_POST['branch_manager_id']) ? trim($_POST['branch_manager_id']) : '';
$branch_manager_pwd		= isset($_POST['branch_manager_pwd']) ? trim($_POST['branch_manager_pwd']) : '';

$sql = "select * from {$DM['BRANCH_TABLE']}  where branch_manager_id = '{$branch_manager_id}' and branch_manager_pwd = '".get_encrypt_string($branch_manager_pwd)."'";

echo $sql;

exit;

$row = sql_fetch($sql);




if($row) {

    echo "<meta http-equiv='refresh' content='0;url=../roomchoice.php'>";
    
}else{

    ?>
    <script type="text/javascript">
        alert('아이디나 비번이 일치하지않습니다.');
    </script>
    <?php
    echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
}


?>