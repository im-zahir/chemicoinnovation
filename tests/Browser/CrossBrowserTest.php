<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CrossBrowserTest extends DuskTestCase
{
    /**
     * Test basic functionality across browsers
     */
    public function test_basic_functionality()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertTitle('Chemico Innovation')
                ->assertSee('Welcome to Chemico')
                ->assertPresent('.navbar')
                ->assertPresent('.hero-section')
                ->assertPresent('.footer')
                // Test navigation links
                ->clickLink('Products')
                ->assertPathIs('/products')
                ->clickLink('About')
                ->assertPathIs('/about')
                ->clickLink('Contact')
                ->assertPathIs('/contact');
        });
    }

    /**
     * Test solutions page functionality
     */
    public function test_solutions_functionality()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/solution')
                // Test solution cards
                ->assertPresent('.solution-card')
                ->assertSee('Industrial Chemicals')
                ->assertSee('Laboratory Solutions')
                ->assertSee('Custom Formulations')
                // Test solution details modal
                ->click('.solution-card:first-child')
                ->waitFor('.solution-modal')
                ->assertVisible('.solution-modal')
                ->assertSee('Learn More')
                ->click('.close-modal')
                ->waitUntilMissing('.solution-modal');
        });
    }

    /**
     * Test product catalog functionality
     */
    public function test_product_catalog()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                // Test category filter
                ->assertPresent('.category-filter')
                ->click('.category-dropdown')
                ->waitFor('.category-options')
                ->assertVisible('.category-options')
                
                // Test search functionality
                ->type('search', 'chemical')
                ->waitFor('.search-results')
                ->assertPresent('.product-card')
                
                // Test product details
                ->click('.product-card:first-child')
                ->assertPathBeginsWith('/products/')
                ->assertPresent('.product-details')
                ->assertPresent('.product-specifications');
        });
    }

    /**
     * Test contact form functionality
     */
    public function test_contact_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                // Test form validation
                ->press('Send Message')
                ->assertPresent('.error-message')
                
                // Test successful submission
                ->type('name', 'Test User')
                ->type('email', 'test@example.com')
                ->type('message', 'This is a test message')
                ->press('Send Message')
                ->waitFor('.success-message')
                ->assertSee('Thank you for your message');
        });
    }

    /**
     * Test about page components
     */
    public function test_about_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about')
                // Test about sections
                ->assertPresent('.about-hero')
                ->assertPresent('.company-history')
                ->assertPresent('.team-section')
                
                // Test team member cards
                ->assertPresent('.team-card')
                ->click('.team-card:first-child')
                ->waitFor('.team-modal')
                ->assertVisible('.team-modal')
                ->assertPresent('.team-member-details');
        });
    }
}
