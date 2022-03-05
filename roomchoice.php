<?php
include "common.php";

$branch_cd = get_session('branch_cd');

$sql = "SELECT `branch_cd`, `room_cd`, `room_no` FROM DM_T_BRANCH_ROOM WHERE branch_cd='" . $_SESSION['branch_cd'] . "' AND room_delete_fl = 'F' ";
$result = sql_query($sql);

$room = [];
for($i=0; $row = sql_fetch_array($result); $i++) {
    array_push($room, $row);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>홈즈 앤 루팡</title>
</head>
<body>
<style>
    html, body {   
        margin: 0; height: 100%; overflow: hidden; 
    }
</style>
<script type="text/javascript">
  function onChklogin() {
     
    var room_no = $("#room_no option:selected").val();
    var pwd = $("input[type='password']").val();

    if(room_no  == "") {
      alert('룸을 선택해주세요.');
      return false;
    }

    if(pwd == "") {
        alert("룸 비밀번호를 입력 해 주세요.");
        return false;
    }

    document.logincheck.submit();

  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<style>
    input[type="password"] {
        margin-top: 12px;
    }
</style>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
    <form action="login/room_check.php" name="logincheck" method="post">
    <div class="form-group">
    <label for="exampleFormControlSelect1">룸을 선택하세요</label>
    <input type="hidden" name="branch_cd" value="<?=$branch_cd?>">
    <input type="hidden" name="branch_cdcommon" value="B0000">
    <select name="room_no" id="room_no" class="form-control" id="exampleFormControlSelect1">
        <option value="">선택하세요</option>
        <?php foreach($room as $key => $data):?>
            <option value="<?php echo $data['room_no']?>"><?php echo $data['room_no']?></option>
        <?php endforeach;?>
    </select>
        <input type="password" name="room_pwd" class="form-control" placeholder="룸 비밀번호를 입력 해 주세요.">
  </div>

  <button type="button" onclick="onChklogin();" class="btn btn-primary">로그인</button>
</form>

</div>
    </div>
</div>
</body>
</html>