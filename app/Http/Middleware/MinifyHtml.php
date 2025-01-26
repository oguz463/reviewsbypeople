<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the response from the next middleware or controller
        $response = $next($request);

        // Only apply minification to HTML responses
        if ($response instanceof \Illuminate\Http\Response && $this->isHtmlResponse($response)) {
            // Minify the content
            $content = $this->minify($response->getContent());

            // Set the minified content back to the response
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * Check if the response is HTML.
     *
     * @param \Illuminate\Http\Response $response
     * @return bool
     */
    private function isHtmlResponse($response)
    {
        $contentType = $response->headers->get('Content-Type');

        return str_contains($contentType, 'text/html');
    }

    /**
     * Minify the HTML content.
     *
     * @param string $content
     * @return string
     */
    private function minify($content)
    {
        // Remove extra spaces, newlines, and tabs
        $content = preg_replace('/\s+/', ' ', $content);
        $content = preg_replace('/<!--.*?-->/', '', $content); // Remove comments
        $content = preg_replace('/> </', '><', $content); // Remove spaces between tags
        $content = trim($content);

        return $content;
    }
}
