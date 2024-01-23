<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenTelemetry\API\Globals;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Support\Facades\Http;

class ExampleController extends Controller
{
    public function __construct()
    {
    }

    public function index(ServerRequestInterface $request): JsonResponse
    {
        info('OpenTelemetry log example', [
            'body' => $request->getParsedBody(),
            'attributes' => $request->getAttributes(),
        ]);

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
        Http::get('http://192.168.0.100:8001/api/example');
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

        sleep(1); //do some work (required)

        $span->end();
    }
}
