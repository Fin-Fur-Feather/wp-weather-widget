/**
 * Weather Forecast Widget - Frontend JavaScript
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
        initDarkMode();
    });

    /**
     * Initialize Dark Mode for Weather Widget
     */
    function initDarkMode() {
        // Check if dark mode is enabled in localStorage
        var isDarkMode = localStorage.getItem('wfw-dark-mode') === 'true';
        
        // Apply dark mode if enabled
        if (isDarkMode) {
            $('body').addClass('wfw-dark-mode');
            $('.wfw-dark-mode-input').prop('checked', true);
        }
        
        // Handle toggle change
        $('.wfw-dark-mode-input').on('change', function() {
            var isChecked = $(this).is(':checked');
            
            if (isChecked) {
                $('body').addClass('wfw-dark-mode');
                localStorage.setItem('wfw-dark-mode', 'true');
            } else {
                $('body').removeClass('wfw-dark-mode');
                localStorage.setItem('wfw-dark-mode', 'false');
            }
        });
    }

})(jQuery);
