
define(['uiComponent','jquery','mage/url'], function (Component,$,urlBuilder){
    return Component.extend({
        defaults: {
            searchText: '',
            searchResult: [],
            searchUrl: urlBuilder.build('localpage/index/search'),
            minChars: 3
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
            var chars = this.minChars;
            var url = this.searchUrl;
            if (searchValue.length > chars) {
                var self = $(this);
                jQuery.ajax({
                    url: url,
                    type: "POST",
                    data: {value: searchValue},
                    success: function(data) {
                        console.log(data);
                        this.searchResult(data);

                    }.bind(this),
                    error: function(data) {
                        console.log(data);
                    },
                });
            }
        }
    });
})
