<?php

use App\Code;
use App\Codelist;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
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
     * Check listing of codelists through API
     *
     * @return void
     */
    public function testGetCodelists()
    {
        // List all codelists
        $response = $this->json('GET', '/api/v1/codelist');

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => 1,
                'number' => 1,
                'description' => 'Notification or update type',
                'issue_number' => 0,
            ]);

        // Deleting codelists
        $response = $this->json('DELETE', '/api/v1/codelist');

        $response
            ->assertStatus(405)
            ->assertExactJson([
                'message' => '405 Method Not Allowed',
                'status_code' => 405,
            ]);        
    }

    /**
     * Check that JSON response structure is correct
     * @return void
     */
    public function testGetCodelistStructure()
    {
        // All codelists with pagination metadata
        $this->get('/api/v1/codelist')->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'number', 'description', 'number',
                ],
            ],
            'meta' => [
                'pagination' => [
                    'total', 'count', 'per_page', 'current_page', 'total_pages', 'links',
                ],
            ],
        ]);

        // Individual codelist structure
        $this->get('/api/v1/codelist/1')->assertJsonStructure([
            'data' => [
                'id', 'number', 'description', 'number',
            ],
        ]);

        // Individual codelist contents
        $this->json('GET', '/api/v1/codelist/1')->assertExactJson([
            'data' => [
                'id' => 1,
                'number' => 1,
                'description' => 'Notification or update type',
                'issue_number' => 0,
            ],
        ]);
    }

    /**
     * Tests that giving incorrect page and limit parameters return correct error message
     * @return void
     */
    public function testIncorrectPageAndLimitParameters()
    {
        // Both parameters are non-numeric
        $this->json('get', '/api/v1/codelist', ['page' => 'incorrect', 'limit' => 'incorrect'])->assertExactJson([
            'message' => 'Could not list codelists.',
            'errors' => [
                'page' => [
                    'The page must be a number.',
                ],
                'limit' => [
                    'The limit must be a number.',
                ],
            ],
            'status_code' => 422,
        ]);

        // Page is less than 1
        $this->json('get', '/api/v1/codelist', ['page' => 0])->assertExactJson([
            'message' => 'Could not list codelists.',
            'errors' => [
                'page' => [
                    'The page must be at least 1.',
                ],
            ],
            'status_code' => 422,
        ]);
    }

    /**
     * Test Onix codelist number that does not exist
     * @return void
     */
    public function testInvalidCodelistNumber()
    {
        $this->json('get', '/api/v1/codelist/12345')->assertExactJson([
            'message' => 'Could not list codelist.',
            'errors' => [
                'number' => [
                    'The selected number is invalid.',
                ],
            ],
            'status_code' => 422,
        ]);
    }
}
