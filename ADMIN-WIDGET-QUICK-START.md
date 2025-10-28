# Admin Dashboard Widget - Quick Start Guide

Get your weather widget on the WordPress admin dashboard in under 5 minutes! ⚡

## 🎯 What You'll Need

- [ ] WordPress site with admin access
- [ ] OpenWeatherMap API key ([Get one FREE here](https://openweathermap.org/api))
- [ ] Your location's zip/postal code
- [ ] Your country code (e.g., US, CA, GB)

---

## 📋 Step-by-Step Setup

### 1️⃣ Get Your Free API Key (5 minutes)

1. Visit [openweathermap.org/api](https://openweathermap.org/api)
2. Click **Sign Up** (top right)
3. Fill in your details and create account
4. Verify your email address
5. Go to **API Keys** in your account
6. Copy your API key (save it somewhere safe!)
7. ⏰ **Wait 10-15 minutes** for API key activation

> **Tip:** While waiting, continue with the next steps!

---

### 2️⃣ Access Plugin Settings (30 seconds)

1. Log in to WordPress Admin
2. In the left sidebar, click **Settings**
3. Click **Dashboard Weather**
4. You're now on the settings page! 🎉

---

### 3️⃣ Configure Your Widget (2 minutes)

Fill in these fields:

| Field | What to Enter | Example |
|-------|--------------|---------|
| ☑️ **Enable Dashboard Widget** | Check this box | ✅ |
| 📍 **Zip Code** | Your postal/zip code | `10001` |
| 🌍 **Country Code** | Two-letter country code | `US` |
| 🔑 **API Key** | Paste your OpenWeatherMap key | `abc123xyz...` |
| 🌡️ **Temperature Units** | Choose °F or °C | `Fahrenheit (°F)` |

---

### 4️⃣ Save and View (10 seconds)

1. Click the blue **Save Settings** button
2. Wait for "Settings saved successfully!" message
3. Click **Dashboard** in the left sidebar
4. **See your weather widget!** ☀️🌧️

---

## 🎨 What You'll See

Your dashboard widget will display:

```
┌─────────────────────────────────────┐
│  5-Day Weather Forecast             │
├─────────────────────────────────────┤
│  New York                            │
│  🌅 Sunset: 6:45 PM                 │
├─────────────────────────────────────┤
│  Tue, Oct 28  [☀️]  68°F / 52°F     │
│  Clear sky                           │
│                                      │
│  Wed, Oct 29  [⛅]  65°F / 50°F      │
│  Partly cloudy                       │
│                                      │
│  Thu, Oct 30  [🌧️]  58°F / 48°F     │
│  Light rain                          │
│                                      │
│  (+ 2 more days)                     │
├─────────────────────────────────────┤
│  Widget Settings | Cached for 30 min│
└─────────────────────────────────────┘
```

---

## ❗ Troubleshooting

### Problem: Widget says "not configured"

✅ **Solution:** 
- Go back to Settings → Dashboard Weather
- Make sure BOTH Zip Code AND API Key are filled in
- Click Save Settings

### Problem: "Unable to fetch weather data"

✅ **Solution:**
- Wait 15 minutes if you just created your API key
- Check your API key at [home.openweathermap.org/api_keys](https://home.openweathermap.org/api_keys)
- Verify your zip code is correct for your country
- Make sure country code is exactly 2 letters

### Problem: Widget not showing on dashboard

✅ **Solution:**
- Check that "Enable Dashboard Widget" is ✅ checked
- Refresh your browser (Ctrl+F5 or Cmd+Shift+R)
- Scroll down on dashboard (might be below other widgets)

---

## 🎯 Quick Tips

### 💡 Refresh Weather Data

Weather is cached for 30 minutes. To force refresh:

1. Go to **Settings → Dashboard Weather**
2. Scroll to **Cache Management**
3. Click **Clear Weather Cache**
4. Return to Dashboard

### 💡 Multiple Locations

- **Dashboard Widget**: One location only
- **Sidebar Widget**: Add multiple instances for different locations
- They work independently with separate settings!

### 💡 Customize Appearance

Add custom CSS in **Appearance → Customize → Additional CSS**:

```css
/* Bigger location text */
.wfw-location-info h3 {
    font-size: 1.8em !important;
}

/* Colorful temperatures */
.wfw-temp-high {
    color: #ff4757 !important;
    font-size: 1.2em !important;
}

.wfw-temp-low {
    color: #1e90ff !important;
}
```

---

## 📊 Common Country Codes

Quick reference for setting up:

| Country | Code | Country | Code | Country | Code |
|---------|------|---------|------|---------|------|
| 🇺🇸 United States | `US` | 🇬🇧 United Kingdom | `GB` | 🇦🇺 Australia | `AU` |
| 🇨🇦 Canada | `CA` | 🇩🇪 Germany | `DE` | 🇫🇷 France | `FR` |
| 🇮🇹 Italy | `IT` | 🇪🇸 Spain | `ES` | 🇯🇵 Japan | `JP` |
| 🇨🇳 China | `CN` | 🇮🇳 India | `IN` | 🇧🇷 Brazil | `BR` |
| 🇲🇽 Mexico | `MX` | 🇳🇱 Netherlands | `NL` | 🇸🇪 Sweden | `SE` |

[Full list of country codes](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)

---

## 🔄 Widget vs Dashboard Comparison

| Feature | Sidebar Widget | Dashboard Widget |
|---------|---------------|------------------|
| **Where?** | Front-end (visitors see) | Back-end (admins see) |
| **Setup** | Appearance → Widgets | Settings → Dashboard Weather |
| **Multiple?** | ✅ Yes, unlimited | ❌ No, one instance |
| **Share API?** | ❌ Separate config | ❌ Separate config |

Both show the same weather data format! 🌤️

---

## 🎓 Next Steps

Once you're set up:

1. ✅ **Bookmark the settings page** for easy access
2. ✅ **Test different temperature units** (switch between °F and °C)
3. ✅ **Drag to reposition** the widget on your dashboard
4. ✅ **Add the sidebar widget** for your visitors (Appearance → Widgets)
5. ✅ **Customize with CSS** to match your brand colors

---

## 📚 More Documentation

- 📖 [Complete Admin Dashboard Widget Guide](ADMIN-DASHBOARD-WIDGET.md)
- 📖 [Full Plugin README](README.md)
- 🌐 [OpenWeatherMap API Docs](https://openweathermap.org/api)

---

## 🆘 Need Help?

1. Check the [Troubleshooting section](#-troubleshooting) above
2. Review the [full documentation](ADMIN-DASHBOARD-WIDGET.md)
3. Test with a different zip code
4. Verify API key status at OpenWeatherMap
5. Clear WordPress cache if using a caching plugin

---

## ✨ Pro Tips

### Save Time
- Use **Ctrl/Cmd + S** to save settings (keyboard shortcut)
- API key has a **Show/Hide button** for security
- Settings are **auto-validated** as you type

### Optimize Performance
- Leave cache at 30 minutes (default is optimal)
- Don't clear cache too frequently
- Free API tier gives 1,000 calls/day (plenty!)

### Best Practices
- **Bookmark** Settings → Dashboard Weather
- **Note down** your API key somewhere safe
- **Monitor** your API usage at OpenWeatherMap
- **Keep plugin updated** for latest features

---

**That's it! You're all set! 🎉**

Enjoy having weather forecasts right in your WordPress admin dashboard! ☀️⛅🌧️❄️

---

**Made with ❤️ by Fin Fur Feather**  
*Star us on GitHub if this helps!* ⭐

