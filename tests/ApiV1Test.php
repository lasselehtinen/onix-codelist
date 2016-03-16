<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Codelist;
use App\Code;
use GuzzleHttp\Client;

class ApiV1Test extends TestCase
{
    /**
     * Check listing of codelists through API
     *
     * @return void
     */
    public function testGetCodelists()
    {
        $this->get('/api/v1/codelist')->seeJson([
            'number' => 1,
        ]);

        $this->delete('/api/v1/codelist')->seeJson([
            'message' => '405 Method Not Allowed',
        ]);
    }
}
