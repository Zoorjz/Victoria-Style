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

    // Multi-language text parsing function
    function parseMultilangText(text, lang) {
        if (!text) return text;
        
        // Map language codes to proper tags
        var langMap = {
            'rus': 'ru',
            'geo': 'ka',
            'eng': 'eng'
        };
        
        var targetLang = langMap[lang] || lang;
        
        // Pattern to match language tags like <ru_>text<ru_>
        var pattern = new RegExp('<(' + targetLang + ')_>(.*?)<\\1_>', 'g');
        var match = pattern.exec(text);
        
        if (match) {
            return match[2];
        }
        
        // If specific language not found, try to extract first available language
        var generalPattern = /<(\w+)_>(.*?)<\1_>/;
        var generalMatch = generalPattern.exec(text);
        if (generalMatch) {
            return generalMatch[2];
        }
        
        // If no language tags found, return original text
        return text;
    }

    // Function to update all multilang content on the page
    function updateMultilangContent(selectedLang) {
        console.log('Updating content for language:', selectedLang);
        
        // Update navigation items
        $('.navbar-nav .nav-link').each(function() {
            var originalText = $(this).data('original-text');
            if (originalText) {
                var translatedText = parseMultilangText(originalText, selectedLang);
                console.log('Nav item:', originalText, '->', translatedText);
                $(this).text(translatedText);
            }
        });

        // Update category sidebar
        $('.category-item').each(function() {
            var originalText = $(this).data('original-text');
            if (originalText) {
                var translatedText = parseMultilangText(originalText, selectedLang);
                
                // Update only the text, keeping the icon
                var icon = $(this).find('i').prop('outerHTML') || '';
                $(this).html(icon + ' ' + translatedText);
                console.log('Category item:', originalText, '->', translatedText);
            }
        });

        // Update carousel captions
        $('.carousel-caption h5, .carousel-caption p').each(function() {
            var originalText = $(this).data('original-text');
            if (originalText) {
                var translatedText = parseMultilangText(originalText, selectedLang);
                $(this).text(translatedText);
                console.log('Carousel caption:', originalText, '->', translatedText);
            }
        });

        // Update mega panel content
        $('.mega-panel h4, .mega-panel a').each(function() {
            var originalText = $(this).data('original-text');
            if (originalText) {
                var translatedText = parseMultilangText(originalText, selectedLang);
                $(this).text(translatedText);
                console.log('Mega panel:', originalText, '->', translatedText);
            }
        });

        // Content updates now handled by page refresh

        // Update language switcher active state
        $('.language-switcher .language-btn, .language-switcher .btn').removeClass('active');
        $('.language-switcher [data-lang="' + selectedLang + '"]').addClass('active');

        // Store language preference
        document.cookie = 'site_language=' + selectedLang + '; path=/; max-age=' + (365 * 24 * 60 * 60);
        window.currentSiteLanguage = selectedLang;
        
        console.log('Content update completed for language:', selectedLang);
    }

    // Content translation now handled by server-side filtering with page refresh

    // Make updateMultilangContent globally available
    window.updateMultilangContent = updateMultilangContent;
    
    // Language Switcher functionality - jQuery event handler (simplified with page refresh)
    $('.language-switcher .language-btn, .language-switcher .btn').on('click', function(e) {
        e.preventDefault();
        var selectedLang = $(this).data('lang');
        
        console.log('Language switcher clicked:', selectedLang);
        
        // Store language preference
        document.cookie = 'site_language=' + selectedLang + '; path=/; max-age=' + (365 * 24 * 60 * 60);
        
        // Refresh the page to apply server-side language filtering
        window.location.reload();
    });
    
    // Language switching now uses page refresh - no need for real-time event listeners

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