<?php
/**
 * Plugin Name: 5-Day Weather Forecast Widget
 * Plugin URI: https://github.com/Fin-Fur-Feather/wp-weather-widget
 * Description: Displays a 5-day weather forecast and current day's sunset time for any specified zip code using OpenWeatherMap API.
 * Version: 1.0.0
 * Author: Fin Fur Feather
 * Author URI: https://github.com/Fin-Fur-Feather
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-weather-widget
 * Domain Path: /languages
 *
 * @package WeatherForecastWidget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define( 'WFW_VERSION', '1.0.0' );
define( 'WFW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WFW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Weather Forecast Widget Class
 */
class Weather_Forecast_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'weather_forecast_widget',
            esc_html__( '5-Day Weather Forecast', 'wp-weather-widget' ),
            array( 
                'description' => esc_html__( 'Displays 5-day weather forecast and sunset time for a specified zip code.', 'wp-weather-widget' ),
                'classname' => 'wp-weather-widget'
            )
        );
    }

    /**
     * Widget frontend output
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Weather Forecast', 'wp-weather-widget' );
        $zip_code = ! empty( $instance['zip_code'] ) ? $instance['zip_code'] : '';
        $api_key = ! empty( $instance['api_key'] ) ? $instance['api_key'] : '';
        $country_code = ! empty( $instance['country_code'] ) ? $instance['country_code'] : 'US';
        $units = ! empty( $instance['units'] ) ? $instance['units'] : 'imperial';

        echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];

        if ( empty( $zip_code ) || empty( $api_key ) ) {
            echo '<p>' . esc_html__( 'Please configure the widget with your zip code and API key.', 'wp-weather-widget' ) . '</p>';
            echo $args['after_widget'];
            return;
        }

        // Get weather data
        $weather_data = $this->get_weather_data( $zip_code, $country_code, $api_key, $units );

        if ( is_wp_error( $weather_data ) ) {
            echo '<p class="weather-error">' . esc_html( $weather_data->get_error_message() ) . '</p>';
            echo $args['after_widget'];
            return;
        }

        // Display weather
        $this->display_weather( $weather_data, $units );

        echo $args['after_widget'];
    }

    /**
     * Get weather data from API with caching
     */
    private function get_weather_data( $zip_code, $country_code, $api_key, $units ) {
        // Create cache key
        $cache_key = 'wfw_weather_' . md5( $zip_code . $country_code . $units );
        
        // Try to get cached data
        $cached_data = get_transient( $cache_key );
        if ( false !== $cached_data ) {
            return $cached_data;
        }

        // Fetch current weather and sunset time
        $current_url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?zip=%s,%s&appid=%s&units=%s',
            urlencode( $zip_code ),
            urlencode( $country_code ),
            urlencode( $api_key ),
            urlencode( $units )
        );

        $current_response = wp_remote_get( $current_url, array( 'timeout' => 15 ) );

        if ( is_wp_error( $current_response ) ) {
            return new WP_Error( 'api_error', esc_html__( 'Unable to fetch current weather data.', 'wp-weather-widget' ) );
        }

        $current_body = wp_remote_retrieve_body( $current_response );
        $current_data = json_decode( $current_body, true );

        if ( ! $current_data || isset( $current_data['cod'] ) && $current_data['cod'] != 200 ) {
            $error_message = isset( $current_data['message'] ) ? $current_data['message'] : esc_html__( 'Invalid response from weather service.', 'wp-weather-widget' );
            return new WP_Error( 'api_error', $error_message );
        }

        // Fetch 5-day forecast
        $forecast_url = sprintf(
            'https://api.openweathermap.org/data/2.5/forecast?zip=%s,%s&appid=%s&units=%s',
            urlencode( $zip_code ),
            urlencode( $country_code ),
            urlencode( $api_key ),
            urlencode( $units )
        );

        $forecast_response = wp_remote_get( $forecast_url, array( 'timeout' => 15 ) );

        if ( is_wp_error( $forecast_response ) ) {
            return new WP_Error( 'api_error', esc_html__( 'Unable to fetch forecast data.', 'wp-weather-widget' ) );
        }

        $forecast_body = wp_remote_retrieve_body( $forecast_response );
        $forecast_data = json_decode( $forecast_body, true );

        if ( ! $forecast_data || isset( $forecast_data['cod'] ) && $forecast_data['cod'] != 200 ) {
            return new WP_Error( 'api_error', esc_html__( 'Invalid forecast response.', 'wp-weather-widget' ) );
        }

        // Combine data
        $weather_data = array(
            'current' => $current_data,
            'forecast' => $forecast_data
        );

        // Cache for 30 minutes
        set_transient( $cache_key, $weather_data, 30 * MINUTE_IN_SECONDS );

        return $weather_data;
    }

    /**
     * Display weather data
     */
    private function display_weather( $weather_data, $units ) {
        $temp_unit = ( $units === 'imperial' ) ? '°F' : '°C';
        $current = $weather_data['current'];
        $forecast = $weather_data['forecast'];

        // Dark mode toggle
        echo '<label class="wfw-dark-mode-toggle">';
        echo '<input type="checkbox" id="wfw-dark-mode-checkbox" class="wfw-dark-mode-input">';
        echo '<span class="wfw-toggle-switch"></span>';
        echo '<span class="wfw-toggle-label">🌙 ' . esc_html__( 'Dark Mode', 'wp-weather-widget' ) . '</span>';
        echo '</label>';

        // Display location and current sunset time
        echo '<div class="weather-current">';
        echo '<p class="weather-location"><strong>' . esc_html( $current['name'] ) . '</strong></p>';
        
        if ( isset( $current['sys']['sunset'] ) ) {
            $sunset_time = date_i18n( get_option( 'time_format' ), $current['sys']['sunset'] );
            echo '<p class="weather-sunset">🌅 ' . esc_html__( 'Sunset: ', 'wp-weather-widget' ) . '<strong>' . esc_html( $sunset_time ) . '</strong></p>';
        }
        echo '</div>';

        // Process forecast data - get one forecast per day
        $daily_forecasts = $this->process_daily_forecasts( $forecast['list'] );

        echo '<div class="weather-forecast">';
        
        $count = 0;
        foreach ( $daily_forecasts as $day ) {
            if ( $count >= 5 ) break;
            
            $date = date_i18n( 'D, M j', $day['dt'] );
            $temp_high = round( $day['temp_max'] );
            $temp_low = round( $day['temp_min'] );
            $description = ucfirst( $day['description'] );
            $icon_code = $day['icon'];
            $icon_url = "https://openweathermap.org/img/wn/{$icon_code}.png";

            echo '<div class="weather-day">';
            echo '<div class="weather-date">' . esc_html( $date ) . '</div>';
            echo '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $description ) . '" class="weather-icon">';
            echo '<div class="weather-temp">';
            echo '<span class="temp-high">' . esc_html( $temp_high . $temp_unit ) . '</span> / ';
            echo '<span class="temp-low">' . esc_html( $temp_low . $temp_unit ) . '</span>';
            echo '</div>';
            echo '<div class="weather-description">' . esc_html( $description ) . '</div>';
            echo '</div>';

            $count++;
        }
        
        echo '</div>';
    }

    /**
     * Process forecast data into daily forecasts
     */
    private function process_daily_forecasts( $forecast_list ) {
        $daily_data = array();
        
        foreach ( $forecast_list as $forecast ) {
            $date = date( 'Y-m-d', $forecast['dt'] );
            
            if ( ! isset( $daily_data[ $date ] ) ) {
                $daily_data[ $date ] = array(
                    'dt' => $forecast['dt'],
                    'temp_max' => $forecast['main']['temp_max'],
                    'temp_min' => $forecast['main']['temp_min'],
                    'description' => $forecast['weather'][0]['description'],
                    'icon' => $forecast['weather'][0]['icon']
                );
            } else {
                // Update max and min temps
                $daily_data[ $date ]['temp_max'] = max( $daily_data[ $date ]['temp_max'], $forecast['main']['temp_max'] );
                $daily_data[ $date ]['temp_min'] = min( $daily_data[ $date ]['temp_min'], $forecast['main']['temp_min'] );
            }
        }
        
        return array_values( $daily_data );
    }

    /**
     * Widget backend form
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Weather Forecast', 'wp-weather-widget' );
        $zip_code = ! empty( $instance['zip_code'] ) ? $instance['zip_code'] : '';
        $api_key = ! empty( $instance['api_key'] ) ? $instance['api_key'] : '';
        $country_code = ! empty( $instance['country_code'] ) ? $instance['country_code'] : 'US';
        $units = ! empty( $instance['units'] ) ? $instance['units'] : 'imperial';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_html_e( 'Title:', 'wp-weather-widget' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" 
                   value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'zip_code' ) ); ?>">
                <?php esc_html_e( 'Zip Code:', 'wp-weather-widget' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'zip_code' ) ); ?>" 
                   name="<?php echo esc_attr( $this->get_field_name( 'zip_code' ) ); ?>" type="text" 
                   value="<?php echo esc_attr( $zip_code ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'country_code' ) ); ?>">
                <?php esc_html_e( 'Country Code:', 'wp-weather-widget' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'country_code' ) ); ?>" 
                   name="<?php echo esc_attr( $this->get_field_name( 'country_code' ) ); ?>" type="text" 
                   value="<?php echo esc_attr( $country_code ); ?>" placeholder="US">
            <small><?php esc_html_e( 'Two-letter country code (e.g., US, CA, GB)', 'wp-weather-widget' ); ?></small>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>">
                <?php esc_html_e( 'OpenWeatherMap API Key:', 'wp-weather-widget' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>" 
                   name="<?php echo esc_attr( $this->get_field_name( 'api_key' ) ); ?>" type="text" 
                   value="<?php echo esc_attr( $api_key ); ?>">
            <small>
                <?php 
                printf(
                    /* translators: %s: OpenWeatherMap API URL */
                    esc_html__( 'Get your free API key from %s', 'wp-weather-widget' ),
                    '<a href="https://openweathermap.org/api" target="_blank">OpenWeatherMap</a>'
                );
                ?>
            </small>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'units' ) ); ?>">
                <?php esc_html_e( 'Temperature Units:', 'wp-weather-widget' ); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'units' ) ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( 'units' ) ); ?>">
                <option value="imperial" <?php selected( $units, 'imperial' ); ?>>
                    <?php esc_html_e( 'Fahrenheit (°F)', 'wp-weather-widget' ); ?>
                </option>
                <option value="metric" <?php selected( $units, 'metric' ); ?>>
                    <?php esc_html_e( 'Celsius (°C)', 'wp-weather-widget' ); ?>
                </option>
            </select>
        </p>
        <?php
    }

    /**
     * Update widget settings
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['zip_code'] = ( ! empty( $new_instance['zip_code'] ) ) ? sanitize_text_field( $new_instance['zip_code'] ) : '';
        $instance['api_key'] = ( ! empty( $new_instance['api_key'] ) ) ? sanitize_text_field( $new_instance['api_key'] ) : '';
        $instance['country_code'] = ( ! empty( $new_instance['country_code'] ) ) ? sanitize_text_field( $new_instance['country_code'] ) : 'US';
        $instance['units'] = ( ! empty( $new_instance['units'] ) ) ? sanitize_text_field( $new_instance['units'] ) : 'imperial';
        
        // Clear cache when settings are updated
        $cache_key = 'wfw_weather_' . md5( $instance['zip_code'] . $instance['country_code'] . $instance['units'] );
        delete_transient( $cache_key );
        
        return $instance;
    }
}

/**
 * Register Weather Widget
 */
