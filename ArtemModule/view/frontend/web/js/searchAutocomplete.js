
define(['uiComponent','jquery','mage/url'], function (Component,$,urlBuilder){
    return Component.extend({
        defaults: {
            searchText: '',
            searchResult: [],
            searchUrl: urlBuilder.build('localpage/index/search')
        },
        initObservable: function () {
            this._super();

            this.observe(
                ['searchText', 'searchResult']
            );
            return this;
        },
        initialize: function () {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this));

        },


        handleAutocomplete: function (searchValue) {
            console.log(searchValue);
            this.minChars = 2;
            var url = this.searchUrl;
            if (searchValue.length > this.minChars) {
                var self = $(this);
                jQuery.ajax({
                    url: url,
                    type: "POST",
                    data: {value: searchValue},
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    },
                });
                // var filteredSku = this.availableSku.filter (
                //     function (item) {
                //         return item.indexOf(searchValue) !== -1;
                //     }
                // );
                // this.searchResult(filteredSku);
            }
            // else {
            // this.searchResult([]);
            // }
        }
    });
})
