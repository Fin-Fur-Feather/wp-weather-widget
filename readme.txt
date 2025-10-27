=== 5-Day Weather Forecast Widget ===
Contributors: Fin-Fur-Feather
Tags: weather, forecast, widget, openweathermap, sunset, temperature
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display a beautiful 5-day weather forecast with sunset time for any zip code using OpenWeatherMap API.

== Description ==

The **5-Day Weather Forecast Widget** is a lightweight and easy-to-use WordPress plugin that displays current weather conditions, today's sunset time, and a detailed 5-day forecast for any location you specify.

Perfect for:
* Local businesses wanting to show local weather
* Travel blogs highlighting destination weather
* Outdoor activity websites (hunting, fishing, hiking)
* Community websites serving specific locations
* Any site wanting to provide useful weather information

= Key Features =

* **5-Day Weather Forecast** - Detailed daily predictions
* **Sunset Time Display** - Shows today's sunset time with emoji icon
* **Weather Icons** - Beautiful visual weather indicators
* **High/Low Temperatures** - Daily temperature ranges
* **Flexible Temperature Units** - Choose Fahrenheit or Celsius
* **Smart Caching** - Updates every 30 minutes to save API calls
* **Fully Responsive** - Looks great on all devices
* **Easy Configuration** - Simple widget settings
* **Error Handling** - User-friendly error messages
* **Free to Use** - Works with OpenWeatherMap free tier

= How It Works =

1. Get a free API key from OpenWeatherMap (1,000 calls/day free)
2. Install and activate the plugin
3. Add the widget to your sidebar or footer
4. Enter your zip code and API key
5. Save and enjoy beautiful weather forecasts!

= Widget Display =

The widget shows:
* Location name
* Today's sunset time (with 🌅 emoji)
* 5-day forecast with:
  - Day and date
  - Weather icon
  - High and low temperatures
  - Weather description (Clear sky, Partly cloudy, etc.)

= Smart Caching =

The plugin caches weather data for 30 minutes, which means:
* Fast loading times for your visitors
* Minimal API calls (about 96 per day per widget)
* No risk of exceeding free API limits
* Reduced server load

= Developer Friendly =

* Clean, well-documented code
* Follows WordPress coding standards
* Multiple CSS classes for easy customization
* Secure coding practices
* No jQuery or external dependencies

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to Plugins → Add New
3. Search for "5-Day Weather Forecast Widget"
4. Click "Install Now" then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to WordPress admin panel
3. Go to Plugins → Add New → Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Click "Activate Plugin"

= Configuration =