function wfw_register_weather_widget() {
    register_widget( 'Weather_Forecast_Widget' );
}
add_action( 'widgets_init', 'wfw_register_weather_widget' );

/**
 * Enqueue widget styles and scripts
 */
function wfw_enqueue_styles() {
    if ( is_active_widget( false, false, 'weather_forecast_widget', true ) ) {
        wp_enqueue_style( 
            'wp-weather-widget', 
            WFW_PLUGIN_URL . 'assets/css/weather-widget.css', 
            array(), 
            WFW_VERSION 
        );
        
        wp_enqueue_script( 
            'wp-weather-widget', 
            WFW_PLUGIN_URL . 'assets/js/weather-widget.js', 
            array( 'jquery' ), 
            WFW_VERSION, 
            true 
        );
    }
}
add_action( 'wp_enqueue_scripts', 'wfw_enqueue_styles' );

/**
 * Enqueue admin styles and scripts
 */
function wfw_enqueue_admin_assets( $hook ) {
    // Load on dashboard and settings page
    if ( 'index.php' === $hook || 'settings_page_wfw-dashboard-widget-settings' === $hook ) {
        wp_enqueue_style( 
            'wp-weather-widget-admin', 
            WFW_PLUGIN_URL . 'assets/css/admin.css', 
            array(), 
            WFW_VERSION 
        );
        
        wp_enqueue_script( 
            'wp-weather-widget-admin', 
            WFW_PLUGIN_URL . 'assets/js/admin.js', 
            array( 'jquery' ), 
            WFW_VERSION, 
            true 
        );
    }
}
add_action( 'admin_enqueue_scripts', 'wfw_enqueue_admin_assets' );

