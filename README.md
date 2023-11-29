# Laravel OpenTelemetry Setup Guideline (Optimized)

In this guide, we'll walk you through setting up OpenTelemetry for Laravel applications, allowing you to collect, process, and export telemetry data for performance insights.

To streamline the process and adhere to best practices, we'll focus on auto-instrumentation, avoiding complex manual setup.

## Prerequisites

Ensure the following prerequisites are installed:

- **Laravel**: Have a running Laravel project.
- **Composer**: Install it following the instructions [here](https://getcomposer.org/).
- **Docker and Docker Compose** (Optional): Install Docker and Docker Compose from [Docker Installation Guide](https://docs.docker.com/get-docker/) if opting for the Dockerized OpenTelemetry Collector.

Example environment:
- **PHP Version**: 8.2
- **Laravel Version**: 10

## Installation

### Step 1: Install the OpenTelemetry PHP extension

Install the extension via `pecl` inside the Dockerfile:

```
pecl install opentelemetry
RUN docker-php-ext-enable opentelemetry
```

### Step 2: Install the OpenTelemetry Library

Install necessary packages with Composer:

```
composer require open-telemetry/opentelemetry
composer require open-telemetry/opentelemetry-auto-laravel
```

# Additional packages for specific functionalities

| package name | feature | required |
| --- | --- | --- |
| `open-telemetry/opentelemetry` | opentelemetry SDK | true |
| `open-telemetry/opentelemetry-auto-laravel` | laravel auto instrument | true |
| `open-telemetry/opentelemetry-auto-psr3` | opentelemetry for log | false |
| `open-telemetry/opentelemetry-auto-psr15` | for incomming request | false |
| `open-telemetry/opentelemetry-auto-psr18` | for outgoing request | false |
| `open-telemetry/opentelemetry-auto-mongodb` | for mongodb query | false |
| `open-telemetry/opentelemetry-auto-pdo` | for pdo query | false |

### Step 3: Configure OpenTelemetry

Configure OpenTelemetry in `.env` or `php.ini`:

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

### Step 4: Setup your Zipkin application

Include Zipkin setup in `docker-compose`:

```
zipkin:
    container_name: zipkin-demo
    image: openzipkin/zipkin
    ports:
      - 9411:9411
```

## Conclusion

Congratulations on setting up OpenTelemetry for your Laravel application! Refer to the [OpenTelemetry Documentation](https://opentelemetry.io/docs/) for further customization.

## Reference

- [PHP Automatic Instrumentation](https://opentelemetry.io/docs/instrumentation/php/automatic/)
