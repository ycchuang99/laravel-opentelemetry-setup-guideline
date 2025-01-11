# Laravel OpenTelemetry Setup Guide

A comprehensive guide for integrating OpenTelemetry with Laravel applications to collect and analyze telemetry data.

## Prerequisites

* Laravel project
* PHP 8.2+
* Composer
* Docker and Docker Compose (optional)

## Installation Steps

### 1. PHP Extension Setup

**For Docker:**
```dockerfile
RUN pecl install opentelemetry \
    && docker-php-ext-enable opentelemetry
```

**For Non-Docker:** Follow your platform's PHP extension installation process.

### 2. Install Required Packages

```bash
composer require open-telemetry/opentelemetry
composer require open-telemetry/opentelemetry-auto-laravel
```

### 3. Environment Configuration

Add to your `.env` file:

```env
OTEL_PHP_AUTOLOAD_ENABLED=true
OTEL_PHP_INTERNAL_METRICS_ENABLED=true
OTEL_SERVICE_NAME=your-app-name
OTEL_TRACES_EXPORTER=otlp
OTEL_METRICS_EXPORTER=otlp
OTEL_EXPORTER_OTLP_PROTOCOL=http/protobuf
OTEL_EXPORTER_OTLP_ENDPOINT=http://otel-collector:4318
OTEL_PROPAGATORS=baggage,tracecontext
```

### 4. Optional Instrumentation Packages

| Package | Purpose |
|---------|---------|
| `opentelemetry-auto-psr3` | Logging instrumentation |
| `opentelemetry-auto-psr15` | HTTP server instrumentation |
| `opentelemetry-auto-psr18` | HTTP client instrumentation |
| `opentelemetry-auto-mongodb` | MongoDB instrumentation |
| `opentelemetry-auto-pdo` | Database instrumentation |

### 5. Collector Setup

Create `otel-collector-config.yaml`:

```yaml
receivers:
  otlp:
    protocols:
      http:
        endpoint: 0.0.0.0:4318
      grpc:
        endpoint: 0.0.0.0:4317

processors:
  batch:

exporters:
  zipkin:
    endpoint: "http://zipkin:9411/api/v2/spans"

service:
  pipelines:
    traces:
      receivers: [otlp]
      processors: [batch]
      exporters: [zipkin]
```

Add to `docker-compose.yml`:

```yaml
services:
  otel-collector:
    image: otel/opentelemetry-collector:latest
    command: ["--config=/etc/otel-collector-config.yaml"]
    volumes:
      - ./otel-collector-config.yaml:/etc/otel-collector-config.yaml
    ports:
      - "4317:4317"  # GRPC
      - "4318:4318"  # HTTP

  zipkin:
    image: openzipkin/zipkin
    ports:
      - "9411:9411"
```

### 6. Verification

1. Start your services:
```bash
docker-compose up -d
```

2. Access Zipkin UI at `http://localhost:9411`

## Best Practices

* Start with basic traces and gradually add custom instrumentation
* Monitor collector performance and adjust batch settings if needed
* Use sampling in production to manage data volume
* Implement proper error handling for telemetry failures

## Troubleshooting

* Verify the OpenTelemetry extension is enabled: `php -m | grep opentelemetry`
* Check collector logs: `docker-compose logs otel-collector`
* Ensure all services can communicate within Docker network
* Validate your endpoint configurations

## Additional Resources

* [OpenTelemetry Documentation](https://opentelemetry.io/docs/)
* [PHP Auto-Instrumentation Guide](https://opentelemetry.io/docs/instrumentation/php/automatic/)
* [Collector Configuration](https://opentelemetry.io/docs/collector/configuration/)
