<?php

namespace App\Services;

use Google\Client;
use Google\Service\SearchConsole as SearchConsoleService;
use Google\Service\SearchConsole\ApiDimensionFilter;
use Google\Service\SearchConsole\ApiDimensionFilterGroup;
use Google\Service\SearchConsole\InspectUrlIndexRequest;
use Google\Service\SearchConsole\SearchAnalyticsQueryRequest;
use RuntimeException;

/**
 * Thin wrapper around the Google Search Console API (service-account auth).
 *
 *   $gsc = app(\App\Services\SearchConsole::class);
 *   $rows = $gsc->searchAnalytics('2026-07-01', '2026-07-28', ['query']);
 */
class SearchConsole
{
    /** GSC caps a single Search Analytics response at 25,000 rows. */
    private const MAX_ROWS = 25000;

    private SearchConsoleService $service;
    private string $property;

    public function __construct()
    {
        $keyPath = config('searchconsole.key_path');

        if (! $keyPath || ! is_file($keyPath)) {
            throw new RuntimeException(
                "Search Console key file not found at [{$keyPath}]. " .
                "Drop the service-account JSON there or set GSC_KEY_PATH."
            );
        }

        $client = new Client();
        $client->setApplicationName('reviewsbypeople-gsc');
        $client->setAuthConfig($keyPath);
        $client->setScopes(['https://www.googleapis.com/auth/webmasters']);

        $this->service  = new SearchConsoleService($client);
        $this->property = (string) config('searchconsole.property');
    }

    public function property(): string
    {
        return $this->property;
    }

    /* ------------------------------------------------------------------ *
     |  Connectivity
     * ------------------------------------------------------------------ */

    /**
     * Returns the list of properties the service account can see.
     * Use this to confirm auth + that the account was added to the property.
     *
     * @return array<int, array{siteUrl: string, permissionLevel: string}>
     */
    public function sites(): array
    {
        $resp = $this->service->sites->listSites();

        return collect($resp->getSiteEntry() ?? [])
            ->map(fn ($s) => [
                'siteUrl'         => $s->getSiteUrl(),
                'permissionLevel' => $s->getPermissionLevel(),
            ])
            ->all();
    }

    /* ------------------------------------------------------------------ *
     |  Search Analytics
     * ------------------------------------------------------------------ */

    /**
     * Run a Search Analytics query, transparently paginating past the 25k cap.
     *
     * @param  string  $startDate       YYYY-MM-DD
     * @param  string  $endDate         YYYY-MM-DD
     * @param  string[]  $dimensions    any of: date, query, page, country, device, searchAppearance
     * @param  array<int, array{dimension: string, operator?: string, expression: string}>  $filters
     * @param  string  $searchType      'web' | 'image' | 'video' | 'news' | 'discover' | 'googleNews'
     * @return array<int, array{keys: string[], clicks: float, impressions: float, ctr: float, position: float}>
     */
    public function searchAnalytics(
        string $startDate,
        string $endDate,
        array $dimensions = ['query'],
        array $filters = [],
        string $searchType = 'web'
    ): array {
        $rows     = [];
        $startRow = 0;

        do {
            $request = new SearchAnalyticsQueryRequest();
            $request->setStartDate($startDate);
            $request->setEndDate($endDate);
            $request->setDimensions($dimensions);
            $request->setType($searchType);
            $request->setRowLimit(self::MAX_ROWS);
            $request->setStartRow($startRow);

            if ($filters) {
                $group = new ApiDimensionFilterGroup();
                $group->setGroupType('and');
                $group->setFilters(array_map(function (array $f) {
                    $filter = new ApiDimensionFilter();
                    $filter->setDimension($f['dimension']);
                    $filter->setOperator($f['operator'] ?? 'equals');
                    $filter->setExpression($f['expression']);

                    return $filter;
                }, $filters));

                $request->setDimensionFilterGroups([$group]);
            }

            $batch = $this->service->searchanalytics->query($this->property, $request)->getRows() ?? [];

            foreach ($batch as $row) {
                $rows[] = [
                    'keys'        => $row->getKeys() ?? [],
                    'clicks'      => (float) $row->getClicks(),
                    'impressions' => (float) $row->getImpressions(),
                    'ctr'         => (float) $row->getCtr(),
                    'position'    => (float) $row->getPosition(),
                ];
            }

            $startRow += self::MAX_ROWS;
        } while (count($batch) === self::MAX_ROWS);

        return $rows;
    }

    /* ------------------------------------------------------------------ *
     |  URL Inspection
     * ------------------------------------------------------------------ */

    /**
     * Live index status for a single URL.
     *
     * @return array{
     *     verdict: ?string,
     *     coverageState: ?string,
     *     robotsTxtState: ?string,
     *     indexingState: ?string,
     *     lastCrawlTime: ?string,
     *     googleCanonical: ?string,
     *     userCanonical: ?string,
     *     pageFetchState: ?string,
     *     referringUrls: string[],
     * }
     */
    public function inspectUrl(string $url): array
    {
        $request = new InspectUrlIndexRequest();
        $request->setSiteUrl($this->property);
        $request->setInspectionUrl($url);

        $result = $this->service->urlInspection_index->inspect($request)->getInspectionResult();
        $index  = $result?->getIndexStatusResult();

        return [
            'verdict'         => $index?->getVerdict(),
            'coverageState'   => $index?->getCoverageState(),
            'robotsTxtState'  => $index?->getRobotsTxtState(),
            'indexingState'   => $index?->getIndexingState(),
            'lastCrawlTime'   => $index?->getLastCrawlTime(),
            'googleCanonical' => $index?->getGoogleCanonical(),
            'userCanonical'   => $index?->getUserCanonical(),
            'pageFetchState'  => $index?->getPageFetchState(),
            'referringUrls'   => $index?->getReferringUrls() ?? [],
        ];
    }

    /* ------------------------------------------------------------------ *
     |  Sitemaps
     * ------------------------------------------------------------------ */

    /** @return array<int, array{path: string, lastSubmitted: ?string, isPending: bool, errors: string, warnings: string}> */
    public function sitemaps(): array
    {
        $resp = $this->service->sitemaps->listSitemaps($this->property);

        return collect($resp->getSitemap() ?? [])
            ->map(fn ($s) => [
                'path'          => $s->getPath(),
                'lastSubmitted' => $s->getLastSubmitted(),
                'isPending'     => (bool) $s->getIsPending(),
                'errors'        => (string) $s->getErrors(),
                'warnings'      => (string) $s->getWarnings(),
            ])
            ->all();
    }

    public function submitSitemap(?string $feedpath = null): void
    {
        $this->service->sitemaps->submit(
            $this->property,
            $feedpath ?? config('searchconsole.sitemap_url')
        );
    }
}
