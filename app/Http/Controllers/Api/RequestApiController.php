<?php

namespace App\Http\Controllers\Api;

use App\Jobs\ExecuteRequestJob;
use App\Parsers\RequestHeaderParser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class RequestApiController extends Controller
{
    /**
     * Find all requests in the database.
     *
     * @return JsonResponse
     */
    public function indexAllRequests(): JsonResponse
    {
        $requests = \App\Request::all();

        return response()->json($requests);
    }

    /**
     * Find request in the database.
     * Throwed 404 when request is not found.
     *
     * @param int $requestId
     * @return JsonResponse
     */
    public function showSingleRequest(int $requestId): JsonResponse
    {
        $request = \App\Request::findOrFail($requestId);

        return response()->json($request);
    }

    /**
     * Validate if parameters are valid.
     * Find or create endpoint based on url and method.
     * Create a new request for the endpoint.
     * Dispatch ExecuteRequestJob
     *
     * @param Request $request
     * @return Response
     */
    public function storeRequest(Request $request): Response
    {
        $this->validate($request, [
            'url' => 'required|url',
            'method' => 'required|in:'. RequestHeaderParser::getAllowedMethods(),
        ]);

        $endpoint = \App\Endpoint::firstOrCreate($request->only('url', 'method'));
        $endpointRequest = $endpoint->requests()->create();

        $this->dispatch(new ExecuteRequestJob($endpointRequest));

        return response('', 201)->withHeaders([
            'Location' => route('api.requests.show', ['requestId' => $endpointRequest]),
        ]);
    }
}
