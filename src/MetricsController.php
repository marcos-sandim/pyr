<?php

namespace Superbalist\LaravelPrometheusExporter;

use Illuminate\Routing\Controller;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    /**
     * @var $prometheusExporter
     */
    protected $prometheusExporter;

    /**
     * @param PrometheusExporter $prometheusExporter
     */
    public function __construct(PrometheusExporter $prometheusExporter)
    {
        $this->prometheusExporter = $prometheusExporter;
    }

    /**
     * GET /metrics
     *
     * The route path is configurable in the prometheus.metrics_route_path config var, or the
     * PROMETHEUS_METRICS_ROUTE_PATH env var.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMetrics()
    {
        $metrics = $this->prometheusExporter->export();

        $renderer = new RenderTextFormat();
        $result = $renderer->render($metrics);

        return response($result)
            ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
