# Laravel OpenTelemetry Setup Guideline

This guide provides a streamlined approach to setting up OpenTelemetry for your Laravel application, enabling you to effortlessly collect, process, and export telemetry data for valuable performance insights.

**Focus:**

* **Auto-instrumentation:** Minimal manual configuration for a smooth setup.
* **Best practices:** Adheres to recommended techniques for efficient data collection.
* **Docker-friendliness:** Optional Docker configurations for simplified deployment.

**Prerequisites:**

* **Laravel:** Existing Laravel project.
* **Composer:** Installed following instructions at [https://getcomposer.org/download/](https://getcomposer.org/download/)
* **Docker and Docker Compose (Optional):** For Dockerized OpenTelemetry Collector, install via [https://docs.docker.com/get-docker/](https://docs.docker.com/get-docker/)

**Example Environment:**

* PHP Version: 8.2
* Laravel Version: 10

**Installation:**

**1. OpenTelemetry PHP extension:**

* **Dockerfile:** Install the `opentelemetry` extension via `pecl`:

```
pecl install opentelemetry
RUN docker-php-ext-enable opentelemetry
```

* **Non-Docker:** Follow platform-specific extension installation instructions.

**2. OpenTelemetry Library:**

* Install necessary packages using Composer:

```
composer require open-telemetry/opentelemetry
composer require open-telemetry/opentelemetry-auto-laravel
```

**3. OpenTelemetry Configuration:**

* Set environment variables or modify `php.ini`:

```
OTEL_PHP_AUTOLOAD_ENABLED=true
OTEL_PHP_INTERNAL_METRICS_ENABLED=true
OTEL_SERVICE_NAME=your-laravel-app-name
OTEL_TRACES_EXPORTER=desired-exporter (e.g., zipkin)
OTEL_METRICS_EXPORTER=desired-exporter (e.g., otlp)
OTEL_EXPORTER_{exporter}_ENDPOINT=exporter-specific-endpoint-url
OTEL_PROPAGATORS=baggage,tracecontext
```

**4. Additional Packages (Optional):**

| Package Name | Feature | Required |
|---|---|---|
| `open-telemetry/opentelemetry-auto-psr3` | OpenTelemetry for logs | No |
| `open-telemetry/opentelemetry-auto-psr15` | Incoming request instrumentation | No |
| `open-telemetry/opentelemetry-auto-psr18` | Outgoing request instrumentation | No |
| `open-telemetry/opentelemetry-auto-mongodb` | MongoDB query instrumentation | No |
| `open-telemetry/opentelemetry-auto-pdo` | PDO query instrumentation | No |

**5. Deployment:**

* **Docker (Optional):** Include Zipkin setup in `docker-compose.yml`:

```
zipkin:
  container_name: zipkin-demo
  image: openzipkin/zipkin
  ports:
    - 9411:9411
```

* **Manual:** Configure your chosen exporter and tracing backend as needed.

**6. Data Access and Analysis:**

* Utilize your chosen exporter's platform or tool (e.g., Zipkin UI) to access and analyze collected telemetry data.

**Additional Resources:**

* OpenTelemetry Documentation: [https://opentelemetry.io/docs/](https://opentelemetry.io/docs/): [https://opentelemetry.io/docs/](https://opentelemetry.io/docs/)
* PHP Automatic Instrumentation: [https://opentelemetry.io/docs/instrumentation/php/automatic/](https://opentelemetry.io/docs/instrumentation/php/automatic/): [https://opentelemetry.io/docs/instrumentation/php/automatic/](https://opentelemetry.io/docs/instrumentation/php/automatic/)

**Remember:**

* Adjust environment variables and exporter configurations based on your specific needs and chosen exporters.
* Refer to the provided resources for detailed instructions and advanced customization options.

By following these steps, you can successfully set up OpenTelemetry in your Laravel application and gain valuable insights into its performance and behavior.

I hope this revised version maintains the clarity and professionalism while keeping the informative library table. Feel free to let me know if you have any further questions!

