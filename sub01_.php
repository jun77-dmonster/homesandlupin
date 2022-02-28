<?php
    include "top.php";
?>

<div class="sub01_container">
    <div class="sub01-tab-container"></div>

    <div class="sub01-question-list-container">
        <div class="sub01-question-container">
            <p class="sc_faq_text"></p>
            <div class="sub01-question-list-scroll-container">
<!--                <div class="active">화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
<!--                <div>화장실 어디에 있어요?</div>-->
            </div>
        </div>
        <div class="sub01-speech-bubble-container">
            <div class="sub01-rect">
                <div class="sub01-rect-title"></div>
                <div class="sub01-rect-dot">...</div>
                <div class="sub01-rect-content"></div>
            </div>
            <div class="sub01-triangle"></div>
        </div>
    </div>

</div>


<script>

    $(function(){
        $(document).on("click", ".sub01-tab-container > div", function(event){

            $(".sub01-rect-title, .sub01-rect-content").html("");

            var itemCd = $(this).data("item_cd");

            $.ajax({
                type: 'POST',
                url: 'ok/sub01_ok.php?type=faq',
                data: { item_cd: itemCd },
                success: function(data) {
                    data = JSON.parse(data);
                    console.log(data);

                    $(".sub01-question-list-scroll-container > div").remove();
                    if(data[0] !== null) {
                        data.forEach(function(item, i){
                            if($(".sub01-question-list-scroll-container > div").length == 0) {
                                $(".sub01-question-list-scroll-container").append("<div class='active' data-subject='" + item.subject + "' data-content='" + item.content + "' data-answer='" + item.answer + "'>" + item.subject + "</div>");
                                $(".sub01-question-list-scroll-container > div:first-child").click();
                            } else {
                                $(".sub01-question-list-scroll-container").append("<div data-subject='" + item.subject + "' data-content='" + item.content + "' data-answer='" + item.answer + "'>" + item.subject + "</div>");
                            }

                        });
                    }

                    $(event.target).addClass("active").siblings().removeClass("active");
                }
            });
        });

        $(document).on("click", ".sub01-question-list-scroll-container > div", function(){
            $(this).addClass("active").siblings().removeClass("active");

            var subject = $(this).data("subject");
            var answer = $(this).data("answer");

            $(".sub01-rect-title").text(subject);
            $(".sub01-rect-content").html(answer);

        });

        $.ajax({
            type: 'POST',
            url: 'ok/sub01_ok.php?type=category',
            data: {},
            success: function(data) {
                data = JSON.parse(data);
                $(".sub01-tab-container div").remove();
                data.forEach(function(item, i){

                    if(item.item_cd.length > 5) {
                        if($(".sub01-tab-container div").length == 0) {
                            $(".sub01-tab-container").append("<div class='active' data-item_cd='" + item.item_cd + "'>" + item.item_nm + "</div>");
                            $(".sub01-tab-container > div:first-child").click();
                        } else {
                            $(".sub01-tab-container").append("<div data-item_cd='" + item.item_cd + "'>" + item.item_nm + "</div>");
                        }
                    }

                });
            }
        });

        $.ajax({
            type: 'POST',
            url: 'ok/sub01_ok.php?type=top_text',
            data: {},
            success: function(data) {

                data = JSON.parse(data);

                $(".sc_faq_text").text(data[0].sc_faq_text);

            }
        });
    });

</script>