define(['jquery', 'uiComponent', 'ko'], function ($, Component, ko) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Fgc_PageRender/render'
        },

        // Initialize data with KO
        listProduct: ko.observableArray(),
        isShowPrevious: ko.observable(true),
        isShowNext: ko.observable(true),
        pageIndex: ko.observable(1),
        initialize: function () {
            this._super();
            if(this.pageIndex()==1){
                this.isShowPrevious(false);
                this.getDataProduct();
            }
        },
        getDataProduct: function () {
            var baseUrl = "https://m244ce.m2.fgct.net/rest/V1/listing/?";
            var customUrl = baseUrl + "page=" + this.pageIndex();
            var self = this; // Capture the correct context
            $.ajax({
                url: customUrl,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    var responseObject = JSON.parse(response);
                    self.listProduct(responseObject.data);
                    return true;
                },
                error: function (xhr, status, errorThrown) {
                    return false;
                }
            });
        },
        previousPage: function () {
            this.pageIndex(this.pageIndex() - 1);
            if(this.pageIndex()==1){
                this.isShowPrevious(false);
            }
            this.getDataProduct();
        },
        nextPage: function () {
            this.pageIndex(this.pageIndex() + 1);
            if(this.pageIndex()!=1){
                this.isShowPrevious(true);
            }
            this.getDataProduct();
        }
    });
});

