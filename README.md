# Laravel OpenTelemetry Setup Guideline (Not Done Yet)

In this guide, we'll walk you through the process of setting up OpenTelemetry for Laravel applications. OpenTelemetry is an open-source project that allows you to collect, process, and export telemetry data from your applications. With Laravel and OpenTelemetry, you can gain insights into the performance and behavior of your application.

To streamline the process and ensure best practices, we'll primarily focus on utilizing auto-instruments, a recommended approach for OpenTelemetry integration. As a result, this guideline will not delve into the complexities of manual setup. 

## Prerequisites

Before we begin, ensure you have the following prerequisites installed:

- **Laravel**: Make sure you have a Laravel project up and running.
- **Composer**: Ensure it is installed by following the instructions [here](https://getcomposer.org/).
- **Docker and Docker Compose** (Optional): If you wish to use the Dockerized OpenTelemetry Collector, make sure Docker and Docker Compose are installed. Follow the [Docker Installation Guide](https://docs.docker.com/get-docker/).

To provide a clear understanding of the environment used in this guide, here's an example of the PHP and Laravel versions:

- **PHP Version**: 8.2
- **Laravel Version**: 10

## Installation

### Step 1: Install the OpenTelemetry PHP extension

The first step is to install the OpenTelemetry PHP extension.

We are using `pecl` to install the extension. You can see the example inside the Dockerfile.

Install the extension:

```bash
pecl install opentelemetry
```

Add extension to php.ini file:

```bash
RUN docker-php-ext-enable opentelemetry
```

### Step 2: Install the OpenTelemetry Library 

In addition to the extension, you need to install the SDK package and one or more instrumentation packages.

Install the PHP package `open-telemetry/opentelemetry`, which already includes API/SDK/exporter and more useful packages:

```bash
composer require open-telemetry/opentelemetry
```

Install Laravel auto-instrumentation package:

```bash
composer require open-telemetry/opentelemetry-auto-laravel
```

From now you can already start setting you opentelemetry. But if you need something advance you can install the bellow package

| package name | feature | required |
| --- | --- | --- |
| open-telemetry/opentelemetry | opentelemetry SDK | true |
| open-telemetry/opentelemetry-auto-laravel | laravel auto instrument | true |
| open-telemetry/opentelemetry-auto-psr3 | opentelemetry for log | false |
| open-telemetry/opentelemetry-auto-psr15 | for incomming request | false |
| open-telemetry/opentelemetry-auto-psr18 | for outgoing request | false |
| open-telemetry/opentelemetry-auto-mongodb | for mongodb query | false |
| open-telemetry/opentelemetry-auto-pdo | for pdo query | false |

### Step 3: Configure OpenTelemetry 

You can put this config to your php.ini or .env file to automatic instrumentation
In this example we use env file you can see it in the `.env.example`

```
OTEL_PHP_AUTOLOAD_ENABLED=true
OTEL_PHP_INTERNAL_METRICS_ENABLED=true
OTEL_SERVICE_NAME=laravel-opentelemetry-demo
OTEL_TRACES_EXPORTER=zipkin
OTEL_METRICS_EXPORTER=otlp
OTEL_EXPORTER_ZIPKIN_ENDPOINT=http://zipkin:9411/api/v2/spans
OTEL_EXPORTER_OTLP_METRICS_ENDPOINT=http://collector:4318/v1/metrics
OTEL_PROPAGATORS=baggage,tracecontext
```

## Conclusion

Congratulations! You've successfully set up OpenTelemetry for your Laravel application. To further customize your telemetry setup, refer to the [OpenTelemetry Documentation](https://opentelemetry.io/docs/).

## Reference

- [PHP Automatic Instrumentation](https://opentelemetry.io/docs/instrumentation/php/automatic/)
