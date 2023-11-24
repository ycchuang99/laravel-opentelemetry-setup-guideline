<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use OpenTelemetry\API\Globals;

class ExampleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        info('OpenTelemetry log example', ['request' => $request->method()]);

        $this->getMysqlData();
        $this->sendRequest();
        $this->spanExample();

        return response()->json([
            'message' => 'Hello World!',
        ]);
    }

    private function getMysqlData(): void
    {
        DB::table('opentelemetry')->get();
    }

    private function sendRequest(): void
    {
        Http::get('https://httpbin.org/get');
    }

    private function spanExample(): void
    {
        $tracerProvider = Globals::tracerProvider();
        $tracer = $tracerProvider->getTracer(
            'manual_span_example', //name (required)
            '1.0.0', //version
            'http://example.com/my-schema', //schema url
            ['foo' => 'bar'] //attributes
        );
        $span = $tracer->spanBuilder("span example")->startSpan();

        sleep(1);

        $span->end();
    }
}
