define(function(require, exports, module) {

    require('jquery');

    var $body = $('body');
    require(['pgui.utils'], function(instance){
        instance.updatePopupHints($body);
    });

});
