<?php
include "top.php";
?>

    <div class="main01-1-container">
        <div class="game-preview-container">
            <img src="img/2인.png" alt="PREVIEW" title="PREVIEW">
        </div>
        <div class="game-num-container">
            <div>인원수</div>
            <div class="active">2인</div>
            <div>3인</div>
            <div>4인</div>
            <div>5인</div>
            <div>6인</div>
        </div>
    </div>


    <script>
        $(function(){

            var num = 2;

            $(".game-num-container div:not(:first-child)").click(function(){
                num = $(this).index() + 1;
                $(".game-preview-container img").attr("src", "img/" + num + "인.png");
                $(this).addClass("active").siblings().removeClass("active");
            });

            $(".game-preview-container img").click(function(event){
                event.preventDefault();

                window.location.href = 'main01-1result.php?num=' + num;
            });

        });
    </script>
</body>
</html>