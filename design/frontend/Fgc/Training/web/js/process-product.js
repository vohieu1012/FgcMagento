define(['jquery'], function ($) {
    "use strict";
    return function myscript() {
        $(document).ready
        (function ($) {
            $(".page.ajaxpage").on("click", function (event) {
                var target = event.target;
                var $parentElement = $(target).parent();
                $(".item .page.ajaxpage").css("background-color", "inherit");
                $parentElement.css({"background-color": "#e5e5e5", "display": "block", "width": "20px"});
                var page = $(event.target).text();
                var baseUrl = "https://m244ce.m2.fgct.net/rest/V1/listing/?";
                var customUrl = baseUrl + "page=" + page;
                fetchListProduct(customUrl);
            });
        })

        function isEmpty(el) {
            return !$.trim(el.html())
        }

        function fetchListProduct(customUrl) {
            $.ajax({
                url: customUrl,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    $(".products.list").empty();
                    var responseObject = JSON.parse(response);
                    for (var i = 0; i < responseObject.data.length; i++) {
                        var item = responseObject.data[i];
                        var productList = "            <li class=\"item product product-item\">\n" +
                            "                <div class=\"product-item-info\" id=\"product-item-info_706\" data-container=\"product-grid\">\n" +
                            "                    <a href=\"https://m244ce.m2.fgct.net/category-1/category-1-1/configurable-product-23.html\"\n" +
                            "                       class=\"product photo product-item-photo\" tabindex=\"-1\">\n" +
                            "                    <span class=\"product-image-container product-image-container-706\" style=\"width: 240px;\">\n" +
                            "                        <span class=\"product-image-wrapper\" style=\"padding-bottom: 125%;\">\n" +
                            "                            <img class=\"product-image-photo\"\n" +
                            "                                 src=\"" + item["UrlImages"] + "\"\n" +
                            "                                 loading=\"lazy\" width=\"240\" height=\"300\" alt=\"" + item.Name + "\"></span>\n" +
                            "                    </span>\n" +
                            "                    </a>\n" +
                            "                    <div class=\"product details product-item-details\">\n" +
                            "                        <strong class=\"product name product-item-name\">\n" +
                            "                            <a class=\"product-item-link\"\n" +
                            "                               href=\" " + item["UrlProduct"] + "\">\n" +
                            "                              " + item.Name + " </a>\n" +
                            "                        </strong>\n" +
                            "                        <div class=\"price-box price-final_price\" data-role=\"priceBox\" data-product-id=\"706\"\n" +
                            "                             data-price-box=\"product-id-706\"><span class=\"normal-price\">\n" +
                            "                            <span class=\"price-container price-final_price tax weee\">\n" +
                            "                                <span class=\"price-label\">As low as</span>\n" +
                            "                                <span id=\"product-price-706\" data-price-amount=\"1\" data-price-type=\"finalPrice\"\n" +
                            "                                      class=\"price-wrapper \"><span class=\"price\"> " + item.Price + " $</span></span>\n" +
                            "                            </span>\n" +
                            "                        </span>\n" +
                            "                        </div>\n" +
                            "                    </div>\n" +
                            "                </div>\n" +
                            "            </li>"
                        $(".products.list").append(productList);
                        // You can access other properties within each 'item' here
                    }
                },
                error: function (xhr, status, errorThrown) {
                    console.log('Error happens. Try again.');
                    console.log(errorThrown);
                }
            });
        }

        if (isEmpty($('.products.list'))) {
            var baseUrl = "https://m244ce.m2.fgct.net/rest/V1/listing/?";
            var customUrl = baseUrl + "page=" + "1";
            fetchListProduct(customUrl);
        }
    }
});
