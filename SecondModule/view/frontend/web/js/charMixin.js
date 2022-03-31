
define([], function () {
    'use strict';
    return function (searchAutocomplete) {
        return searchAutocomplete.extend({
            initialize: function () {
                this._super();
                this.minChars = 5;
            }
        });
    }