# Cart To Checkout Timer

[![Plugin Banner](https://ps.w.org/cart-to-checkout-timer/assets/banner-1544x500.png)](https://wordpress.org/plugins/cart-to-checkout-timer/)

**Tags:** woocommerce, cart, checkout, timer, analytics \
**Tested up to:** 6.9 \
**Requires PHP:** 7.4

Track and display cart-to-checkout durations for WooCommerce.

## Description

**Cart To Checkout Timer** is a powerful WooCommerce plugin designed to help store owners monitor how long products remain in customers' carts before checkout. By tracking and displaying real-time cart-to-checkout durations, this plugin provides valuable insights to optimize the shopping experience, reduce cart abandonment, and boost conversions.

### Key Features
- **Real-Time Duration Tracking**: Displays the time each product has been in the cart on the cart, side cart, and checkout pages (e.g., "4 days 0 hours 0 minutes 0 seconds ago").
- **Block-Based Theme Compatibility**: Fully compatible with WooCommerce’s block-based cart and checkout, using dynamic DOM detection for reliable rendering.
- **Timezone Support**: Stores timestamps in UTC for consistency and displays durations in the site’s timezone (e.g., Asia/Dhaka, GMT+6).
- **Plug-and-Play**: No configuration required—just activate and start tracking.

### Benefits
- **Reduce Cart Abandonment**: Understand how long items linger in carts to identify bottlenecks and optimize checkout flows.
- **Enhanced Admin Insights**: View per-item durations in the Orders table to assess customer behavior for submitted orders.
- **Seamless Integration**: Works with block-based and classic WooCommerce themes, ensuring broad compatibility.

Built with WordPress 5.3+ best practices, the plugin uses UTC timestamps (`time()`) for reliable storage and adjusts for the site’s timezone during display. Ideal for e-commerce store owners looking to gain insights into cart-to-checkout behavior.

## Installation

1. Upload the plugin to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. The plugin is plug-and-play—no configuration needed. Timer is automatically enabled.

## Frequently Asked Questions

### How do I use this plugin?
Simply activate the plugin, and it will automatically track and display cart-to-checkout durations on the cart, side cart, and checkout pages. View durations in the WooCommerce Orders table.

### Does it work with block-based themes?
Yes, the plugin is fully compatible with WooCommerce’s block-based cart and checkout, using mutation observers to handle dynamic DOM updates.

### How are timestamps handled?
Timestamps are stored in UTC for consistency and displayed in your site’s timezone (set in **Settings > General > Timezone**), ensuring accurate duration calculations.

### Is it compatible with my WooCommerce version?
The plugin is tested with WooCommerce 8.0+ and WordPress 6.1+. Ensure your WooCommerce and WordPress versions meet the minimum requirements.

## Screenshots

### 1. Cart Page Timer

![Cart Page Timer](https://ps.w.org/cart-to-checkout-timer/assets/screenshot-1.png)

### 1. Side Cart Timer

![Cart Page Timer](https://ps.w.org/cart-to-checkout-timer/assets/screenshot-2.png)

### 1. Checkout Page Timer

![Cart Page Timer](https://ps.w.org/cart-to-checkout-timer/assets/screenshot-3.png)

### 1. Quick View Order Details Duration

![Cart Page Timer](https://ps.w.org/cart-to-checkout-timer/assets/screenshot-4.png)

### 1. Orders Details Duration

![Cart Page Timer](https://ps.w.org/cart-to-checkout-timer/assets/screenshot-5.png)

## Changelog

### 1.0.1
- Compatibility checkup for latest wp version 6.9

### 1.0.0
- Initial release.

## Upgrade Notice

Always try to keep your plugin update so that you can get the improved and additional features added to this plugin up to date.