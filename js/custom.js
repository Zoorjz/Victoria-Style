jQuery(document).ready(function($) {
    // Initialize Bootstrap dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });

    // Add smooth scrolling to all links
    $("a").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
                window.location.hash = hash;
            });
        }
    });

    // Add active class to current menu item
    var currentLocation = window.location.pathname;
    $('.navbar-nav .nav-link').each(function() {
        var link = $(this).attr('href');
        if (currentLocation === link) {
            $(this).addClass('active');
        }
    });

    // Language Switcher functionality
    $('.language-switcher .btn').on('click', function(e) {
        e.preventDefault();
        var selectedLang = $(this).data('lang');
        
        // Remove active class from all buttons
        $('.language-switcher .btn').removeClass('active');
        // Add active class to clicked button
        $(this).addClass('active');
        
        // Here you can add your language switching logic
        // For example, you might want to:
        // 1. Store the selected language in a cookie
        // 2. Redirect to the appropriate language version
        // 3. Update the content dynamically
        
        console.log('Selected language:', selectedLang);
    });

    // Mega Panel functionality
    let megaPanelTimeout;
    let isHoveringPanel = false;
    
    $('.category-item').hover(
        function() {
            const category = $(this).data('category');
            const hasSubcategories = $(`.mega-panel-section[data-category="${category}"]`).length > 0;
            
            clearTimeout(megaPanelTimeout);
            
            if (hasSubcategories) {
                // Show mega panel
                $('.mega-panel').addClass('active');
                // Show corresponding section
                $('.mega-panel-section').removeClass('active');
                $(`.mega-panel-section[data-category="${category}"]`).addClass('active');
            } else {
                // Hide mega panel immediately for categories without subcategories
                if (!isHoveringPanel) {
                    $('.mega-panel').removeClass('active');
                }
            }
        },
        function() {
            if (!isHoveringPanel) {
                megaPanelTimeout = setTimeout(function() {
                    $('.mega-panel').removeClass('active');
                }, 200);
            }
        }
    );

    $('.mega-panel').hover(
        function() {
            isHoveringPanel = true;
            clearTimeout(megaPanelTimeout);
        },
        function() {
            isHoveringPanel = false;
            megaPanelTimeout = setTimeout(function() {
                $('.mega-panel').removeClass('active');
            }, 200);
        }
    );
}); 