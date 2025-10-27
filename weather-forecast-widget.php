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
 * Enqueue widget styles
 */
function wfw_enqueue_styles() {
    if ( is_active_widget( false, false, 'weather_forecast_widget', true ) ) {
        wp_enqueue_style( 
            'wp-weather-widget', 
            WFW_PLUGIN_URL . 'assets/css/weather-widget.css', 
            array(), 
            WFW_VERSION 
        );
    }
}
add_action( 'wp_enqueue_scripts', 'wfw_enqueue_styles' );

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

