<?php
include "top.php";


if(isset($_GET['category_cds'])) {
    $category_cds = $_GET['category_cds'];
}

$sql = "select * from DM_T_FAQ where branch_cd = '$_SESSION[branch_cdcommon]' or branch_cd = '$branch_cd'";
$result = sql_query($sql);
$result1 = sql_query($sql);
$result2 = sql_query($sql);


?>
<script type="text/javascript">
    function onShowFaq(id) {

        $('.speech-bubble').hide();

       var allData = {'uid' : id};

        $.ajax({ 
            dataType : "json", 
            url : "sub/faq.php",
            type:'POST', 
            data: allData,
            success : function(data){ 
       
                var html = " <div class='speech-bubble'>";
                html+= "<span style='color:#fff; font-size:20px; font-weight:bold;'>" + data.content+"<br/> ○○○</span>";
                html+= " <span id='faq_answer' style='display: block; margin-top:10px;'>" +data.answer+"</span>";
                $("#faq_result").append(html);
                $('#fbtn').addClass( 'fbtnactive' );

            }, error : function(){ 
             alert("로딩실패!"); 
            } 
        });

    }






</script>
<div id="tab">
    <?php

        while($row = sql_fetch_array($result)) {
        
            $category_cd = $row['category_cd'];
    ?>
       <a href="sub01.php?category_cds=<?=$row['category_cd']?>" id="categorymenu">
       <?php
          if(isset($category_cds)) {
       ?>
       <div class="subtab" <?php if ($category_cds == $row['category_cd']) {?> id="stabactive" <?php } ?>> 
       <?php }else{?>
        <div class="subtab"> 
        <?php }?>    
            <?php
                if(isset($category_cds)) {
            ?>
                <?php echo get_code_name($category_cds)?>
            <?php }else{?>
                <?php echo get_code_name($row['category_cd'])?>
            <?php }?>    
        </div>
       </a>
       
    <?php
        }
    ?>
</div>
<div id="tab">
    <div class="row">
    <div class="col-sm-8">
        <div class="faqlist scrollbar-morpheus-den">
            <div class="faqbox">
                홈즈앤루팡에 오신 것을 환영합니다!<br/>매장 이용 중 궁금한 점이나 이러저러한점을 선택해주시면 안내해게드리겠습니다. ;)
                <br/><br/>
                <?php
                    while($row = sql_fetch_array($result1)) {
                ?>
                  <button type="button" class="fbtn" id="fbtn" onclick="onShowFaq(<?=$row['uid']?>);"><?=$row['subject']?></button>
                <?php
                 }
                ?>
                <!-- <button type="button" class="fbtn fbtnactive">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn">sdfsdfsdfsf</button>
                <button type="button" class="fbtn" >sdfsdfsdfsf</button> -->
                <div style="width:98%; float:left; height:10px;"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4" id="faq_result">
        <?php
            while($row = sql_fetch_array($result2)) {
        ?>
        <div class="speech-bubble">
            <span style="color:#fff; font-size:20px; font-weight:bold;"><?=$row['content']?> <br/> ○○○</span>
            <span id="faq_answer" style="display: block; margin-top:10px;">
                <?=$row['answer']?>
            </span>
        </div>
        <?php
          }
        ?>    
    </div>
    </div>
</div>    