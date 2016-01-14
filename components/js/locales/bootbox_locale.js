require(['pgui.localizer', 'libs/bootbox.min', 'jquery'], function (localizer) {
    var localizer = localizer.localizer;

    bootbox.addLocale('php_gen', {
        OK: localizer.getString('Ok'),
        CANCEL: localizer.getString('Cancel'),
        CONFIRM: localizer.getString('Ok'),
    });
    
    bootbox.setLocale('php_gen');

    return bootbox;
});
