# Laravel OpenTelemetry Setup Guideline

In this guide, we'll walk you through the process of setting up OpenTelemetry for Laravel applications. OpenTelemetry is an open-source project that allows you to collect, process, and export telemetry data from your applications. With Laravel and OpenTelemetry, you can gain insights into the performance and behavior of your application.

To streamline the process and ensure best practices, we'll primarily focus on utilizing auto-instruments, a recommended approach for OpenTelemetry integration. As a result, this guideline will not delve into the complexities of manual setup. 

## Prerequisites

Before we begin, ensure you have the following prerequisites installed:

- **Laravel**: Make sure you have a Laravel project up and running.
- **Composer**: Laravel projects rely on Composer for dependency management. If you don't have it, [install it](https://getcomposer.org/).
- **Docker and Docker Compose** (Optional): For those who want to use the Dockerized OpenTelemetry Collector, you should have Docker and Docker Compose installed. [Docker Installation Guide](https://docs.docker.com/get-docker/).

To provide a clear understanding of the environment used in this guide, here's an example of the PHP and Laravel versions:

- **PHP Version**: 8.2
- **Laravel Version**: 10

## Installation

### Step 1: Install the OpenTelemetry PHP extension

The first step is install the OpenTelemetry PHP extension.

The example we are using `pecl` to install the extension. You can see the example inside the Dockerfile.

Install the extension:

```bash
pecl install opentelemetry
```

Add extension to php ini file

```bash
RUN docker-php-ext-enable opentelemetry
```

### Step 2: Install the OpenTelemetry Library 

Beside the extension. You need to install the SDK package and one or more instrumentation packages.

Install PHP package `open-telemetry/opentelemetry` which already include API / SDK / exporter and more useful package:

```bash
composer require open-telemetry/opentelemetry
```

Install Laravel auto instrumentation package

```bash
composer require composer require open-telemetry/opentelemetry-auto-laravel
```


### Step 3: Configure OpenTelemetry (Provide detailed instructions and code snippets for this step)

## Conclusion


## Reference

[PHP Automatic Instrumentation](https://opentelemetry.io/docs/instrumentation/php/automatic/)
