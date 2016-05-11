<?php

namespace danb\Lastfm\Http;

use JasonGrimes\Paginator;

/**
 * Paginator facotry for creating paginators.
 *
 * The created paginators should convert to html string pagination.
 *
 * Currently uses a 3rd party library.
 */
class PaginatorFactory
{
    /**
     * Create a paginator based on Lastfm parameters.
     *
     * @return null|JasonGrimes\Paginator
     */
    public static function useLastfmParams($params, $urlPattern)
    {
        if (!isset($params['total'])) return null;
        if (!isset($params['page'])) return null;
        if (!isset($params['perPage'])) return null;
        $total = $params['total'];
        $page = $params['page'];
        $perPage = $params['perPage'];
        return new Paginator($total, $perPage, $page, $urlPattern);
    }
}
