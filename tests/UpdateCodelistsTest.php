<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Codelist;
use App\Code;
use GuzzleHttp\Client;

class UpdateCodelistsTest extends TestCase
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
    public function testUpdateCodelistCommand()
    {
        // Codelist without codes has 0 codes
        $this->assertcount(0, Codelist::where('number', 20)->first()->codes()->get());

        // Codelist with one code
        $this->assertcount(1, Codelist::where('number', 52)->first()->codes()->get());

        // Codelist with more than one code
        $this->assertGreaterThanOrEqual(2, Codelist::where('number', 1)->first()->codes()->get()->count());

        // Check for last known codelist
        $this->assertcount(1, Codelist::where('number', 227)->get());
    }

    /**
     * Check that the amount of codelists and their codes match with the source data
     * @return void
     */
    public function testCodelistCounts()
    {
        // Create new instance of the command
        $client = new GuzzleHttp\Client();
        $updateCodelistCommand = new App\Console\Commands\UpdateCodelists($client);

        // Send Request
        $response = $client->request('GET', $updateCodelistCommand->formUri());

        // Parse codelists from response
        $onixCodelists = json_decode($response->getBody()->getContents());

        // Check that the amount of codelists in the DB correspond with the data
        $this->assertEquals(count($onixCodelists->CodeList), Codelist::all()->count());

        // Get the total amount of codelist codes
        $codeCount = 0;
        foreach ($onixCodelists->CodeList as $onixCodelist) {
            if (isset($onixCodelist->Code) && is_array($onixCodelist->Code)) {
                foreach ($onixCodelist->Code as $onixCodelistCode) {
                    $codeCount++;
                }
            }

            if (isset($onixCodelist->Code) && is_object($onixCodelist->Code)) {
                $codeCount++;
            }
        }

        // Check that amount codes correspond with the data
        $this->assertEquals($codeCount, Code::all()->count());
    }

    /**
     * Tests the formUri
     * @return void
     */
    public function testFormUri()
    {
        // Create new instance of the command and get URI
        $client = new GuzzleHttp\Client();
        $updateCodelistCommand = new App\Console\Commands\UpdateCodelists($client);
        $uri = $updateCodelistCommand->formUri();

        $expectedUri = 'http://www.editeur.org/files/ONIX%20for%20books%20-%20code%20lists/ONIX_BookProduct_Codelists_Issue_' . config('onix_codelist.issue_number') . '.json';

        $this->assertInstanceOf('League\Uri\Schemes\Http', $uri);
        $this->assertEquals($expectedUri, $uri->__toString());
    }
}