/**
 * Register Dashboard Widget
 */
function wfw_add_dashboard_widget() {
    // Check if dashboard widget is enabled
    $enabled = get_option( 'wfw_dashboard_enabled', '1' );
    if ( $enabled !== '1' ) {
        return;
    }
    
    wp_add_dashboard_widget(
        'wfw_dashboard_weather_widget',
        esc_html__( '5-Day Weather Forecast', 'wp-weather-widget' ),
        'wfw_render_dashboard_widget',
        null,
        null,
        'normal',
        'high'
    );
}
add_action( 'wp_dashboard_setup', 'wfw_add_dashboard_widget' );

/**
 * Render Dashboard Widget
 */
function wfw_render_dashboard_widget() {
    // Get settings
    $zip_code = get_option( 'wfw_dashboard_zip_code', '' );
    $api_key = get_option( 'wfw_dashboard_api_key', '' );
    $country_code = get_option( 'wfw_dashboard_country_code', 'US' );
    $units = get_option( 'wfw_dashboard_units', 'imperial' );
    
    // Check if configured
    if ( empty( $zip_code ) || empty( $api_key ) ) {
        echo '<div class="wfw-dashboard-notice">';
        echo '<p>' . esc_html__( 'Weather widget is not configured yet.', 'wp-weather-widget' ) . '</p>';
        echo '<p><a href="' . esc_url( admin_url( 'options-general.php?page=wfw-dashboard-widget-settings' ) ) . '" class="button button-primary">';
        echo esc_html__( 'Configure Settings', 'wp-weather-widget' );
        echo '</a></p>';
        echo '</div>';
        return;
    }
    
    // Get weather data
    $weather_data = wfw_get_dashboard_weather_data( $zip_code, $country_code, $api_key, $units );
    
    if ( is_wp_error( $weather_data ) ) {
        echo '<div class="wfw-dashboard-error">';
        echo '<p><strong>' . esc_html__( 'Error:', 'wp-weather-widget' ) . '</strong> ' . esc_html( $weather_data->get_error_message() ) . '</p>';
        echo '<p><a href="' . esc_url( admin_url( 'options-general.php?page=wfw-dashboard-widget-settings' ) ) . '">';
        echo esc_html__( 'Check Settings', 'wp-weather-widget' );
        echo '</a></p>';
        echo '</div>';
        return;
    }
    
    // Display weather
    wfw_display_dashboard_weather( $weather_data, $units );
    
    // Add refresh button
    echo '<div class="wfw-dashboard-footer">';
    echo '<a href="' . esc_url( admin_url( 'options-general.php?page=wfw-dashboard-widget-settings' ) ) . '" class="wfw-settings-link">';
    echo esc_html__( 'Widget Settings', 'wp-weather-widget' );
    echo '</a>';
    echo '<span class="wfw-last-updated">' . esc_html__( 'Cached for 30 minutes', 'wp-weather-widget' ) . '</span>';
    echo '</div>';
}

