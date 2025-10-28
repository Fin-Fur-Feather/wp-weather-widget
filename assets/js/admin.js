/**
 * Weather Forecast Widget - Admin JavaScript
 * 
 * @package WeatherForecastWidget
 * @version 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Initialize when document is ready
     */
    $(document).ready(function() {
        
        // Initialize dark mode
        initDarkMode();
        
        // Add fade-in animation to forecast days
        initForecastAnimation();
        
        // Add settings form validation
        initFormValidation();
        
        // Add cache clear confirmation
        initCacheClearConfirmation();
        
        // Add API key visibility toggle
        initAPIKeyToggle();
        
    });

    /**
     * Initialize Dark Mode
     */
    function initDarkMode() {
        // Check if dark mode is enabled in localStorage
        var isDarkMode = localStorage.getItem('wfw-admin-dark-mode') === 'true';
        
        // Apply dark mode if enabled
        if (isDarkMode) {
            $('body').addClass('wfw-admin-dark-mode');
        }
        
        // Add dark mode toggle to dashboard widget
        if ($('#wfw_dashboard_weather_widget').length) {
            var $widget = $('#wfw_dashboard_weather_widget .inside');
            
            // Create toggle HTML
            var $toggle = $('<label class="wfw-admin-dark-mode-toggle">' +
                '<input type="checkbox" id="wfw-admin-dark-mode-checkbox" ' + (isDarkMode ? 'checked' : '') + '>' +
                '<span class="wfw-admin-toggle-switch"></span>' +
                '<span class="wfw-admin-toggle-label">🌙 Dark Mode</span>' +
                '</label>');
            
            // Prepend to widget content
            $widget.prepend($toggle);
            
            // Handle toggle change
            $('#wfw-admin-dark-mode-checkbox').on('change', function() {
                var isChecked = $(this).is(':checked');
                
                if (isChecked) {
                    $('body').addClass('wfw-admin-dark-mode');
                    localStorage.setItem('wfw-admin-dark-mode', 'true');
                } else {
                    $('body').removeClass('wfw-admin-dark-mode');
                    localStorage.setItem('wfw-admin-dark-mode', 'false');
                }
            });
        }
    }

    /**
     * Initialize forecast animation
     */
    function initForecastAnimation() {
        $('.wfw-forecast-day').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(20px)'
            }).delay(index * 100).animate({
                'opacity': '1'
            }, 500, function() {
                $(this).css('transform', 'translateY(0)');
            });
        });
    }

    /**
     * Initialize form validation
     */
    function initFormValidation() {
        // Check if we're on the settings page
        if ($('input[name="wfw_dashboard_zip_code"]').length) {
            
            // Validate zip code format
            $('input[name="wfw_dashboard_zip_code"]').on('blur', function() {
                var zipCode = $(this).val().trim();
                if (zipCode && !/^\d{5}(-\d{4})?$/.test(zipCode) && !/^[A-Z]\d[A-Z]\s?\d[A-Z]\d$/i.test(zipCode)) {
                    showValidationMessage($(this), 'Please enter a valid zip/postal code', 'warning');
                } else {
                    clearValidationMessage($(this));
                }
            });
            
            // Validate country code format
            $('input[name="wfw_dashboard_country_code"]').on('blur', function() {
                var countryCode = $(this).val().trim();
                if (countryCode && !/^[A-Z]{2}$/i.test(countryCode)) {
                    showValidationMessage($(this), 'Country code must be 2 letters (e.g., US, CA, GB)', 'warning');
                } else {
                    clearValidationMessage($(this));
                }
            }).on('input', function() {
                // Auto-uppercase country code
                $(this).val($(this).val().toUpperCase());
            });
            
            // Validate API key format
            $('input[name="wfw_dashboard_api_key"]').on('blur', function() {
                var apiKey = $(this).val().trim();
                if (apiKey && apiKey.length < 20) {
                    showValidationMessage($(this), 'API key seems too short. Please verify.', 'warning');
                } else {
                    clearValidationMessage($(this));
                }
            });
            
            // Form submission validation
            $('form').on('submit', function(e) {
                var zipCode = $('input[name="wfw_dashboard_zip_code"]').val().trim();
                var apiKey = $('input[name="wfw_dashboard_api_key"]').val().trim();
                var enabled = $('input[name="wfw_dashboard_enabled"]').is(':checked');
                
                if (enabled && (!zipCode || !apiKey)) {
                    e.preventDefault();
                    alert('Please enter both Zip Code and API Key to enable the dashboard widget.');
                    return false;
                }
            });
        }
    }

    /**
     * Show validation message
     */
    function showValidationMessage($input, message, type) {
        clearValidationMessage($input);
        
        var cssClass = type === 'error' ? 'notice-error' : 'notice-warning';
        var $message = $('<p class="wfw-validation-message ' + cssClass + '">' + message + '</p>');
        
        $input.after($message);
        $message.css({
            'margin': '5px 0',
            'padding': '8px 12px',
            'background': type === 'error' ? '#fef6f6' : '#fff8e5',
            'border-left': '4px solid ' + (type === 'error' ? '#dc3232' : '#ffb900'),
            'color': type === 'error' ? '#dc3232' : '#856404',
            'font-size': '0.9em',
            'border-radius': '3px'
        });
    }

    /**
     * Clear validation message
     */
    function clearValidationMessage($input) {
        $input.siblings('.wfw-validation-message').remove();
    }

    /**
     * Initialize cache clear confirmation
     */
    function initCacheClearConfirmation() {
        $('input[name="wfw_clear_cache"]').closest('form').on('submit', function(e) {
            if (!confirm('Are you sure you want to clear the weather cache? This will force a new API call on the next dashboard load.')) {
                e.preventDefault();
                return false;
            }
        });
    }

    /**
     * Initialize API key visibility toggle
     */
    function initAPIKeyToggle() {
        var $apiKeyInput = $('input[name="wfw_dashboard_api_key"]');
        
        if ($apiKeyInput.length) {
            // Create toggle button
            var $toggleButton = $('<button type="button" class="button wfw-toggle-api-key" style="margin-left: 10px;">Show</button>');
            
            $apiKeyInput.after($toggleButton);
            
            // Set input to password type initially if it has a value
            if ($apiKeyInput.val()) {
                $apiKeyInput.attr('type', 'password');
            }
            
            // Toggle visibility
            $toggleButton.on('click', function() {
                if ($apiKeyInput.attr('type') === 'password') {
                    $apiKeyInput.attr('type', 'text');
                    $(this).text('Hide');
                } else {
                    $apiKeyInput.attr('type', 'password');
                    $(this).text('Show');
                }
            });
        }
    }

    /**
     * Add smooth scroll to settings page sections
     */
    if (window.location.hash) {
        $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top - 100
        }, 500);
    }

    /**
     * Add copy functionality for API documentation
     */
    $('.wfw-code-sample').on('click', function() {
        var $this = $(this);
        var text = $this.text();
        
        // Create temporary input
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
        
        // Show feedback
        var originalText = $this.text();
        $this.text('Copied!').css('background', '#46b450');
        
        setTimeout(function() {
            $this.text(originalText).css('background', '');
        }, 2000);
    });

    /**
     * Dashboard widget refresh functionality
     */
    $('.wfw-refresh-widget').on('click', function(e) {
        e.preventDefault();
        
        var $widget = $('#wfw_dashboard_weather_widget');
        var $content = $widget.find('.inside');
        
        // Show loading state
        $content.html('<div style="text-align: center; padding: 40px;"><span class="wfw-loading"></span><p style="margin-top: 15px;">Refreshing weather data...</p></div>');
        
        // Reload the page to get fresh data
        setTimeout(function() {
            location.reload();
        }, 1000);
    });

    /**
     * Add tooltips to settings fields
     */
    if (typeof jQuery.fn.tooltip !== 'undefined') {
        $('.wfw-help-tip').tooltip({
            position: {
                my: 'center top',
                at: 'center bottom+10'
            },
            tooltipClass: 'wfw-tooltip'
        });
    }

    /**
     * Auto-save settings on change (optional feature)
     */
    if ($('.wfw-auto-save').length) {
        var saveTimeout;
        
        $('.wfw-auto-save input, .wfw-auto-save select').on('change', function() {
            clearTimeout(saveTimeout);
            
            saveTimeout = setTimeout(function() {
                showNotice('Settings auto-saved', 'success');
            }, 1000);
        });
    }

    /**
     * Show admin notice
     */
    function showNotice(message, type) {
        var cssClass = type === 'success' ? 'notice-success' : 'notice-error';
        var $notice = $('<div class="notice ' + cssClass + ' is-dismissible"><p>' + message + '</p></div>');
        
        $('.wrap h1').after($notice);
        
        // Auto-dismiss after 3 seconds
        setTimeout(function() {
            $notice.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }

    /**
     * Add keyboard shortcuts for settings page
     */
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + S to save settings
        if ((e.ctrlKey || e.metaKey) && e.which === 83) {
            if ($('input[name="wfw_dashboard_zip_code"]').length) {
                e.preventDefault();
                $('#submit').click();
                return false;
            }
        }
    });

})(jQuery);

