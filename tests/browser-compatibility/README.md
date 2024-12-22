# Browser Compatibility Testing

This directory contains tests and configurations for ensuring cross-browser and cross-device compatibility of the Chemico website.

## Supported Browsers and Versions

- Chrome (latest 3 versions)
- Firefox (latest 3 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile Safari (iOS latest 2 versions)
- Chrome for Android (latest 2 versions)

## Testing Tools

- Laravel Dusk for browser automation testing
- BrowserStack integration for cross-browser testing
- Responsive design testing using different viewport sizes

## Running Tests

```bash
# Run all browser tests
php artisan dusk

# Run specific browser test suite
php artisan dusk --group browsers

# Run mobile device tests
php artisan dusk --group mobile
```

## Test Coverage

1. **Functional Testing**
   - Navigation and routing
   - Form submissions
   - AJAX requests
   - JavaScript functionality
   - CSS rendering

2. **Responsive Design Testing**
   - Mobile devices (320px - 480px)
   - Tablets (481px - 768px)
   - Small laptops (769px - 1024px)
   - Desktops (1025px+)

3. **Performance Testing**
   - Page load times
   - Asset loading
   - JavaScript execution
   - Network requests

## Adding New Tests

1. Create a new test class in `tests/Browser`
2. Extend the `DuskTestCase` class
3. Implement test methods using Laravel Dusk's API
4. Add appropriate testing groups
