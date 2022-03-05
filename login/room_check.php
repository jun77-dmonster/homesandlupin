<?php

include "../common.php";
$branch_cd = $_POST['branch_cd'];
$room_no = $_POST['room_no'];
$branch_cdcommon = $_POST['branch_cdcommon'];
$pwd = get_encrypt_string($_POST['room_pwd']);
$room_string = "";
//AND room_pwd = '" .$pwd. "'
$sql = "select * from DM_T_BRANCH_ROOM where branch_cd = '$branch_cd' and room_no = '$room_no'";

$result = sql_query($sql);
$row = sql_fetch_array($result);

$sql1 = "SELECT * FROM DM_T_BRANCH WHERE branch_cd = '". $branch_cd . "'";
$result1 = sql_query($sql1);
$row1 = sql_fetch_array($result1);

if($room_no < 10) {
    $room_string = "0".$room_no;
} else {
    $room_string = $room_no;
}
if($row) {
    session_start();
    set_session('branch_cdcommon', $branch_cdcommon);
    set_session('branch_cd', $branch_cd);
    set_session('room_no', $room_no);
    set_session('room_cd', $row['room_cd']);
    set_session('room_string', $room_string);
    set_session('branch_string', $row1['branch_nm']);


//    setcookie("branch_cdcommon", $branch_cdcommon, (time() + 8600) * 30,'/');
//    setcookie("branch_cd", $branch_cd, (time() + 8600) * 30,'/');
//    setcookie("room_no", $room_no, (time() + 8600) * 30,'/');
//    setcookie("room_cd", $row['room_cd'], (time() + 8600) * 30,'/');
//    setcookie("room_string", $room_string, (time() + 8600) * 30,'/');
//    setcookie("branch_string", $row1['branch_nm'], (time() + 8600) * 30,'/');




//    goto_url("/main.php");
}


?>

<div
        id="room_check_container"
        data-branch_cdcommon="<?PHP echo $_SESSION['branch_cdcommon']?>"
        data-branch_cd="<?PHP echo $_SESSION['branch_cd']?>"
        data-room_no="<?PHP echo $_SESSION['room_no']?>"
        data-room_cd="<?PHP echo $_SESSION['room_cd']?>"
        data-room_string="<?PHP echo $_SESSION['room_string']?>"
        data-branch_string="<?PHP echo $_SESSION['branch_string']?>"
>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

    $(function(){

        localStorage.setItem("branch_cdcommon", $("#room_check_container").data("branch_cdcommon"));
        localStorage.setItem("branch_cd", $("#room_check_container").data("branch_cd"));
        localStorage.setItem("room_no", $("#room_check_container").data("room_no"));
        localStorage.setItem("room_cd", $("#room_check_container").data("room_cd"));
        localStorage.setItem("room_string", $("#room_check_container").data("room_string"));
        localStorage.setItem("branch_string", $("#room_check_container").data("branch_string"));

        window.location.href = "/main.php";
    });

</script>
