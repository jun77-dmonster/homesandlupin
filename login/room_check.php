<?php

include "../common.php";

$branch_cd = $_POST['branch_cd'];
$room_no = $_POST['room_no'];
$branch_cdcommon = $_POST['branch_cdcommon'];
$room_string = "";

$sql = "select * from DM_T_BRANCH_ROOM where branch_cd = '$branch_cd' and room_no = '$room_no'";

$result = sql_query($sql);
$row = sql_fetch_array($result);

$sql1 = "SELECT * FROM DM_T_BRANCH WHERE branch_cd = '". $branch_cd . "'";
$result1 = sql_query($sql1);
$row1 = sql_fetch_array($result1);

if($room_no < 10) {
    $room_string = "0".$room_no;
}

if($row) {

    session_start();
    set_session('branch_cdcommon', $branch_cdcommon);
    set_session('branch_cd', $branch_cd);
    set_session('room_no', $room_no);
    set_session('room_cd', $row['room_cd']);
    set_session('room_string', $room_string);
    set_session('branch_string', $row1['branch_nm']);



    goto_url("/main.php");

}


?>