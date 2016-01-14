define(function(require, exports)
{
    var Class       = require('class'),
        localizer   = require('pgui.localizer').localizer,
        _           = require('underscore');

    exports.ModalViewLink = Class.extend({
        init: function(container)
        {
            this.container = container;
            this.modalViewLink = this.container.data('content-link');
            this.dialogTitle  = this.container.data('dialog-title');

            this.container.click(_.bind(function(event)
            {
                event.preventDefault();
                this._invokeModalViewDialog();
            }, this));
        },

        _invokeModalViewDialog: function()
        {
            $.get(this.modalViewLink,
                _.bind(function(data)
                {
                    this._displayModalViewDialog($(data));
                }, this));
        },

        _displayModalViewDialog: function(content)
        {
            var cardViewContainer = $('<div class="modal fade"></div>');
            $('body').append(cardViewContainer);

            cardViewContainer.hide();
            cardViewContainer.append(content);
            cardViewContainer.find('.modal-title').text(this.dialogTitle);

            cardViewContainer.find('.modal-header .close').click(function() {
                cardViewContainer.modal("hide");
            });

            cardViewContainer.modal({
                backdrop: 'static'
            });

            cardViewContainer.on('hidden.bs.modal', function () {
                cardViewContainer.remove();
            })

        }
    });

});