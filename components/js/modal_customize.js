    define(['jquery', 'bootstrap'], function () {

    function adjustModalMaxHeightAndPosition() {
        var windowHeight = $(window).height();
        if (windowHeight < 320) {
            return;
        }

        $('.modal:not(.modal-top)').each(function() {
            var $modal = $(this);

            if ($modal.hasClass('in') === false){
                $modal.show();
            }

            var contentHeight = windowHeight - 60;
            var headerHeight = $modal.find('.modal-header').outerHeight() || 2;
            var footerHeight = $modal.find('.modal-footer').outerHeight() || 2;

            if ($modal.find('.modal-dialog').outerHeight() + 100 >= windowHeight) {
                if ($modal.hasClass('in') === false){
                    $modal.hide();
                }
                return;
            }

            $modal.find('.modal-content').css({
                'max-height': function () {
                    return contentHeight;
                }
            });

            $modal.find('.modal-body').css({
                'max-height': function () {
                    return contentHeight - (headerHeight + footerHeight);
                }
            });

            $modal.find('.modal-dialog').addClass('modal-dialog-center').css({
                'margin-top': function () {
                    return -($(this).outerHeight() / 2);
                },
                'margin-left': function () {
                    return -($(this).outerWidth() / 2);
                }
            });

            if($modal.hasClass('in') === false){
                $modal.hide();
            }
        });
    }

    var escapeHandler = function (e) {
        if (document.activeElement === document.body) {
            e.which == 27 && $('.modal').modal('hide');
        }
    }

    var $document = $(document);
    var origShow = $.fn.modal.Constructor.prototype.show;
    $.fn.modal.Constructor.prototype.show = function () {
        origShow.apply(this, arguments);
        adjustModalMaxHeightAndPosition();

        var self = this;
        this.$element.one('shown.bs.modal', function () {
            var $input = self.$element.find('.form-control').get(0);
            if ($input) {
                $input.focus();
            }

            $document.on('keydown', escapeHandler);
        });

        this.$element.one('hidden.bs.modal', function () {
            $document.off('keydown', escapeHandler);
        });

    }
});
