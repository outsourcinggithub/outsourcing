define(function(require, exports) {

    require('jquery');
    require('bootbox.min');
    var sprintf = require("libs/sprintf").sprintf;

    exports.showInfoMessage = function(message) {
        _showBootBoxAlert(_buildMessage(message, 'info'));
    };

    exports.showSuccessMessage = function(message) {
        _showBootBoxAlert(_buildMessage(message, 'success'));
    };

    exports.showWarningMessage = function(message) {
        _showBootBoxAlert(_buildMessage(message, 'warning'));
    };

    exports.showErrorMessage = function(message) {
        _showBootBoxAlert(_buildMessage(message, 'danger'));
    };

    var showMessage = exports.showMessage = function(message) {
        _showBootBoxAlert(message);
    };

    function _buildMessage(message, alertClass) {
        return sprintf('<div class="alert alert-%s"', alertClass) +  'role="alert" style="margin-bottom: 0">' +
            '<p>' + message + '</p>' +
            '</div>'
    }

    function _showBootBoxAlert(messageToDisplay) {
        bootbox.alert({
            closeButton: false,
            message: messageToDisplay
        });
    }

    exports.updatePopupHints = function ($container) {
        $container.find('.js-more-hint').each(function () {
            var $hintLink = $(this);
            var $hintMessage = $hintLink.siblings('.js-more-box').html();
            $hintLink
                .on('click', function() {
                    $(this).popover('hide');
                    showMessage($hintMessage);
                    return false;
                })
                .popover({
                    title: '',
                    placement: function () {
                        if ($hintLink.offset().top - $(window).scrollTop() < $(window).height() / 2)
                            return 'bottom';
                        else
                            return 'top';
                    },
                    html: true,
                    trigger: 'hover',
                    content: $hintMessage
                });
        });
    };

});
