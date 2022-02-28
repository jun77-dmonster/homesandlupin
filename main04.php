<?php
include "top.php";
?>
<style>
    html, body {
      margin: 0; height: 100%; overflow: hidden; 
    }
</style>

<div class="modal-bg"></div>
<div class="modal-popup">
    <div class="modal-popup-btn-close">
        <div></div>
        <div></div>
    </div>
    <div class="modal-product-item-container"></div>
    <div class="modal-product-option-container">
        <div class="basket-option-radio-container"></div>
        <div class='basket-option-btn-container'><button class='basket-option-btn'>담기</button></div>
    </div>
</div>
<div class="modal-popup-cart-blue">
    <div class="modal-popup-cart-title">주문이 완료되었습니다.</div>
    <div class="modal-popup-cart-btn-container">
        <button>확인</button>
    </div>
    <div class="modal-popup-cart-sub-title">※매장 상황에 따라 주문한 메뉴가 지연될 수 있으니 양해 바랍니다</div>
</div>

<div class="product-container">
    <div class="tab-container"></div>

    <div class="tab1-container"></div>

    <div class="product-list-container"></div>

</div>
<div class="basket-container">
    <div class="basket-list-container">
        <div class="basket-product-list-container"></div>
        <div class="basket-reset-btn-container">
            <button class="basket-btn-reset">비우기</button>
        </div>
    </div>
    <div class="total-price">
        <span>합계</span>
        <div>
            <span>0</span>
            <span>원</span>
        </div>
    </div>
    <button class="btn-order">주문하기</button>
