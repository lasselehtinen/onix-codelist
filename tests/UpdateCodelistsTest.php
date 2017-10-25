<?php

use App\Code;
use App\Codelist;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateCodelistsTest extends TestCase
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
    public function testUpdateCodelistCommand()
    {
        // Codelist with one code
        $this->assertcount(1, Codelist::where('number', 97)->first()->codes()->get());

        // Codelist with more than one code
        $this->assertGreaterThanOrEqual(2, Codelist::where('number', 1)->first()->codes()->get()->count());

        // Check for last known codelist
        $this->assertcount(1, Codelist::where('number', 227)->get());

        // Check that the notes are not truncated
        $code = Codelist::where('number', 1)->first()->codes()->where('value', '05')->first();
        $this->assertEquals('Use when sending an instruction to delete a record which was previously issued. Note that a Delete instruction should NOT be used when a product is cancelled, put out of print, or otherwise withdrawn from sale: this should be handled as a change of Publishing status, leaving the receiver to decide whether to retain or delete the record. A Delete instruction is used ONLY when there is a particular reason to withdraw a record completely, eg because it was issued in error', $code->notes);
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
