<?php

use App\Code;
use App\Codelist;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WebSiteTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        // Migrate and seed the database
        Artisan::call('migrate');
        Artisan::call('update:codelists');
    }

    /**
     * Check that different types of codelists are parsed correctly
     *
     * @return void
     */
    public function testFrontPageRedirect()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/codelist');
    }

    /**
     * Test that requesting a non-existing page returns a 404
     * @return void
     */
    public function testNonExistingPage()
    {
        $response = $this->get('/this_page_does_not_exist');
        $response->assertStatus(404);
    }
}
