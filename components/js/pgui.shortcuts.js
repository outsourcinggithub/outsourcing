define(['jquery', 'jquery.hotkeys'], function () {

    $.hotkeys.options = $.extend($.hotkeys.options, {
        filterInputAcceptingElements: false,
        filterContentEditable: false,
        filterTextInputs: false
    });

    var shortcuts = [
        {
            keys: ['Ctrl+left'],
            selector: '.pgui-pagination .pgui-pagination-prev',
            scope: 'grid'
        },
        {
            keys: ['Ctrl+right'],
            selector: '.pgui-pagination  .pgui-pagination-next',
            scope: 'grid'
        },
        {
            keys: ['Alt+Ctrl+I', 'Alt+Insert'],
            selector: '.grid:first .pgui-add',
            scope: 'grid'
        },
        {
            keys: ['Ctrl+Shift+/'],
            selector: '.grid:first .expand-all-details',
            scope: 'grid'
        },
        {
            keys: ['Ctrl+Shift+F'],
            selector: '.grid:first .js-filter-builder-open',
            scope: 'grid'
        },
        {
            keys: ['Ctrl+Return'],
            selector: '.modal:visible .submit-button,form:visible .submit-button',
            ignoreFocusedInputs: true,
            scope: 'form'
        },
        {
            keys: ['Ctrl+Shift+Return'],
            selector: '.modal:visible #saveinsert,.saveinsert-button',
            ignoreFocusedInputs: true,
            scope: 'form'
        },
        {
            keys: ['Alt+Ctrl+I', 'Alt+Insert'],
            selector: '.modal:visible .js-group-action-select[data-action=add-condition]',
            ignoreFocusedInputs: true,
            scope: 'filter_builder'
        },
        {
            keys: ['Ctrl+Return'],
            selector: '.modal:visible .js-filter-builder-commit',
            ignoreFocusedInputs: true,
            scope: 'filter_builder'
        }
    ];

    var handlers = {};
    function getHandler(id, ignoreFocusedInputs, selector, scope) {
        if (!handlers[id]) {
            handlers[id] =  function (e) {

                if (-1 === currentScopes[currentScopes.length - 1].indexOf(scope)) {
                    return true;
                }

                if (!ignoreFocusedInputs && /textarea|input|select/i.test(e.target.nodeName)) {
                    return true;
                }

                var element = $(selector).get(0);
                if (element) {
                    element.click();
                }
            };
        }

        return handlers[id];
    }

    $document = $(document);

    var currentScopes = [];

    function push (scopes) {
        scopes = scopes || ['common', 'grid', 'form'];

        currentScopes.push(scopes);
        
        $.each(shortcuts, function (index, shortcut) {

            if (scopes.indexOf(shortcut.scope) === -1) {
                return;
            }

            var id = shortcut.keys.join('') + shortcut.scope;
            var handler = getHandler(id, shortcut.ignoreFocusedInputs, shortcut.selector, shortcut.scope);

            $document.off('keydown', handler);
            $.each(shortcut.keys, function (index, key) {
                $document.on('keydown', null, key, handler);
            });

            var $element = $(shortcut.selector);
            if ($element.length) {
                var title = $element.attr('title');
                title = title ? title + ' ' : '';
                $element.attr('title', title + '[' + shortcut.keys.join(', ') + ']');
            }
        });
    };

    function pop() {
        currentScopes.pop();
    }

    return {
        push: push,
        pop: pop,
    };

});
