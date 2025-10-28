# Settings Page Visual Guide

This guide shows what you'll see when configuring the admin dashboard widget.

## Accessing the Settings Page

**Navigation Path:**
```
WordPress Admin → Settings → Dashboard Weather
```

## Settings Page Layout

```
┌─────────────────────────────────────────────────────────────────┐
│ WordPress Admin                                          [User]  │
├─────────────────────────────────────────────────────────────────┤
│ 🏠 Dashboard                                                     │
│ 📄 Posts                                                         │
│ 📸 Media                                                         │
│ 📑 Pages                                                         │
│ 💬 Comments                                                      │
│ 🎨 Appearance                                                    │
│ 🔌 Plugins                                                       │
│ 👥 Users                                                         │
│ 🔧 Settings                                                      │
│    • General                                                     │
│    • Writing                                                     │
│    • Reading                                                     │
│    • Discussion                                                  │
│    • Media                                                       │
│    • Permalinks                                                  │
│    • Privacy                                                     │
│    ► Dashboard Weather  ← YOU ARE HERE                          │
└─────────────────────────────────────────────────────────────────┘
```

## Settings Form

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ Dashboard Weather Widget Settings                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

Configure the weather widget that appears on your WordPress admin 
dashboard.

┌─────────────────────────────────────────────────────────────────┐
│ Dashboard Widget Configuration                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ Enable Dashboard Widget                                         │
│ ☑ Show weather widget on admin dashboard                       │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ Zip Code                                                         │
│ ┌────────────────────────────────────┐                          │
│ │ 10001                              │                          │
│ └────────────────────────────────────┘                          │
│ Enter the zip/postal code for your location.                    │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ Country Code                                                     │
│ ┌────────────────────────────────────┐                          │
│ │ US                                 │                          │
│ └────────────────────────────────────┘                          │
│ Two-letter ISO country code (e.g., US, CA, GB, AU).            │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ OpenWeatherMap API Key                                          │
│ ┌────────────────────────────────────┐  ┌──────┐               │
│ │ ••••••••••••••••••••••••••••••••  │  │ Show │               │
│ └────────────────────────────────────┘  └──────┘               │
│ Get your free API key from OpenWeatherMap                       │
│ https://openweathermap.org/api                                  │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ Temperature Units                                                │
│ ┌────────────────────────────────────┐                          │
│ │ Fahrenheit (°F)                 ▼ │                          │
│ └────────────────────────────────────┘                          │
│   • Fahrenheit (°F)                                             │
│   • Celsius (°C)                                                │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘

           ┌─────────────────┐
           │  Save Settings  │  ← Click to save
           └─────────────────┘

────────────────────────────────────────────────────────────────────

Cache Management
────────────────────────────────────────────────────────────────────

Weather data is cached for 30 minutes. Clear the cache to force an 
immediate refresh.

           ┌──────────────────────┐
           │ Clear Weather Cache  │
           └──────────────────────┘

────────────────────────────────────────────────────────────────────

About This Plugin
────────────────────────────────────────────────────────────────────

Version: 1.0.0

This plugin provides both a sidebar widget and an admin dashboard 
widget for displaying 5-day weather forecasts.

```

## After Saving Settings

When you click "Save Settings", you'll see:

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ ✓ Settings saved successfully!                                  ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
```

## Form Validation

The settings page includes smart validation:

### Valid Input Example

```
Zip Code
┌────────────────────────────────────┐
│ 90210                              │  ✓ Valid format
└────────────────────────────────────┘
```

### Invalid Input Example

```
Zip Code
┌────────────────────────────────────┐
│ abc123                             │  
└────────────────────────────────────┘
⚠ Please enter a valid zip/postal code
```

### Country Code Auto-Formatting

**You type:** `us`  
**Automatically becomes:** `US`

```
Country Code
┌────────────────────────────────────┐
│ US                                 │  ← Auto-uppercased
└────────────────────────────────────┘
```

## Dashboard Widget Preview

After saving, go to the Dashboard to see:

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 5-Day Weather Forecast                                    [⋮]   ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃                                                                  ┃
┃   New York                                                       ┃
┃   🌅 Sunset: 6:45 PM                                            ┃
┃                                                                  ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃                                                                  ┃
┃  ┌──────────┬──────────┬──────────┬──────────┬──────────┐      ┃
┃  │ Tue,     │ Wed,     │ Thu,     │ Fri,     │ Sat,     │      ┃
┃  │ Oct 28   │ Oct 29   │ Oct 30   │ Oct 31   │ Nov 1    │      ┃
┃  │          │          │          │          │          │      ┃
┃  │   ☀️     │   ⛅     │   🌧️     │   ⛈️     │   🌤️     │      ┃
┃  │          │          │          │          │          │      ┃
┃  │  68°F    │  65°F    │  58°F    │  62°F    │  70°F    │      ┃
┃  │    /     │    /     │    /     │    /     │    /     │      ┃
┃  │  52°F    │  50°F    │  48°F    │  51°F    │  54°F    │      ┃
┃  │          │          │          │          │          │      ┃
┃  │ Clear    │ Partly   │ Light    │Thunder-  │ Mostly   │      ┃
┃  │ sky      │ cloudy   │ rain     │ storms   │ sunny    │      ┃
┃  └──────────┴──────────┴──────────┴──────────┴──────────┘      ┃
┃                                                                  ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃  Widget Settings                          Cached for 30 minutes ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
```

## Widget States

### State 1: Not Configured

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 5-Day Weather Forecast                                    [⋮]   ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃                                                                  ┃
┃    ℹ️  Weather widget is not configured yet.                    ┃
┃                                                                  ┃
┃                 ┌──────────────────────┐                         ┃
┃                 │  Configure Settings  │                         ┃
┃                 └──────────────────────┘                         ┃
┃                                                                  ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
```

