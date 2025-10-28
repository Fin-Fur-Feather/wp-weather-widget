# Admin Dashboard Widget Feature

## Overview

The 5-Day Weather Forecast Plugin now includes an **Admin Dashboard Widget** that displays weather information directly on your WordPress admin dashboard. This allows site administrators to see weather forecasts without visiting the front-end of the site.

![Version](https://img.shields.io/badge/feature-admin_dashboard_widget-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)

## Features

- **Dashboard Integration** - Weather widget appears on the WordPress admin dashboard
- **Centralized Settings** - Configure from Settings → Dashboard Weather
- **Smart Display** - Beautiful, responsive design optimized for the admin interface
- **Easy Configuration** - Simple settings page with validation
- **Enable/Disable Toggle** - Turn the dashboard widget on or off
- **Cache Management** - Manual cache clearing option
- **Separate from Sidebar Widget** - Independent configuration from the sidebar widget

## Installation

The admin dashboard widget feature is included in the plugin by default. Simply activate the plugin to enable it.

## Setup Instructions

### Step 1: Access Settings

1. Log in to your WordPress Admin Dashboard
2. Navigate to **Settings → Dashboard Weather**
3. You'll see the configuration page for the admin dashboard widget

### Step 2: Configure Widget Settings

Fill in the following fields:

| Field | Description | Required | Example |
|-------|-------------|----------|---------|
| **Enable Dashboard Widget** | Checkbox to show/hide widget on dashboard | No | ☑ Checked |
| **Zip Code** | Postal code for location | Yes | 10001 |
| **Country Code** | Two-letter ISO country code | Yes | US |
| **OpenWeatherMap API Key** | Your API key | Yes | abc123xyz... |
| **Temperature Units** | Fahrenheit or Celsius | Yes | Fahrenheit (°F) |

### Step 3: Save Settings

1. Click **Save Settings** button
2. You'll see a success message
3. Navigate to **Dashboard** to view your weather widget

### Step 4: View Your Weather Widget

1. Go to **Dashboard** (main admin page)
2. You'll see the "5-Day Weather Forecast" widget
3. The widget displays:
   - Location name
   - Current day's sunset time
   - 5-day forecast with icons, temperatures, and descriptions

## Widget Location

The dashboard widget appears in the **normal column** with **high priority**, meaning it will be displayed prominently on your admin dashboard. You can drag and reposition it using WordPress's built-in dashboard customization features.

## Configuration Options

### Enable/Disable Widget

- **Enable**: Check the "Enable Dashboard Widget" checkbox
- **Disable**: Uncheck the checkbox and save
- When disabled, the widget won't appear on the dashboard

### Zip Code

- Enter your location's postal/zip code
- Validated on blur (shows warning if format seems incorrect)
- Required when widget is enabled

**Valid Formats:**
- US: 5-digit (12345) or 9-digit (12345-6789)
- Canada: A1A 1A1 or A1A1A1
- Other countries: Varies by country

### Country Code

- Two-letter ISO 3166-1 alpha-2 code
- Automatically converted to uppercase
- Required when widget is enabled

**Common Codes:**
- `US` - United States
- `CA` - Canada
- `GB` - United Kingdom
- `AU` - Australia
- `DE` - Germany
- `FR` - France
- `IT` - Italy
- `ES` - Spain
- `JP` - Japan
- `CN` - China
- `IN` - India
- `BR` - Brazil
- `MX` - Mexico

### API Key

- Your OpenWeatherMap API key
- Get a free key at [OpenWeatherMap](https://openweathermap.org/api)
- Shows/hides with toggle button for security
- Validated (warns if too short)
- Required when widget is enabled

**Free Tier Limits:**
- 1,000 API calls per day
- 60 calls per minute
- Sufficient for most WordPress sites

### Temperature Units

- **Imperial**: Fahrenheit (°F)
- **Metric**: Celsius (°C)

## Cache Management

### Automatic Caching

- Weather data is automatically cached for **30 minutes**
- Reduces API calls and improves performance
- Cache is stored using WordPress transients

### Manual Cache Clearing

To force an immediate weather update:

1. Go to **Settings → Dashboard Weather**
2. Scroll to **Cache Management** section
3. Click **Clear Weather Cache** button
4. Confirm the action
5. Return to dashboard to see fresh data

**When to Clear Cache:**
- After changing settings
- When data seems outdated
- For testing purposes
- After API errors

### Automatic Cache Clearing

Cache is automatically cleared when you:
- Update any widget settings
- Save the settings page
- Deactivate the plugin

## Display Customization

### Using Custom CSS

Add custom styles to **Appearance → Customize → Additional CSS**:

```css
/* Change widget header color */
#wfw_dashboard_weather_widget .hndle {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
}

/* Customize location heading */
.wfw-location-info h3 {
    font-size: 1.5em;
    color: #ffffff;
}

/* Style temperature colors */
.wfw-temp-high {
    color: #e74c3c;
    font-weight: 800;
}

.wfw-temp-low {
    color: #3498db;
    font-weight: 600;
}

/* Add shadow to forecast days */
.wfw-forecast-day {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Change current weather background */
.wfw-dashboard-current {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Available CSS Classes

```css
/* Main Widget */
#wfw_dashboard_weather_widget          /* Dashboard widget container */
.wfw-dashboard-weather                 /* Weather content wrapper */

/* Current Weather */
.wfw-dashboard-current                 /* Current conditions section */
.wfw-location-info                     /* Location container */
.wfw-location-info h3                  /* Location heading */
.wfw-sunset                            /* Sunset time display */

/* Forecast */
.wfw-dashboard-forecast                /* Forecast grid container */
.wfw-forecast-day                      /* Individual day card */
.wfw-day-date                          /* Date text */
.wfw-day-icon                          /* Weather icon image */
.wfw-day-temps                         /* Temperature container */
.wfw-temp-high                         /* High temperature */
.wfw-temp-separator                    /* Temperature separator (/) */
.wfw-temp-low                          /* Low temperature */
.wfw-day-description                   /* Weather description */

/* Footer */
.wfw-dashboard-footer                  /* Widget footer */
.wfw-settings-link                     /* Settings link */
.wfw-last-updated                      /* Cache info text */

/* Messages */
.wfw-dashboard-notice                  /* Info messages */
.wfw-dashboard-error                   /* Error messages */
```

## Troubleshooting

### Widget Not Appearing

**Problem:** Dashboard widget doesn't show up

**Solutions:**
1. Check if "Enable Dashboard Widget" is checked
2. Verify plugin is activated
3. Clear browser cache and refresh
4. Check WordPress user permissions (need `manage_options` capability)

### Configuration Error

**Problem:** Widget shows "Weather widget is not configured yet"

**Solutions:**
1. Go to Settings → Dashboard Weather
2. Enter both Zip Code AND API Key
3. Click Save Settings
4. Refresh dashboard

### API Error Messages

**Problem:** Widget displays "Unable to fetch weather data" or API errors

**Solutions:**

1. **Invalid API Key**
   - Verify API key at OpenWeatherMap
   - Wait 10-15 minutes after signup (activation time)
   - Check for typos in API key

2. **Invalid Zip Code**
   - Verify zip code format
   - Ensure country code matches location
   - Try alternative zip codes for your area

3. **API Quota Exceeded**
   - Free tier: 1,000 calls/day
   - Wait until midnight UTC for reset
   - Consider upgrading API plan

4. **Network Issues**
   - Check server internet connection
   - Verify firewall allows outbound HTTPS
   - Check WordPress HTTP API settings

### Cache Issues

**Problem:** Widget shows old/stale data

**Solutions:**
1. Clear weather cache from settings page
2. Wait 30 minutes for automatic refresh
3. Change any setting and save (auto-clears cache)

### Display Issues

**Problem:** Widget looks broken or unstyled

**Solutions:**
1. Clear browser cache
2. Disable conflicting plugins temporarily
3. Check for theme CSS conflicts
4. Verify admin.css file loaded (check browser console)
5. Try switching to a default theme temporarily

### JavaScript Errors

**Problem:** Settings page validation not working

**Solutions:**
1. Check browser console for errors
2. Verify admin.js file loaded
3. Check for jQuery conflicts
4. Disable other plugins temporarily

## Advanced Features

### Form Validation

The settings page includes automatic validation:

- **Zip Code**: Validates format on blur
- **Country Code**: Auto-uppercase, length check
- **API Key**: Length verification
- **Required Fields**: Checks on form submission

### Keyboard Shortcuts

**Settings Page:**
- `Ctrl + S` (Windows/Linux) or `Cmd + S` (Mac) - Save settings

### Animation Effects

- Forecast days fade in with staggered delay
- Hover effects on forecast cards
- Smooth transitions throughout

### Security Features

- Nonce verification for form submissions
- Capability checks (`manage_options`)
- Input sanitization and validation
- API key visibility toggle
- XSS protection

## API Usage

### Dashboard Widget Calls

The dashboard widget makes:
- **2 API calls** per cache period (30 minutes)
  - 1 call for current weather (sunset time)
  - 1 call for 5-day forecast
- **~96 API calls per day** (well within free tier)

### Optimization

- Separate cache from sidebar widget
- Only loads on dashboard and settings page
- Efficient transient storage
- 30-minute cache duration

## Differences from Sidebar Widget

| Feature | Sidebar Widget | Dashboard Widget |
|---------|----------------|------------------|
| **Location** | Frontend (theme widget areas) | Backend (admin dashboard) |
| **Configuration** | Appearance → Widgets | Settings → Dashboard Weather |
| **Multiple Instances** | Yes | No (single instance) |
| **Target Audience** | Site visitors | Site administrators |
| **Settings Storage** | Widget instance options | WordPress options table |
| **Cache Key** | `wfw_weather_*` | `wfw_dashboard_weather_*` |
| **Enable/Disable** | Drag to widget area | Settings checkbox |

Both widgets:
- Use the same API
- Support same temperature units
- Have 30-minute cache
- Display 5-day forecast
- Show sunset time
- Use same weather icons

## Development & Customization

### Hook into Widget Output

```php
// Filter widget data before display
add_filter('wfw_dashboard_weather_data', function($weather_data) {
    // Modify weather data
    return $weather_data;
});
```

### Modify Cache Duration

```php
// Change cache duration (default: 30 minutes)
add_filter('wfw_dashboard_cache_duration', function($duration) {
    return 60 * MINUTE_IN_SECONDS; // 60 minutes
});
```

### Custom Widget Title

```php
// Change widget title
add_filter('wfw_dashboard_widget_title', function($title) {
    return 'My Custom Weather';
});
```

### Modify Display Settings

```php
// Change number of forecast days
add_filter('wfw_dashboard_forecast_days', function($days) {
    return 3; // Show only 3 days
});
```

## Best Practices

1. **API Key Security**
   - Never share your API key
   - Use environment variables for production
   - Rotate keys periodically

2. **Performance**
   - Don't clear cache too frequently
   - Let automatic caching work
   - Monitor API usage

3. **User Experience**
   - Configure before enabling
   - Test with valid credentials
   - Provide accurate location data

4. **Maintenance**
   - Keep plugin updated
   - Monitor error logs
   - Check API quota regularly

## FAQ

**Q: Can I have multiple dashboard widgets?**  
A: No, only one dashboard widget instance is supported. Use sidebar widgets for multiple locations.

**Q: Does this affect the sidebar widget?**  
A: No, they have independent configurations and caches.

**Q: Who can see the dashboard widget?**  
A: All users who can access the WordPress dashboard.

**Q: Can I hide it for certain user roles?**  
A: Yes, using custom code to check user capabilities in the widget registration.

**Q: Does it work with multisite?**  
A: Yes, configure separately for each site in the network.

**Q: Can I display it on custom admin pages?**  
A: By default, it only appears on the main dashboard. Custom placement requires development.

**Q: Is the API key shared between sidebar and dashboard widgets?**  
A: No, they use separate API key settings for flexibility.

## Support & Resources

- **Plugin GitHub**: [github.com/Fin-Fur-Feather/wp-weather-widget](https://github.com/Fin-Fur-Feather/wp-weather-widget)
- **OpenWeatherMap Docs**: [openweathermap.org/api](https://openweathermap.org/api)
- **WordPress Dashboard Widgets**: [codex.wordpress.org/Dashboard_Widgets_API](https://codex.wordpress.org/Dashboard_Widgets_API)

## Changelog

### Admin Dashboard Widget Feature (v1.0.0)
- ✅ Dashboard widget registration
- ✅ Settings page in Settings menu
- ✅ Enable/disable toggle
- ✅ Form validation and error handling
- ✅ Cache management interface
- ✅ Responsive admin styling
- ✅ JavaScript enhancements
- ✅ Security hardening
- ✅ Separate configuration from sidebar widget

---

**Happy Weather Watching! ☀️🌧️⛅❄️**

