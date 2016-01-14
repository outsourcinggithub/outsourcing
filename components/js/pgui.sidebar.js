define(['jquery.resize', 'amplify.store'], function () {
    var $navbar = $('#navbar');
    var $sidebar = $('.sidebar');
    var $parentContainer = $sidebar.parent();
    var $body = $('body');
    var $closeButton = $body.find('.sidebar-close,.toggle-sidebar');
    var $backdrop = $("<div/>").addClass("sidebar-backdrop");

    var visibleClass = 'sidebar-active';
    var invisibleClass = 'sidebar-inactive';
    var navBarHeight = $navbar.outerHeight();
    var windowWidth = window.innerWidth;

    if ((window.PG_HIDE_SIDEBAR_BY_DEFAULT && !amplify.store('isSidebarVisible'))
        || window.innerWidth <= 768
    ) {
        $parentContainer.removeClass(visibleClass);
        $parentContainer.addClass(invisibleClass);
    }
    setTopSideBar();

    // fix sidebar flashing on small screens
    $sidebar.removeClass("hidden-xs");

    $(window)
        .scroll(setTopSideBar)
        .resize(function () {
            if (window.innerWidth < windowWidth && $parentContainer.hasClass(visibleClass)) {
                toggleSidebar();
            }

            windowWidth = window.innerWidth;
            setTopSideBar();
        });

    $closeButton.click(toggleSidebar);
    $backdrop.click(toggleSidebar);

    function toggleSidebar(e) {
        e && e.preventDefault();
        $parentContainer.toggleClass(visibleClass);
        $parentContainer.toggleClass(invisibleClass);

        var isVisible = $parentContainer.hasClass(visibleClass);
        amplify.store('isSidebarVisible', isVisible);

        if (isVisible && window.innerWidth <= 768) {
            $body.css("overflow", "hidden");
            $backdrop.appendTo($body);
            return;
        }

        $backdrop.detach();
        $body.css("overflow", "auto");
    }

    function setTopSideBar() {
        var top = 0;
        if (window.innerWidth > 768) {
            top = navBarHeight;
            $backdrop.detach();
        } else if ($backdrop.parent().length === 0 && $parentContainer.hasClass(visibleClass)) {
            $backdrop.appendTo($body);
        }

        $sidebar.css('top', top);
    }
});
