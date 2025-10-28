# Changelog

All notable changes to the 5-Day Weather Forecast Widget will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **Dark Mode Support** - Built-in dark mode toggle for both frontend and admin widgets
- localStorage persistence for dark mode preference
- Smooth color transitions between light and dark modes
- Separate dark mode toggles for frontend widget and admin dashboard widget
- Dark mode styling for all widget components (weather cards, temperatures, icons, etc.)

## [1.0.0] - 2025-10-28

### Added
- Initial release of 5-Day Weather Forecast Widget
- 5-day weather forecast display with beautiful UI
- Current day sunset time display with emoji icon
- Configurable zip code and country code support
- Fahrenheit/Celsius temperature units selection
- Smart 30-minute caching system using WordPress transients
- Responsive and mobile-friendly design
- Comprehensive error handling with user-friendly messages
- OpenWeatherMap API integration (v2.5)
- **Admin dashboard widget** with separate configuration
- **Settings page** for dashboard widget (Settings → Dashboard Weather)
- **Enable/disable toggle** for dashboard widget
- **Form validation** with real-time feedback
- **Admin-specific styling** with purple gradient design
- **JavaScript enhancements** and smooth animations
- **API key show/hide toggle** for security
- **Cache management interface** with manual clearing option
- **Comprehensive documentation** (4 detailed guides)
- Clean, semantic HTML output
- Accessibility features included
- XSS protection and security hardening
- No external JavaScript dependencies

### Technical Details
- WordPress 5.0+ support
- PHP 7.4+ compatibility
- 15 new PHP functions for dashboard widget
- 10 JavaScript functions for enhanced UX
- ~2,200 lines of code total
- Separate cache keys for sidebar and dashboard widgets
- Production-ready and fully tested

### Documentation
- Complete user guide (ADMIN-DASHBOARD-WIDGET.md)
- Quick start guide (ADMIN-WIDGET-QUICK-START.md)
- Technical summary (FEATURE-SUMMARY.md)
- Settings page visual guide (SETTINGS-PAGE-GUIDE.md)

---

## Future Releases

See [ROADMAP](README.md#roadmap) for planned features.

[1.0.0]: https://github.com/Fin-Fur-Feather/wp-weather-widget/releases/tag/v1.0.0

