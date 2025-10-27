# 5-Day Weather Forecast Widget

A WordPress plugin that displays a beautiful 5-day weather forecast with current day's sunset time for any specified zip code.

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)
![PHP](https://img.shields.io/badge/php-7.4%2B-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

## Features

- ✅ **5-Day Weather Forecast** - Shows detailed weather predictions
- ✅ **Sunset Time** - Displays current day's sunset time
- ✅ **Weather Icons** - Visual weather condition indicators
- ✅ **Temperature Display** - High/low temperatures for each day
- ✅ **Flexible Units** - Choose between Fahrenheit (°F) or Celsius (°C)
- ✅ **Smart Caching** - Caches data for 30 minutes to reduce API calls
- ✅ **Responsive Design** - Works beautifully on all devices
- ✅ **Easy Configuration** - Simple widget settings interface
- ✅ **Error Handling** - User-friendly error messages
- ✅ **Free API** - Uses OpenWeatherMap free tier (1,000 calls/day)

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Free OpenWeatherMap API key ([Get one here](https://openweathermap.org/api))

## Installation

### Method 1: Upload via WordPress Admin

1. Download the plugin ZIP file
2. Log in to WordPress Admin
3. Navigate to **Plugins → Add New → Upload Plugin**
4. Choose the ZIP file and click **Install Now**
5. Click **Activate Plugin**

### Method 2: Manual Installation

1. Download the plugin files
2. Upload the `weather-widget` folder to `/wp-content/plugins/`
3. Log in to WordPress Admin
4. Navigate to **Plugins**
5. Find "5-Day Weather Forecast Widget" and click **Activate**

### Method 3: FTP Installation

1. Extract the plugin ZIP file
2. Upload the `weather-widget` folder to your WordPress installation's `/wp-content/plugins/` directory via FTP
3. Activate the plugin through the **Plugins** menu in WordPress

## Setup Guide

### Step 1: Get Your Free API Key

1. Visit [OpenWeatherMap](https://openweathermap.org/api)
2. Click **Sign Up** to create a free account
3. Verify your email address
4. Navigate to **API Keys** in your account
5. Copy your API key (it may take 10-15 minutes to activate)

**Free Tier Limits:**
- 1,000 API calls per day
- 60 calls per minute
- Perfect for personal and small business websites

### Step 2: Add the Widget

1. Go to **Appearance → Widgets** in WordPress Admin
2. Find the **5-Day Weather Forecast** widget
3. Drag it to your desired widget area (Sidebar, Footer, etc.)

### Step 3: Configure Settings

| Setting | Description | Example |
|---------|-------------|---------|
| **Title** | Widget heading displayed on your site | "Local Weather" |
| **Zip Code** | Postal code for the location | "10001" |
| **Country Code** | Two-letter ISO country code | "US" |
| **API Key** | Your OpenWeatherMap API key | "abc123..." |
| **Temperature Units** | Fahrenheit or Celsius | "Fahrenheit (°F)" |

**Common Country Codes:**
- `US` - United States
- `CA` - Canada
- `GB` - United Kingdom
- `AU` - Australia
- `DE` - Germany
- `FR` - France
- `IT` - Italy
- `ES` - Spain
- `JP` - Japan

### Step 4: Save and View

Click **Save** and visit your website to see the weather widget in action!

## Usage

Once configured, the widget automatically displays:

```
┌──────────────────────────┐
│   Local Weather          │
├──────────────────────────┤
│   New York               │
│   🌅 Sunset: 6:45 PM     │
├──────────────────────────┤
│ Mon, Oct 28  [☀️]        │
│ 68°F / 52°F              │
│ Clear sky                │
│                          │
│ Tue, Oct 29  [⛅]         │
│ 65°F / 50°F              │
│ Partly cloudy            │
│                          │
│ (3 more days...)         │
└──────────────────────────┘
```

## Customization

### Custom Styling

Add custom CSS to **Appearance → Customize → Additional CSS**:

```css
/* Customize widget container */
.weather-forecast-widget {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
}

/* Customize location text */
.weather-forecast-widget .weather-location {
    font-size: 1.5em;
    color: #0066cc;
}

/* Customize temperature colors */
.weather-forecast-widget .temp-high {
    color: #ff6347;
}

.weather-forecast-widget .temp-low {
    color: #4169e1;
}

/* Add custom hover effects */
.weather-forecast-widget .weather-day:hover {
    background: #e8f4f8;
    transform: scale(1.02);
}
```

### Available CSS Classes

```css
.weather-forecast-widget          /* Main widget container */
.weather-current                  /* Current conditions section */
.weather-location                 /* Location name */
.weather-sunset                   /* Sunset time display */
.weather-forecast                 /* Forecast container */
.weather-day                      /* Individual day container */
.weather-date                     /* Date text */
.weather-icon                     /* Weather icon image */
.weather-temp                     /* Temperature container */
.temp-high                        /* High temperature */
.temp-low                         /* Low temperature */
.weather-description              /* Weather description */
.weather-error                    /* Error message styling */
```

## Troubleshooting

### Widget shows "Please configure..."

**Solution:** Make sure you've entered both the zip code AND API key, then click Save.

### Widget shows API error

**Possible causes:**
- API key not yet activated (wait 10-15 minutes after signing up)
- Invalid zip code format
- Incorrect country code
- API quota exceeded (free tier: 1,000 calls/day)

**Solutions:**
1. Verify your API key is activated at OpenWeatherMap
2. Check that your zip code is valid for the specified country
3. Ensure country code is exactly 2 letters (e.g., "US" not "USA")
4. Check if you've exceeded your daily API limit

### Weather data not updating

**Solution:** The widget caches data for 30 minutes. To force a refresh:
- Change any widget setting and save
- Wait 30 minutes for automatic cache expiration
- Deactivate and reactivate the plugin to clear all cache

### Widget appears unstyled

**Solution:**
1. Clear your browser cache
2. Check for CSS conflicts with your theme
3. Ensure the plugin is properly activated

## Frequently Asked Questions

**Q: Is this plugin free?**  
A: Yes, the plugin is completely free. You'll need a free OpenWeatherMap API key.

**Q: How many widgets can I add?**  
A: You can add as many widgets as you want for different locations.

**Q: Can I show weather for multiple cities?**  
A: Yes! Add multiple widget instances with different zip codes.

**Q: Will this slow down my website?**  
A: No. The plugin uses smart caching (30-minute intervals) to minimize API calls and ensure fast loading.

**Q: What happens if I exceed the API limit?**  
A: The widget will display an error message until your daily quota resets (midnight UTC).

**Q: Can I change the number of forecast days?**  
A: Currently, the widget shows 5 days. You can modify the code if you need fewer days.

**Q: Does it work with page builders?**  
A: Yes! The widget works with any theme or page builder that supports WordPress widgets.

## Technical Details

### API Usage

- Uses OpenWeatherMap API v2.5
- Makes 2 API calls per data refresh:
  - Current weather (for sunset time)
  - 5-day forecast (for daily predictions)
- Caches results for 30 minutes using WordPress transients
- Total API calls: ~96 per day per widget (well within free tier)

### Performance

- Lightweight code with minimal resource usage
- Efficient caching strategy
- Asynchronous API calls with 15-second timeout
- Responsive images optimized for fast loading

### Security

- All user inputs are sanitized
- API calls use secure HTTPS
- XSS protection enabled
- Follows WordPress coding standards
- No external JavaScript dependencies

### Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Support

For support, feature requests, or bug reports:
- Create an issue on GitHub
- Contact the developer at your-email@example.com
- Check documentation at your-website.com

## Changelog

### Version 1.0.0 (2025-10-27)
- Initial release
- 5-day weather forecast display
- Current day sunset time
- Configurable zip code and country
- Fahrenheit/Celsius temperature units
- Smart caching system
- Responsive design
- Error handling
- OpenWeatherMap API integration

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Credits

- Weather data provided by [OpenWeatherMap](https://openweathermap.org/)
- Weather icons from OpenWeatherMap
- Developed with ❤️ for the WordPress community

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Author

**Your Name**
- Website: [your-website.com](https://your-website.com)
- GitHub: [@yourusername](https://github.com/yourusername)

---

Made with ☕ and 💻 | [Report an Issue](https://github.com/yourusername/weather-forecast-widget/issues)

