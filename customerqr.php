
<?php
include "common.php";
session_start();

$sql = "SELECT branch_cd FROM DM_T_BRANCH WHERE branch_nm='" . $_GET['branch_nm'] . "'";
$result = sql_fetch($sql);

//echo $result['branch_cd'];

$sql1 = "SELECT room_cd FROM DM_T_BRANCH_ROOM WHERE branch_cd ='" . $result['branch_cd'] . "'";
$result1 = sql_fetch($sql1);


$branch_cd = $_SESSION['branch_cd'];
$room_cd = $_SESSION['room_cd'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here"/>

    <title>홈즈앤 루팡</title>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<style>
    .col-14 {text-align: center;}


    html, body {
        margin: 0; height: 100%; overflow: hidden;
    }

</style>

<script type="text/javascript">

    $(document).ready(function () {
        $("#alertStart").click(function () {
            var customer_content = $('#customtextarea').val();
            var branch_cd = $('#branch_cd').val();
            var room_cd = $('#room_cd').val();
            var write_gubun = $('#write_gubun').val();


            if(customer_content == "") {
                alert('고객의 소리를 작성해주세요.');
                $('#customtextarea').focus();
                return false;
            }

            var allData = {
                'customer_content' : customer_content
                , 'branch_cd' : branch_cd
                , 'room_cd' : room_cd
                , 'write_gubun' : write_gubun

            };

            $.ajax({
                dataType : "html",
                url : "customer/insertrq.php",
                type:'POST',
                data: allData,
                success : function(data){

                    Swal.fire({
                        icon: 'success', // Alert 타입
                        title: '등록완료', // Alert 제목
                        text: '고객의 소리가 접수되었습니다:)', // Alert 내용
                    });


                }, error : function(){
                    alert("로딩실패!");
                }
            });

        });
    });

</script>

<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-14 col-sm-12 col-md-12 col-lg-10 col-xl-10">
            <div class="requestbox">
                <img src="img/customer_text.png" style="margin-bottom:15px;">
                <p>홈즈앤루팡을 이용 하며 좋았던 점 / 개선점이 있다면 알려주세요!</p>
                <p>해당 내용은 <span style="color:#FF8C00;">홈즈앤루팡 보드게임카페 본사</span>로 전달됩니다.</p>
                <p>이용 중 불편 사항은 <span style="color:#FF8C00;">카운터에 문의</span>해주시면 빠르게 도와드리겠습니다. :)</p>
            </div>
            <form action="ok/main05_ok.php?type=qrcode" id="customform" method="post">
                <input type="hidden" name="branch_cd"  id="branch_cd" value="<?=$result['branch_cd']?>">
                <input type="hidden" name="room_cd" id="room_cd" value="<?=$result1['room_cd']?>">
                <input type="hidden" name="write_gubun" id="write_gubun" value="web">
                <textarea name="customer_content" id="customtextarea" style="width:80%; height:200px;"></textarea>
                <p><a href="#" id="alertStart"><img src="img/submitbtn.png"></a></p>
            </form>
        </div>


    </div>
</div>
</body>
</html>