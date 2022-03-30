define (['jquery'], function ($){
    $.widget('mynamespace.testewidget', {
        options: {
            selector: null,
        },
        _create: function () {
            this.hideElements();
        },
        hideElements: function () {
            $(this.options.selector).hide();
            $(this.element).hide();
        }
    })
    return $.mynamespace.testewidget;
    });


//     return function (config, element){
//         // $('.page-footer').hide();
//         $(element).hide();
//         $(config.selector).hide();
//      }
// })
