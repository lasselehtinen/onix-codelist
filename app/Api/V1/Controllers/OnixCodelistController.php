<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Codelist;
use Dingo\Api\Routing\Helpers;
use App\Api\V1\Transformers\CodelistTransformer;
use Dingo\Api\Exception\ResourceException;
use Validator;

/**
 * @Resource("Onix codelists", uri="/api/v1/codelist")
 */
class OnixCodelistController extends Controller
{
    use Helpers;

    /**
     * Show all codelists
     *
     * Get a JSON representation of all Onix codelists.
     *
     * @Get("/{?page,limit,include}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("page", type="integer", description="The page of results to view.", default=1),
     *      @Parameter("limit", type="integer", description="The amount of results per page.", default=25),
     *      @Parameter("include", type="enum", description="Available additional details to request.", members={
     *          @Member("codes", description="The code values that the codelist has")
     *      })
     * })
     * @Transaction({
     *      @Response(200, body={"id":1,"number":1,"description":"Notification or update type code","issue_number":0}),
     *      @Response(422, body={"message":"Could not list codelists.","errors":{"page":{"The page must be a number."}},"status_code":422}),
     *      @Response(422, body={"message":"Could not list codelists.","errors":{"page":{"The page must be at least 1."}},"status_code":422}),
     *      @Response(422, body={"message":"Could not list codelists.","errors":{"limit":{"The limit must be a number."}},"status_code":422}),
     *      @Response(422, body={"message":"Could not list codelists.","errors":{"limit":{"The limit must be at least 1."}},"status_code":422}),
     * })
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'  => 'numeric|min:1',
            'limit' => 'numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\ResourceException('Could not list codelists.', $validator->errors());
        }

        $codelists = Codelist::paginate($request->input('limit', 25));

        return $this->response->paginator($codelists, new CodelistTransformer);
    }

    /**
     * Show the specified Codelist
     *
     * Show a spesific codelist by the codelist number.
     *
     * @Get("/{number}?include={include}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("number", type="integer", required=true, description="Number of the codelist"),
     *      @Parameter("include", type="enum", description="Available additional details to request.", members={
     *          @Member("codes", description="The code values that the codelist has")
     *      })
     * })
     * @Transaction({
     *      @Response(200, body={"id":1,"number":1,"description":"Notification or update type code","issue_number":0}),
     *      @Response(422, body={"message":"Could not list codelist.","errors":{"number":{"The number must be a number."}},"status_code":422}),
     *      @Response(422, body={"message":"Could not list codelist.","errors":{"number":{"The selected number is invalid."}},"status_code":422})
     * })
     * @param  int  $number
     * @return Response
     */
    public function show($number)
    {
        $validator = Validator::make(['number' => $number], [
            'number'  => 'numeric|exists:codelists,number',
        ]);

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\ResourceException('Could not list codelist.', $validator->errors());
        }

        $codelist = Codelist::where('number', $number)->first();

        return $this->response->item($codelist, new CodelistTransformer);
    }
}
