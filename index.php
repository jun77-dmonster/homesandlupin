<?php 
include "common.php";
session_start();

if(isset($_SESSION['branch_cd']) or isset($_SESSION['branch_cdcommon'])){
  echo "<meta http-equiv='refresh' content='0;url=main.php'>";
} else {

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
     
    var id = $('#userid').val();
     var pass = $('#pass').val();

    if(id  == "") {
      alert('아이디를 입력해주세요.');
      $('#userid').focus();
      return false;
    }

    if(pass  == "") {
      alert('비밀번호를 입력해주세요.');
      $('#pass').focus();
      return false;
    }

    document.logincheck.submit();

  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<style>
    .login-logo-container {
        float: left;
        width: 100%;
        margin-bottom: 32px;
        text-align: center;
    }
    .login-logo-center-container {
        background-color: #03254C;
        width: 140px;
        height: 140px;
        border-radius: 32px;
        margin: 0 auto;
    }
    .login-logo-center-container img {
        margin-top: 17.5px;
        float: left;
        margin-left: 7px;
    }
</style>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="login-logo-container">
                <div class="login-logo-center-container">
                    <a href="/index.php"><img src="img/logo.png" alt="logo" title="logo"></a>
                </div>
            </div>
    <form action="bbs/branch_login.php" name="logincheck" method="post">
    <div class="form-group">
      <label for="exampleInputEmail1">아이디</label>
      <input type="text" name="mb_id" class="form-control" id="userid" aria-describedby="emailHelp" placeholder="아이디를 입력하세요">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">비밀번호</label>
      <input type="password" name="mb_password" class="form-control" id="pass" placeholder="비밀번호를 입력하세요">
    </div>

  <button type="button" onclick="onChklogin();" class="btn btn-primary">로그인</button>
</form>

</div>
    </div>
</div>



</body>
</html>
<?php } ?>