1. Get a free API key from [OpenWeatherMap](https://openweathermap.org/api)
2. Go to Appearance → Widgets
3. Find "5-Day Weather Forecast" widget
4. Drag it to your desired widget area
5. Fill in the settings:
   - Title (optional)
   - Zip Code (required)
   - Country Code (e.g., US, CA, GB)
   - API Key (required)
   - Temperature Units (Fahrenheit or Celsius)
6. Click Save

== Frequently Asked Questions ==

= Do I need an API key? =

Yes, you need a free API key from OpenWeatherMap. Sign up at [openweathermap.org](https://openweathermap.org/api) - it only takes a minute and is completely free.

= How much does the API cost? =

The OpenWeatherMap free tier includes 1,000 API calls per day, which is more than enough for most websites. This plugin uses smart caching to minimize API usage.

= How often does the weather update? =

Weather data is cached for 30 minutes. After that, the next visitor will trigger a fresh update. This keeps your data current while respecting API limits.

= Can I show weather for multiple locations? =

Yes! Simply add multiple widget instances with different zip codes to display weather for different locations.

= What if my API key doesn't work? =

After signing up for an API key, it can take 10-15 minutes to activate. If it still doesn't work:
- Verify you copied the entire API key
- Check that your zip code is valid
- Ensure your country code is correct (2 letters, e.g., "US")

= Will this slow down my website? =

No. The plugin uses efficient caching and lightweight code. Weather data loads quickly and doesn't impact page performance.

= Can I customize the styling? =

Yes! The widget includes multiple CSS classes for easy customization. Add your custom CSS to Appearance → Customize → Additional CSS.

= Does it work with my theme? =

Yes! The plugin works with any WordPress theme that supports widgets.

= Does it work with page builders? =

Yes! The plugin works with any page builder that supports WordPress widgets (Elementor, WPBakery, Beaver Builder, etc.).

= What happens if I exceed the API limit? =

If you exceed 1,000 calls per day, the widget will show an error message until your quota resets at midnight UTC. The smart caching makes this very unlikely.

= Can I change the number of forecast days? =

The widget shows 5 days by default. You can modify the PHP code if you need fewer days.

= Is the sunset time accurate? =

Yes, sunset times are provided by OpenWeatherMap based on the location's coordinates and are accurate to the minute.

== Screenshots ==

1. Widget displaying 5-day forecast with sunset time
2. Widget configuration settings in WordPress admin
3. Responsive design on mobile devices
4. Multiple widgets showing different locations
5. Custom styled widget with theme integration

== Changelog ==

= 1.0.0 - 2025-10-27 =
* Initial release
* 5-day weather forecast display
* Current day sunset time display
* Configurable zip code and country code
* Fahrenheit/Celsius temperature units
* Smart 30-minute caching system
* Responsive and mobile-friendly design
* Comprehensive error handling
* OpenWeatherMap API integration
* Clean, semantic HTML output
* Accessibility features included

== Upgrade Notice ==

= 1.0.0 =
Initial release of the 5-Day Weather Forecast Widget. Install and enjoy beautiful weather forecasts on your WordPress site!

== Usage ==

After activation:

1. Navigate to **Appearance → Widgets**
2. Find **5-Day Weather Forecast** in available widgets
3. Drag to sidebar, footer, or any widget area
4. Configure settings:
   - **Title**: Display name for the widget
   - **Zip Code**: Postal code for weather location
   - **Country Code**: Two-letter country code (US, CA, etc.)
   - **API Key**: Your OpenWeatherMap API key
   - **Temperature Units**: Fahrenheit (°F) or Celsius (°C)
5. Click **Save**
6. View your site to see the weather widget!

== Support ==

Need help? Here's how to get support:

* Check the FAQ section above
* Read the detailed documentation in README.md
* Visit [your-support-page.com]
* Email: your-email@example.com

== Credits ==

* Weather data provided by [OpenWeatherMap](https://openweathermap.org/)
* Weather icons courtesy of OpenWeatherMap
* Developed for the WordPress community

== Privacy Policy ==

This plugin:
* Does not collect any user data
* Does not use cookies
* Does not track visitors
* Only makes API calls to OpenWeatherMap with the zip code you provide
* Does not share data with third parties (except OpenWeatherMap for weather data)

== Technical Details ==

* **API Calls**: 2 calls per refresh (current weather + 5-day forecast)
* **Cache Duration**: 30 minutes using WordPress transients
* **API Timeout**: 15 seconds
* **Daily API Usage**: ~96 calls per day per widget
* **Supported PHP**: 7.4+
* **Supported WordPress**: 5.0+
* **Dependencies**: None (uses WordPress core functions)

== Roadmap ==

Planned features for future releases:
* Shortcode support
* Multiple location management
* Wind speed and humidity display
* Sunrise time display
* Weather alerts integration
* Admin dashboard widget
* Hourly forecast option
* Dark mode styling option

== Author ==

Developed by Fin Fur Feather
* Website: [github.com/Fin-Fur-Feather](https://github.com/Fin-Fur-Feather)
* GitHub: [github.com/Fin-Fur-Feather](https://github.com/Fin-Fur-Feather)

== License ==

This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

This plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