/**
 * Get weather data for dashboard widget
 */
function wfw_get_dashboard_weather_data( $zip_code, $country_code, $api_key, $units ) {
    // Create cache key
    $cache_key = 'wfw_dashboard_weather_' . md5( $zip_code . $country_code . $units );
    
    // Try to get cached data
    $cached_data = get_transient( $cache_key );
    if ( false !== $cached_data ) {
        return $cached_data;
    }
    
    // Fetch current weather and sunset time
    $current_url = sprintf(
        'https://api.openweathermap.org/data/2.5/weather?zip=%s,%s&appid=%s&units=%s',
        urlencode( $zip_code ),
        urlencode( $country_code ),
        urlencode( $api_key ),
        urlencode( $units )
    );
    
    $current_response = wp_remote_get( $current_url, array( 'timeout' => 15 ) );
    
    if ( is_wp_error( $current_response ) ) {
        return new WP_Error( 'api_error', esc_html__( 'Unable to fetch current weather data.', 'wp-weather-widget' ) );
    }
    
    $current_body = wp_remote_retrieve_body( $current_response );
    $current_data = json_decode( $current_body, true );
    
    if ( ! $current_data || isset( $current_data['cod'] ) && $current_data['cod'] != 200 ) {
        $error_message = isset( $current_data['message'] ) ? $current_data['message'] : esc_html__( 'Invalid response from weather service.', 'wp-weather-widget' );
        return new WP_Error( 'api_error', $error_message );
    }
    
    // Fetch 5-day forecast
    $forecast_url = sprintf(
        'https://api.openweathermap.org/data/2.5/forecast?zip=%s,%s&appid=%s&units=%s',
        urlencode( $zip_code ),
        urlencode( $country_code ),
        urlencode( $api_key ),
        urlencode( $units )
    );
    
    $forecast_response = wp_remote_get( $forecast_url, array( 'timeout' => 15 ) );
    
    if ( is_wp_error( $forecast_response ) ) {
        return new WP_Error( 'api_error', esc_html__( 'Unable to fetch forecast data.', 'wp-weather-widget' ) );
    }
    
    $forecast_body = wp_remote_retrieve_body( $forecast_response );
    $forecast_data = json_decode( $forecast_body, true );
    
    if ( ! $forecast_data || isset( $forecast_data['cod'] ) && $forecast_data['cod'] != 200 ) {
        return new WP_Error( 'api_error', esc_html__( 'Invalid forecast response.', 'wp-weather-widget' ) );
    }
    
    // Combine data
    $weather_data = array(
        'current' => $current_data,
        'forecast' => $forecast_data
    );
    
    // Cache for 30 minutes
    set_transient( $cache_key, $weather_data, 30 * MINUTE_IN_SECONDS );
    
    return $weather_data;
}

