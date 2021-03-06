define(function(require, exports, module)
{
    var Class       = require('class'),
        resource    = require('components/js/jslang.php?').resource,
        _           = require('underscore');

    var Localizer = Class.extend({

        init: function(localizationResource)
        {
            this.localizationResource = localizationResource;
            this.localizedStrings = resource;
        },

        getString: function(code, defaultValue)
        {
            return _.isUndefined(this.localizedStrings[code]) ? defaultValue : this.localizedStrings[code];
        }

    });

    exports.localizer = new Localizer('components/js/jslang.php');
});