</div>


    <script>

        function chr(n) {
            if (n < 128) {
                return String.fromCharCode(n);
            } else {
                return "ÇüéâäàåçêëèïîìÄÅÉæÆôöòûùÿÖÜ¢£¥₧ƒáíóúñÑªº¿⌐¬½¼¡«»░▒▓│┤╡╢╖╕╣║╗╝╜╛┐└┴┬├─┼╞╟╚╔╩╦╠═╬╧╨╤╥╙╘╒╓╫╪┘┌█▄▌▐▀αßΓπΣσµτΦΘΩδ∞φε∩≡±≥≤⌠⌡÷≈°∙·√ⁿ²■ "[n - 128];
            }
        }

        $(function(){

            var basketTotalPrice = 0;
            var productList = [];
            var optionList = [];
            var optionNameList = [];

            $(document).on("click", ".modal-popup-btn-close", function(event){
                $(".modal-popup, .modal-bg").toggle();
                optionList = [];
                optionNameList = [];
            });

            $(document).on("click", ".modal-popup-cart-btn-container button", function(event){
                $(".modal-bg, .modal-popup-cart-blue").hide();
            })

            $(document).on("click", ".product-list-container > .product-list-item-container", function(event){

                $(".modal-product-item-container > *").remove();
                $(".basket-option-radio-container > *").remove();
                $(".modal-popup > *:not(.modal-popup-btn-close)").remove();
                $(".modal-popup").append("<div class='modal-product-item-container'></div><div class='modal-product-option-container'><div class='basket-option-radio-container'></div><div class='basket-option-btn-container'><button class='basket-option-btn'>담기</button></div></div>");
                $(".modal-product-item-container").append($(event.currentTarget).parent().html());

                // if($(event.currentTarget).data('beverage_option_subject')) {
                //     var subjectArr = $(event.currentTarget).data('beverage_option_subject').split(",");
                //
                //     for(var i = 0; i < subjectArr.length; i++) {
                //         $(".basket-option-radio-container").append("<div class='modal-option-subject-container' data-beverage_cd='" + $(event.currentTarget).data('beverage_cd') + "'><p class='modal-option-subject-title'>" + subjectArr[i] + "(필수)</p></div>");
                //     }
                // }

                var subjectArr = $(event.currentTarget).data('beverage_option_subject').split(",");

                if(subjectArr[0] != "")
                    $(".basket-option-radio-container").append("<div class='modal-option-subject-container' data-beverage_cd='" + $(event.currentTarget).data('beverage_cd') + "'><p class='modal-option-subject-title option-title-0' data-title='"+ subjectArr[0] +"'>" + subjectArr[0] + "(필수)</p></div>");


                $.ajax({
                    type: 'POST',
                    data: { beverage_cd: $(event.currentTarget).data('beverage_cd') },
                    url: 'ok/main04_ok.php?type=option',
                    success: function(data) {

                        var data = JSON.parse(data);

                        optionList = data;

                        for(var i = 0; i < data.length; i++) {

                            var opIdSplit = data[i].beverage_op_id.split(chr(30));
                            optionNameList.push([opIdSplit[0], opIdSplit[1]]);
                            var html = "<label class='radio-label'>";
                            //data[i].beverage_op_id
                                html += "<span data-name='" + opIdSplit[i % 2] + "'>" + opIdSplit[i % 2] + "(+" + data[i].beverage_op_price + "원)</span>";
                                html += "<input type='radio' name='option0' value='" + data[i].beverage_op_no + "' data-option='" + optionNameList[i][0] + "' data-price='" + data[i].beverage_op_price + "' autocomplete='off''>";
                                html += "<span class='checkmark'></span>";
                            html += "</label>";


                            if(i % 2 == 0) {

                                $(".modal-option-subject-container").eq(0).append(html);
                            }

                        }

                        $(".basket-option-radio-container label:nth-child(2) input").attr("checked", true);

                        // for(var i = 0; i < (optionNameList.length / 2); i++) {
                        //
                        //     if(optionNameList[i][0] == $(".basket-option-radio-container .modal-option-subject-container:nth-child(1) label:nth-child(2) span:nth-child(1)").data("name")) {
                        //
                        //         var html = "<label class='radio-label'>";
                        //         //data[i].beverage_op_id
                        //         html += "<span>" + optionNameList[i][1] + "(+" + data[i].beverage_op_price + "원)</span>";
                        //         html += "<input type='radio' name='option1' value='" + data[i].beverage_op_no + "' data-option='" + optionNameList[i][1] + "' data-price='" + optionList[i].beverage_op_price + "'>";
                        //         html += "<span class='checkmark'></span>";
                        //         html += "</label>";
                        //
                        //         $(".modal-option-subject-container").eq(1).append(html);
                        //         $(".basket-option-radio-container .modal-option-subject-container:nth-child(2) label:nth-child(2) input").attr("checked", true);
                        //     }
                        // }


                        $(".basket-option-radio-container").append("<p class='modal-option-subject-title'>수량</p>");
                        var html = "<div class='count-container'>";
                                html += "<div>-</div>";
                                html += "<div>1</div>";
                                html += "<div>+</div>";
                            html += "</div>";

                        // var btnData = "data-";
                        $(".basket-option-radio-container").append(html);

                    }
                });

                $(".modal-popup, .modal-bg").toggle();



            })

            $(document).on("click", ".basket-option-btn", function(event){
                var productPrice = parseInt($(".modal-product-item-container .product-price").data("price"));
                var productNameKR = $(".modal-product-item-container .product-title-kr").text();
                var productNameEN = $(".modal-product-item-container .product-title-en").text();
                var productCount = parseInt($(".count-container div:nth-child(2)").text());
                var productOptions = productNameEN + ", ";
                var productOptionFullName = "";
                var productSelectedOptionName = "";
                var productOptionPrice = 0;


                $(".basket-product-list-container > div").remove();
                $(".radio-label").each(function(i, item){
                    if($($(item).find("input")).prop("checked")) {
                        productOptionPrice = parseInt($($(item).find("input")).data("price"));
                        productOptions += $($(item).find("input")).data("option") + ", ";
                        productSelectedOptionName = $($(item).find("input")).data("option");
                        productOptionFullName = $($(item).find("span").eq(0)).text();
                    }
                });

                var productTotalPrice = (productPrice + productOptionPrice) * productCount;

                productOptions = productOptions.substr(0, productOptions.length - 2);

                var ct_option = "";

                if($(".option-title-0").data("title") !== undefined)
                    ct_option = $(".option-title-0").data("title") + ":" + productSelectedOptionName;

                console.log($(".option-title-0").data("title"), ct_option);
                productList.push({
                    productNameKR: productNameKR,
                    productCount: productCount,
                    productOptions: productOptions,
                    productPrice: productPrice,
                    productTotalPrice: productTotalPrice,
                    productOptionFullName: productOptionFullName,
                    productSelectedOptionName: productSelectedOptionName,
                    productOptionPrice: productOptionPrice,
                    productCd: $(".modal-product-item-container > div").data("beverage_cd"),
                    productOptionTitle: $(".modal-option-subject-title").data("title"),
                    ct_option: ct_option,
                });

                basketTotalPrice = 0;

                for(var i = 0; i < productList.length; i++) {
                    var html = "<div class='basket-product-list-item-container'>";
                    html += "<div class='basket-product-item-header'>";
                    html += "<div class='basket-product-item-title'>" + productList[i].productNameKR + "</div>";
                    html += "<div class='basket-product-item-count'>" + productList[i].productCount + "개</div>";
                    html += "</div>";
                    html += "<div class='basket-product-item-content'>";
                    html += "<div class='basket-product-item-options'>옵션 : " + productList[i].productOptions + "</div>";
                    html += "</div>";
                    html += "<div class='basket-product-item-footer'><div class='basket-product-item-footer-right'>";
                    html += "<div class='basket-product-item-price'><span>" + productList[i].productTotalPrice + "</span> 원</div>";
                    html += "<div class='basket-product-item-close'><div class='basket-product-item-btn-close'><div></div><div></div></div></div>";
                    html += "</div></div>";
                    html += "</div>";

                    $(".basket-product-list-container").append(html);

                    basketTotalPrice += productList[i].productTotalPrice;
                }

                $(".total-price div span:nth-child(1)").text(basketTotalPrice);

                $(".modal-popup, .modal-bg").toggle();
            })

            $(document).on("click", ".btn-order", function(event){

                if(productList.length === 0)
                    return false;

                $(".modal-popup > *:not(.modal-popup-btn-close)").remove();
                $(".modal-popup, .modal-bg").toggle();

                var html = "<div class='modal-check-title'>확인해주세요!</div>";
                html += "<div class='modal-check-img-container'><img src='' alt='CHECK' title='CHECK'></div>";
                html += "<div class='modal-check-btn-container'><button class='second-btn-order'>주문하기</button></div>";

                $(".modal-popup").append(html);
            })

            $(document).on("click", ".second-btn-order", function(event){

                $.ajax({
                    type: "POST",
                    url: "ok/main04_ok.php?type=cart",
                    data: { productList: productList },
                    success: function(data) {
                        console.log(data);
                        productList = [];
                        $(".total-price > div > span:nth-child(1)").text(0);

                        $(".basket-product-list-container > *").remove();

                        $(".modal-popup").hide();
                        $(".modal-popup-cart-blue").show();
                    }
                });

            });

            $(document).on("click", ".basket-product-item-btn-close div", function(event){

                var totalPrice = parseInt($(".total-price div span:first-child").text());
                var productPrice = productList[$($(event.target).parent().parent().parent().parent().parent()).index()].productCount * (productList[$($(event.target).parent().parent().parent().parent().parent()).index()].productPrice + productList[$($(event.target).parent().parent().parent().parent().parent()).index()].productOptionPrice);

                totalPrice = totalPrice - productPrice;

                $(".total-price div span:first-child").text(totalPrice);

                console.log(productList);
                // delete productList[$($(event.target).parent().parent().parent().parent().parent()).index()];
                productList.splice($($(event.target).parent().parent().parent().parent().parent()).index(), 1);
                console.log(productList);
                $($(event.target).parent().parent().parent().parent().parent()).remove();
            });

            $(document).on("click", ".basket-reset-btn-container button", function(event){
                basketTotalPrice = 0;
                productList = [];

                $(".total-price div span:nth-child(1)").text(basketTotalPrice);
                $(".basket-product-list-container > *").remove();
            })

            $(document).on("click", ".basket-option-radio-container .modal-option-subject-container:nth-child(1) input[type='radio']", function(event){

                // $($(".modal-option-subject-container").eq(1).find("label")).remove();
                //
                // for(var i = 0; i < (optionList.length / 2); i++) {
                //
                //     if(optionNameList[i][0] == $($(event.target).parent().find("span:nth-child(1)")).data("name")) {
                //         var html = "<label class='radio-label'>";
                //         //data[i].beverage_op_id
                //         html += "<span>" + optionNameList[i][1] + "(+" + optionList[i].beverage_op_price + "원)</span>";
                //         html += "<input type='radio' name='option1' value='" + optionList[i].beverage_op_no + "' data-option='" + optionNameList[i][1] + "' data-price='" + optionList[i].beverage_op_price + "'>";
                //         html += "<span class='checkmark'></span>";
                //         html += "</label>";
                //
                //         $(".modal-option-subject-container").eq(1).append(html);
                //         $(".basket-option-radio-container .modal-option-subject-container:nth-child(2) label:nth-child(2) input").attr("checked", true);
                //     }
                // }
            })

            $(document).on("click", ".count-container > div:nth-child(1)", function(event) {
                var count = parseInt($(event.target).parent().find("div").eq(1).text());
                count++;
                $($(event.target).parent().find("div").eq(1)).text(count);
            })

            $(document).on("click", ".count-container > div:nth-child(3)", function(event) {
                var count = parseInt($(event.target).parent().find("div").eq(1).text());

                if(count === 1)
                    return false;

                count--;
                $($(event.target).parent().find("div").eq(1)).text(count);
            })

            // 숫자 3자리 콤마찍기
            Number.prototype.formatNumber = function(){
                if(this==0) return 0;
                let regex = /(^[+-]?\d+)(\d{3})/;
                let nstr = (this + '');
                while (regex.test(nstr)) nstr = nstr.replace(regex, '$1' + ',' + '$2');
                return nstr;
            };


            $.ajax({
                type: "post",
                url: "ok/main04_ok.php?type=filter",
                data: {  },
                success: function(data) {


                    var data = JSON.parse(data);

                    var categoryTitleArr = [];

                    for(var i = 0; i < data.length; i++) {

                        if(data[i].item_cd.length === 5) {
                            categoryTitleArr.push(data[i]);
                            $(".tab-container").append("<div data-group_cd='" + data[i].group_cd + "'>" + data[i].item_nm + "</div>");
                        }
                    }

                    $(".tab-container div:first-child").click();
                    $(".tab-container div:first-child").addClass("active");
                }
            });

            $(document).on("click", ".tab-container div", function(event){
                $(event.target).addClass("active").siblings().removeClass("active");

                $.ajax({
                    type: "post",
                    url: "ok/main04_ok.php?type=filter",
                    data: {  },
                    success: function(data) {

                        var data = JSON.parse(data);

                        var subCategoryTitleArr = [];

                        $(".tab1-container div").remove();

                        for(var i = 0; i < data.length; i++) {

                            if(data[i].item_cd.length !== 5 && $(event.target).data("group_cd") == data[i].group_cd) {
                                subCategoryTitleArr.push(data[i]);

                                $(".tab1-container").append("<div data-item_cd='" + data[i].item_cd + "'>" + data[i].item_nm + "</div>");
                            }
                        }

                        $(".tab1-container div:first-child").click();
                        $(".tab1-container div:first-child").addClass("active");


                    }
                });
            });


            $(document).on("click", ".tab1-container div", function(event){
                $(event.target).addClass("active").siblings().removeClass("active");

                $.ajax({
                    type: "POST",
                    url: "ok/main04_ok.php?type=product",
                    data: { item_cd: $(event.target).data("item_cd") },
                    success: function(data) {


                        var data = JSON.parse(data);

                        $(".product-list-container div").remove();

                        for(var i = 0; i < data.length; i++) {
                            var html = "<div class='product-list-item-container' data-beverage_cd='" + data[i].beverage_cd + "' data-beverage_option_subject='" + data[i].beverage_option_subject + "'>";
                                html += "<div class='product-item-img'>";
                                    html += "<img src='/data/beverage/" + data[i].beverage_file + "' alt='BEVERAGE' title='BEVERAGE'>";
                                html += "</div>";
                                html += "<div class='product-title-kr'>" + data[i].beverage_kor_nm + "</div>";
                                html += "<div class='product-title-en'>" + data[i].beverage_eng_nm + "</div>";
                                html += "<div class='product-price' data-price='" + data[i].beverage_price + "'>" + data[i].beverage_price + "원</div>";
                            html += "</div>";

                            $(".product-list-container").append(html);
                        }

                    }
                });
            })
        });
    </script>


</body>
</html>