### State 2: API Error

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 5-Day Weather Forecast                                    [⋮]   ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃                                                                  ┃
┃    ❌ Error: Unable to fetch weather data.                      ┃
┃                                                                  ┃
┃    Possible causes:                                              ┃
┃    • Invalid API key                                             ┃
┃    • Incorrect zip code                                          ┃
┃    • API quota exceeded                                          ┃
┃                                                                  ┃
┃    Check Settings                                                ┃
┃                                                                  ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
```

### State 3: Successfully Loaded

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 5-Day Weather Forecast                                    [⋮]   ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃   [Full weather display with 5-day forecast]                    ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
        ← See "Dashboard Widget Preview" above
```

## Mobile View

On smaller screens, the settings page adapts:

```
┌──────────────────────────┐
│ Dashboard Weather Widget │
│ Settings                 │
├──────────────────────────┤
│                          │
│ ☑ Enable Dashboard Widget│
│                          │
│ Zip Code                 │
│ ┌──────────────────────┐ │
│ │ 10001                │ │
│ └──────────────────────┘ │
│                          │
│ Country Code             │
│ ┌──────────────────────┐ │
│ │ US                   │ │
│ └──────────────────────┘ │
│                          │
│ API Key                  │
│ ┌──────────────────────┐ │
│ │ ••••••••••••••••     │ │
│ └──────────────────────┘ │
│ ┌──────┐                 │
│ │ Show │                 │
│ └──────┘                 │
│                          │
│ Temperature Units        │
│ ┌──────────────────────┐ │
│ │ Fahrenheit (°F)   ▼ │ │
│ └──────────────────────┘ │
│                          │
│  ┌──────────────────┐    │
│  │  Save Settings   │    │
│  └──────────────────┘    │
│                          │
└──────────────────────────┘
```

## Interactive Elements

### Hovering Over Forecast Day

```
Normal State:
┌──────────┐
│ Tue,     │
│ Oct 28   │
│   ☀️     │
│  68°F/52°F│
│ Clear sky│
└──────────┘

Hover State (slight lift + shadow):
┌──────────┐  ← Raised slightly
│ Tue,     │
│ Oct 28   │
│   ☀️     │
│  68°F/52°F│
│ Clear sky│
└──────────┘
   ↓ Shadow
```

### API Key Toggle

```
Hidden:                        Visible:
┌───────────────────┐          ┌───────────────────┐
│ •••••••••••••••••│          │ abc123xyz789def456│
└───────────────────┘          └───────────────────┘
┌──────┐                       ┌──────┐
│ Show │ ← Click               │ Hide │ ← Click again
└──────┘                       └──────┘
```

## Color Scheme

The widget uses a beautiful purple gradient:

```
Header Background:
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 🌈 Purple to Violet gradient ┃
┃ (#667eea → #764ba2)          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

Temperature Colors:
High: 🔴 Red (#e74c3c)
Low:  🔵 Blue (#3498db)
```

## Keyboard Shortcuts

```
⌨️ Available Shortcuts:

Ctrl + S (Windows/Linux)     Save settings
Cmd + S (Mac)                Save settings

Tab                          Navigate between fields
Enter                        Submit form
Esc                          Close any open dialogs
```

## Button States

### Primary Button

```
Normal:                    Hover:                  Active:
┌─────────────────┐       ┌─────────────────┐     ┌─────────────────┐
│  Save Settings  │  →    │  Save Settings  │  →  │  Save Settings  │
└─────────────────┘       └─────────────────┘     └─────────────────┘
  Blue                      Darker Blue             Darkest Blue
```

### Secondary Button

```
Normal:                      Hover:
┌─────────────────────┐     ┌─────────────────────┐
│ Clear Weather Cache │  →  │ Clear Weather Cache │
└─────────────────────┘     └─────────────────────┘
  Gray                        Darker Gray
```

## Responsive Grid Layout

```
Desktop (5 columns):
┌────┬────┬────┬────┬────┐
│ D1 │ D2 │ D3 │ D4 │ D5 │
└────┴────┴────┴────┴────┘

Tablet (3 columns):
┌────┬────┬────┐
│ D1 │ D2 │ D3 │
├────┼────┼────┤
│ D4 │ D5 │    │
└────┴────┴────┘

Mobile (1 column):
┌────┐
│ D1 │
├────┤
│ D2 │
├────┤
│ D3 │
├────┤
│ D4 │
├────┤
│ D5 │
└────┘
```

## Settings Page URL

Direct link format:
```
https://yoursite.com/wp-admin/options-general.php?page=wfw-dashboard-widget-settings
```

---

## Tips for Users

1. **Bookmark the Settings Page** for quick access
2. **Test with different zip codes** to verify configuration
3. **Use the Show/Hide button** to protect your API key from shoulder surfers
4. **Clear cache manually** when testing new settings
5. **Check validation messages** if form doesn't save

---

**Need more help?** Check out:
- [Complete Documentation](ADMIN-DASHBOARD-WIDGET.md)
- [Quick Start Guide](ADMIN-WIDGET-QUICK-START.md)
- [Full README](README.md)

---

*This visual guide helps you understand what to expect when configuring the admin dashboard widget.*

