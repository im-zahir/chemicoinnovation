<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResponsiveTest extends DuskTestCase
{
    /**
     * Test responsive design on different screen sizes.
     */
    public function test_responsive_design()
    {
        $this->browse(function (Browser $browser) {
            // Mobile view (iPhone SE)
            $browser->resize(375, 667)
                ->visit('/')
                ->assertPresent('.navbar')
                ->assertPresent('.mobile-menu-button')
                ->assertMissing('.desktop-menu')
                // Test product grid responsiveness
                ->visit('/products')
                ->assertPresent('.product-grid')
                ->assertVisible('.product-card');

            // Tablet view (iPad)
            $browser->resize(768, 1024)
                ->visit('/')
                ->assertPresent('.navbar')
                ->assertPresent('.desktop-menu')
                // Test solutions grid
                ->visit('/solution')
                ->assertPresent('.solutions-grid');

            // Desktop view
            $browser->resize(1920, 1080)
                ->visit('/')
                ->assertPresent('.navbar')
                ->assertPresent('.desktop-menu')
                ->assertPresent('.hero-section');
        });
    }

    /**
     * Test navigation menu behavior across devices
     */
    public function test_navigation_menu()
    {
        $this->browse(function (Browser $browser) {
            // Mobile navigation
            $browser->resize(375, 667)
                ->visit('/')
                ->click('.mobile-menu-button')
                ->waitFor('.mobile-menu')
                ->assertVisible('.mobile-menu')
                ->assertSeeIn('.mobile-menu', 'Products')
                ->assertSeeIn('.mobile-menu', 'Solutions')
                ->assertSeeIn('.mobile-menu', 'About')
                ->assertSeeIn('.mobile-menu', 'Contact');

            // Desktop navigation
            $browser->resize(1920, 1080)
                ->visit('/')
                ->mouseover('.solutions-dropdown')
                ->waitFor('.dropdown-menu')
                ->assertVisible('.dropdown-menu')
                ->assertSeeIn('.dropdown-menu', 'Industrial Chemicals')
                ->assertSeeIn('.dropdown-menu', 'Laboratory Solutions');
        });
    }

    /**
     * Test contact form responsiveness and functionality
     */
    public function test_contact_form()
    {
        $this->browse(function (Browser $browser) {
            $devices = [
                ['width' => 375, 'height' => 667, 'name' => 'mobile'],
                ['width' => 768, 'height' => 1024, 'name' => 'tablet'],
                ['width' => 1920, 'height' => 1080, 'name' => 'desktop']
            ];

            foreach ($devices as $device) {
                $browser->resize($device['width'], $device['height'])
                    ->visit('/contact')
                    ->assertPresent('#contact-form')
                    ->type('name', 'Test User')
                    ->type('email', 'test@example.com')
                    ->type('message', 'This is a test message')
                    ->press('Send Message')
                    ->waitFor('.success-message')
                    ->assertVisible('.success-message');
            }
        });
    }

    /**
     * Test product catalog responsiveness
     */
    public function test_product_catalog()
    {
        $this->browse(function (Browser $browser) {
            // Mobile view
            $browser->resize(375, 667)
                ->visit('/products')
                ->assertPresent('.product-grid')
                ->assertPresent('.product-filters-mobile')
                ->click('.filter-toggle')
                ->waitFor('.filter-menu')
                ->assertVisible('.filter-menu');

            // Desktop view
            $browser->resize(1920, 1080)
                ->visit('/products')
                ->assertPresent('.product-grid')
                ->assertPresent('.product-filters-desktop')
                ->assertVisible('.product-filters-desktop');
        });
    }
}