/**
 * Display weather data in dashboard
 */
function wfw_display_dashboard_weather( $weather_data, $units ) {
    $temp_unit = ( $units === 'imperial' ) ? '°F' : '°C';
    $current = $weather_data['current'];
    $forecast = $weather_data['forecast'];
    
    echo '<div class="wfw-dashboard-weather">';
    
    // Display location and current conditions
    echo '<div class="wfw-dashboard-current">';
    echo '<div class="wfw-location-info">';
    echo '<h3>' . esc_html( $current['name'] ) . '</h3>';
    
    if ( isset( $current['sys']['sunset'] ) ) {
        $sunset_time = date_i18n( get_option( 'time_format' ), $current['sys']['sunset'] );
        echo '<p class="wfw-sunset">🌅 ' . esc_html__( 'Sunset: ', 'wp-weather-widget' ) . '<strong>' . esc_html( $sunset_time ) . '</strong></p>';
    }
    echo '</div>';
    echo '</div>';
    
    // Process and display forecast
    $daily_forecasts = wfw_process_daily_forecasts( $forecast['list'] );
    
    echo '<div class="wfw-dashboard-forecast">';
    
    $count = 0;
    foreach ( $daily_forecasts as $day ) {
        if ( $count >= 5 ) break;
        
        $date = date_i18n( 'D, M j', $day['dt'] );
        $temp_high = round( $day['temp_max'] );
        $temp_low = round( $day['temp_min'] );
        $description = ucfirst( $day['description'] );
        $icon_code = $day['icon'];
        $icon_url = "https://openweathermap.org/img/wn/{$icon_code}@2x.png";
        
        echo '<div class="wfw-forecast-day">';
        echo '<div class="wfw-day-date">' . esc_html( $date ) . '</div>';
        echo '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $description ) . '" class="wfw-day-icon">';
        echo '<div class="wfw-day-temps">';
        echo '<span class="wfw-temp-high">' . esc_html( $temp_high . $temp_unit ) . '</span>';
        echo '<span class="wfw-temp-separator">/</span>';
        echo '<span class="wfw-temp-low">' . esc_html( $temp_low . $temp_unit ) . '</span>';
        echo '</div>';
        echo '<div class="wfw-day-description">' . esc_html( $description ) . '</div>';
        echo '</div>';
        
        $count++;
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Process forecast data into daily forecasts
 */
function wfw_process_daily_forecasts( $forecast_list ) {
    $daily_data = array();
    
    foreach ( $forecast_list as $forecast ) {
        $date = date( 'Y-m-d', $forecast['dt'] );
        
        if ( ! isset( $daily_data[ $date ] ) ) {
            $daily_data[ $date ] = array(
                'dt' => $forecast['dt'],
                'temp_max' => $forecast['main']['temp_max'],
                'temp_min' => $forecast['main']['temp_min'],
                'description' => $forecast['weather'][0]['description'],
                'icon' => $forecast['weather'][0]['icon']
            );
        } else {
            // Update max and min temps
            $daily_data[ $date ]['temp_max'] = max( $daily_data[ $date ]['temp_max'], $forecast['main']['temp_max'] );
            $daily_data[ $date ]['temp_min'] = min( $daily_data[ $date ]['temp_min'], $forecast['main']['temp_min'] );
        }
    }
    
    return array_values( $daily_data );
}

/**
 * Add settings menu
 */
function wfw_add_settings_menu() {
    add_options_page(
        esc_html__( 'Dashboard Weather Widget Settings', 'wp-weather-widget' ),
        esc_html__( 'Dashboard Weather', 'wp-weather-widget' ),
        'manage_options',
        'wfw-dashboard-widget-settings',
        'wfw_render_settings_page'
    );
}
add_action( 'admin_menu', 'wfw_add_settings_menu' );

/**
 * Register settings
 */
function wfw_register_settings() {
    register_setting( 'wfw_dashboard_settings', 'wfw_dashboard_enabled' );
    register_setting( 'wfw_dashboard_settings', 'wfw_dashboard_zip_code' );
    register_setting( 'wfw_dashboard_settings', 'wfw_dashboard_country_code' );
    register_setting( 'wfw_dashboard_settings', 'wfw_dashboard_api_key' );
    register_setting( 'wfw_dashboard_settings', 'wfw_dashboard_units' );
    
    add_settings_section(
        'wfw_dashboard_main_section',
        esc_html__( 'Dashboard Widget Configuration', 'wp-weather-widget' ),
        'wfw_settings_section_callback',
        'wfw-dashboard-widget-settings'
    );
    
    add_settings_field(
        'wfw_dashboard_enabled',
        esc_html__( 'Enable Dashboard Widget', 'wp-weather-widget' ),
        'wfw_enabled_field_callback',
        'wfw-dashboard-widget-settings',
        'wfw_dashboard_main_section'
    );
    
    add_settings_field(
        'wfw_dashboard_zip_code',
        esc_html__( 'Zip Code', 'wp-weather-widget' ),
        'wfw_zip_code_field_callback',
        'wfw-dashboard-widget-settings',
        'wfw_dashboard_main_section'
    );
    
    add_settings_field(
        'wfw_dashboard_country_code',
        esc_html__( 'Country Code', 'wp-weather-widget' ),
        'wfw_country_code_field_callback',
        'wfw-dashboard-widget-settings',
        'wfw_dashboard_main_section'
    );
    
    add_settings_field(
        'wfw_dashboard_api_key',
        esc_html__( 'OpenWeatherMap API Key', 'wp-weather-widget' ),
        'wfw_api_key_field_callback',
        'wfw-dashboard-widget-settings',
        'wfw_dashboard_main_section'
    );
    
    add_settings_field(
        'wfw_dashboard_units',
        esc_html__( 'Temperature Units', 'wp-weather-widget' ),
        'wfw_units_field_callback',
        'wfw-dashboard-widget-settings',
        'wfw_dashboard_main_section'
    );
}
add_action( 'admin_init', 'wfw_register_settings' );

/**
 * Settings section callback
 */
function wfw_settings_section_callback() {
    echo '<p>' . esc_html__( 'Configure the weather widget that appears on your WordPress admin dashboard.', 'wp-weather-widget' ) . '</p>';
}

/**
 * Enabled field callback
 */
function wfw_enabled_field_callback() {
    $value = get_option( 'wfw_dashboard_enabled', '1' );
    ?>
    <label>
        <input type="checkbox" name="wfw_dashboard_enabled" value="1" <?php checked( $value, '1' ); ?>>
        <?php esc_html_e( 'Show weather widget on admin dashboard', 'wp-weather-widget' ); ?>
    </label>
    <?php
}

/**
 * Zip code field callback
 */
function wfw_zip_code_field_callback() {
    $value = get_option( 'wfw_dashboard_zip_code', '' );
    ?>
    <input type="text" name="wfw_dashboard_zip_code" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
    <p class="description"><?php esc_html_e( 'Enter the zip/postal code for your location.', 'wp-weather-widget' ); ?></p>
    <?php
}

/**
 * Country code field callback
 */
function wfw_country_code_field_callback() {
    $value = get_option( 'wfw_dashboard_country_code', 'US' );
    ?>
    <input type="text" name="wfw_dashboard_country_code" value="<?php echo esc_attr( $value ); ?>" class="regular-text" placeholder="US">
    <p class="description"><?php esc_html_e( 'Two-letter ISO country code (e.g., US, CA, GB, AU).', 'wp-weather-widget' ); ?></p>
    <?php
}

/**
 * API key field callback
 */
function wfw_api_key_field_callback() {
    $value = get_option( 'wfw_dashboard_api_key', '' );
    ?>
    <input type="text" name="wfw_dashboard_api_key" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
    <p class="description">
        <?php 
        printf(
            /* translators: %s: OpenWeatherMap API URL */
            esc_html__( 'Get your free API key from %s', 'wp-weather-widget' ),
            '<a href="https://openweathermap.org/api" target="_blank">OpenWeatherMap</a>'
        );
        ?>
    </p>
    <?php
}

/**
 * Units field callback
 */
function wfw_units_field_callback() {
    $value = get_option( 'wfw_dashboard_units', 'imperial' );
    ?>
    <select name="wfw_dashboard_units">
        <option value="imperial" <?php selected( $value, 'imperial' ); ?>><?php esc_html_e( 'Fahrenheit (°F)', 'wp-weather-widget' ); ?></option>
        <option value="metric" <?php selected( $value, 'metric' ); ?>><?php esc_html_e( 'Celsius (°C)', 'wp-weather-widget' ); ?></option>
    </select>
    <?php
}

/**
 * Render settings page
 */
function wfw_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Handle cache clearing
    if ( isset( $_POST['wfw_clear_cache'] ) && check_admin_referer( 'wfw_clear_cache_action', 'wfw_clear_cache_nonce' ) ) {
        global $wpdb;
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wfw_dashboard_weather_%'" );
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_wfw_dashboard_weather_%'" );
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Weather cache cleared successfully!', 'wp-weather-widget' ) . '</p></div>';
    }
    
    // Show success message
    if ( isset( $_GET['settings-updated'] ) ) {
        // Clear cache when settings are updated
        global $wpdb;
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wfw_dashboard_weather_%'" );
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_wfw_dashboard_weather_%'" );
        
        add_settings_error( 'wfw_messages', 'wfw_message', esc_html__( 'Settings saved successfully!', 'wp-weather-widget' ), 'success' );
    }
    
    settings_errors( 'wfw_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <form method="post" action="options.php">
            <?php
            settings_fields( 'wfw_dashboard_settings' );
            do_settings_sections( 'wfw-dashboard-widget-settings' );
            submit_button( esc_html__( 'Save Settings', 'wp-weather-widget' ) );
            ?>
        </form>
        
        <hr>
        
        <h2><?php esc_html_e( 'Cache Management', 'wp-weather-widget' ); ?></h2>
        <p><?php esc_html_e( 'Weather data is cached for 30 minutes. Clear the cache to force an immediate refresh.', 'wp-weather-widget' ); ?></p>
        
        <form method="post">
            <?php wp_nonce_field( 'wfw_clear_cache_action', 'wfw_clear_cache_nonce' ); ?>
            <input type="submit" name="wfw_clear_cache" class="button button-secondary" value="<?php esc_attr_e( 'Clear Weather Cache', 'wp-weather-widget' ); ?>">
        </form>
        
        <hr>
        
        <h2><?php esc_html_e( 'About This Plugin', 'wp-weather-widget' ); ?></h2>
        <p><?php esc_html_e( 'Version:', 'wp-weather-widget' ); ?> <strong><?php echo esc_html( WFW_VERSION ); ?></strong></p>
        <p><?php esc_html_e( 'This plugin provides both a sidebar widget and an admin dashboard widget for displaying 5-day weather forecasts.', 'wp-weather-widget' ); ?></p>
    </div>
    <?php
}

/**
 * Plugin activation hook
 */
function wfw_activate() {
    // Clear any existing cache on activation
    global $wpdb;
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wfw_weather_%'" );
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_wfw_weather_%'" );
}
register_activation_hook( __FILE__, 'wfw_activate' );

/**
 * Plugin deactivation hook
 */
function wfw_deactivate() {
    // Clear cache on deactivation
    global $wpdb;
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wfw_weather_%'" );
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_wfw_weather_%'" );
}
register_deactivation_hook( __FILE__, 'wfw_deactivate' );

