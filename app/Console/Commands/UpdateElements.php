<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Codelist;
use App\Element;

class UpdateElements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:elements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all elements that reference to a code list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schemaPath = app_path('Schemas/ONIX_BookProduct_3.0_reference.rng');
        $schema = simplexml_load_file($schemaPath);

        // Disable Algolia auto-indexing temporarily
        Element::$autoIndex = false;

        // Go through the RelaxNG schema and find elements that reference to a Onix codelist
        foreach ($schema->define as $define) {
            foreach ($define->element as $element) {
                foreach ($element->ref as $ref) {
                    if (preg_match("/List(\d+)/", (string) $ref['name'], $output)) {
                        // Get reference and short name from optional elements
                        foreach ($element->optional as $optional) {
                            $attributeName = (string) $optional->attribute['name'];
                            switch ($attributeName) {
                                case 'refname':
                                    $referenceName = (string) $optional->attribute->value;
                                    break;
                                case 'shortname':
                                    $shortName = (string) $optional->attribute->value;
                                    break;
                            }
                        }

                        // Create element and attach the codelist to it
                        $codelist = Codelist::where('number', $output[1])->firstOrFail();
                        $element = Element::firstOrCreate(['reference_name' => $referenceName, 'short_name' => $shortName]);
                        $codelist->elements()->save($element);
                    }
                }
            }
        }

        // Reindex Algolia and set settings
        if (app()->environment() === 'production') {
            Element::clearIndices();
            Element::reindex();
            Element::setSettings();
        }
    }
}
