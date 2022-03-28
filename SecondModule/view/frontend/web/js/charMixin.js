define(['uiComponent', 'uiRegistry'], function () {
        'use strict';

        var mixin = {
            initialize: function() {
                this._super();
                this.minChars = 5 },
        };

        return function (target) {
            return target.extend(mixin);
        };

    }
);
// define([], function () {
//         'use strict';
//         var mixin = {
//             defaults: {
//                 minChars : 5
//             },
//         };
//         return function (target) {
//             return target.extend(mixin);
//         };
//
//     }
// );
// define(['jquery'], function ($) {
//     'use strict';
//
//     return function (Component) {
//         return Component.extend({
//             initialize: function () {
//                 this._super();
//                 this.minChars = 5;
//
//                 console.log(' initialised');
//             }
//         });
//     }
// });
// define(['uiComponent'], function (Component) {
//     'use strict';
//     return function (Component) {
//         return Component.extend({
//             initialize: function () {
//                 this._super();
//                 return this.minChars = 5;
//             }
//         });
//     }
// });
// define([
//     'use strict'
// ], function(searchAutocomplete){
//
//     return searchAutocomplete.extend({s
//
//         defaults: {
//             minChars  },
//
//     });
// });
// define(['uiComponent', 'uiRegistry'], function (Component) {
//         'use strict';
//
//         var mixin = {
//             handleAutocomplete: function() {
//
//                 return this.minChars = 5
//             }
//         };
//
//         return function (Component) {
//             return Component.extend(mixin);
//         };
//
//     }
// );
// define(function () {
//     'use strict';
//
//     var mixin = {
//
//         initialize: function (minChars) {
//             return this.minChars = 5 || this._super();
//         }
//     };
//
//     return function (target) { // target == Result that Magento_Ui/.../columns returns.
//         return target.extend(mixin); // new result that all other modules receive
//     };
// });


// define(["jquery",'uiComponent'],
//     function ($,Component) {
//         'use strict';
//         var mixins = {
//             handleAutocomplete: function () {
//                 this._super();
//                 return this.minChars = 5;
//             },
//         }
//         return function (target) {
//             return target.extend(mixins);
//         }
//     });
