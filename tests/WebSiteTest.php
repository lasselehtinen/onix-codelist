<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Codelist;
use App\Code;
use GuzzleHttp\Client;

class WebSiteTest extends TestCase
{
    protected static $databaseSeeded = false;

    public function setUp()
    {
        parent::setUp();

        // Migrate and seed the database
        if (self::$databaseSeeded === false) {
            Artisan::call('migrate:refresh');
            Artisan::call('update:codelists');
            self::$databaseSeeded = true;
        }
    }

    /**
     * Check that different types of codelists are parsed correctly
     *
     * @return void
     */
    public function testFrontPageRedirect()
    {
        $response = $this->call('GET', '/');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/codelist');
    }

    /**
     * Test that clicking the menu items redirects you to correct page
     * @return void
     */
    public function testMenus()
    {
        $this->visit('/')->click('Codelists')->seePageIs('/codelist')->see('Onix codelists');
        $this->visit('/')->click('API')->seePageIs('/api-docs')->see('API documentation');
        $this->visit('/')->click('About')->seePageIs('/about')->see('About ONIX for Books codelists');
    }

    /**
     * Test that requesting a non-existing page returns a 404
     * @return void
     */
    public function testNonExistingPage()
    {
        $response = $this->call('GET', 'this_page_does_not_exist');
        $this->assertResponseStatus(404);
    }
}
