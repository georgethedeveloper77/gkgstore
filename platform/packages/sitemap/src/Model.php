<?php

namespace Botble\Sitemap;

use Carbon\Carbon;
use DateTime;

class Model
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $sitemaps = [];

    /**
     * @var string
     */
    private $title = null;

    /**
     * @var string
     */
    private $link = null;

    /**
     * Enable or disable xsl styles.
     *
     * @var bool
     */
    private $useStyles = true;

    /**
     * Set custom location for xsl styles (must end with slash).
     *
     * @var string
     */
    private $sloc = '/vendor/core/packages/sitemap/styles/';

    /**
     * Enable or disable cache.
     *
     * @var bool
     */
    private $useCache = false;

    /**
     * Unique cache key.
     *
     * @var string
     */
    private $cacheKey = 'cms-sitemap.';

    /**
     * Cache duration, can be int or timestamp.
     *
     * @var Carbon|Datetime|int
     */
    private $cacheDuration = 3600;

    /**
     * Escaping html entities.
     *
     * @var bool
     */
    private $escaping = true;

    /**
     * Use limitSize() for big sitemaps.
     *
     * @var bool
     */
    private $useLimitSize = false;

    /**
     * Custom max size for limitSize().
     *
     * @var bool
     */
    private $maxSize = null;

    /**
     * Use gzip compression.
     *
     * @var bool
     */
    private $useGzip = false;

    /**
     * Populating model variables from configuration file.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->useCache = isset($config['use_cache']) ? $config['use_cache'] : $this->useCache;
        $this->cacheKey = isset($config['cache_key']) ? $config['cache_key'] : $this->cacheKey;
        $this->cacheDuration = isset($config['cache_duration']) ? $config['cache_duration'] : $this->cacheDuration;
        $this->escaping = isset($config['escaping']) ? $config['escaping'] : $this->escaping;
        $this->useLimitSize = isset($config['use_limit_size']) ? $config['use_limit_size'] : $this->useLimitSize;
        $this->useStyles = isset($config['use_styles']) ? $config['use_styles'] : $this->useStyles;
        $this->sloc = isset($config['styles_location']) ? $config['styles_location'] : $this->sloc;
        $this->maxSize = isset($config['max_size']) ? $config['max_size'] : $this->maxSize;
        $this->useGzip = isset($config['use_gzip']) ? $config['use_gzip'] : $this->useGzip;
    }

    /**
     * Returns $items array.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Adds item to $items array.
     *
     * @param array $item
     */
    public function setItems($items)
    {
        $this->items[] = $items;
    }

    /**
     * Returns $sitemaps array.
     *
     * @return array
     */
    public function getSitemaps()
    {
        return $this->sitemaps;
    }

    /**
     * Adds sitemap to $sitemaps array.
     *
     * @param array $sitemap
     */
    public function setSitemaps($sitemap)
    {
        $this->sitemaps[] = $sitemap;
    }

    /**
     * Returns $title value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets $title value.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns $link value.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets $link value.
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Returns $useStyles value.
     *
     * @return bool
     */
    public function isUseStyles()
    {
        return $this->useStyles;
    }

    /**
     * Sets $useStyles value.
     *
     * @param bool $useStyles
     */
    public function setUseStyles($useStyles)
    {
        $this->useStyles = $useStyles;
    }

    /**
     * Returns $sloc value.
     *
     * @return string
     */
    public function getSloc()
    {
        return $this->sloc;
    }

    /**
     * Sets $sloc value.
     *
     * @param string $sloc
     */
    public function setSloc($sloc)
    {
        $this->sloc = $sloc;
    }

    /**
     * Returns $useCache value.
     *
     * @return bool
     */
    public function isUseCache()
    {
        return $this->useCache;
    }

    /**
     * Set use cache value.
     *
     * @param bool $useCache
     */
    public function setUseCache($useCache = true)
    {
        $this->useCache = $useCache;
    }

    /**
     * Returns $CacheKey value.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return $this->cacheKey;
    }

    /**
     * Set cache key value.
     *
     * @param string $cacheKey
     */
    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;
    }

    /**
     * Returns $CacheDuration value.
     *
     * @return string
     */
    public function getCacheDuration()
    {
        return $this->cacheDuration;
    }

    /**
     * Set cache duration value.
     *
     * @param Carbon|Datetime|int $cacheDuration
     */
    public function setCacheDuration($cacheDuration)
    {
        $this->cacheDuration = $cacheDuration;
    }

    /**
     * Returns $escaping value.
     *
     * @return bool
     */
    public function isEscaping()
    {
        return $this->escaping;
    }

    /**
     * Sets $escaping value.
     *
     * @param bool $escaping
     */
    public function setEscaping($escaping)
    {
        $this->escaping = $escaping;
    }

    /**
     * Returns $useLimitSize value.
     *
     * @return bool
     */
    public function isUseLimitSize()
    {
        return $this->useLimitSize;
    }

    /**
     * Sets $useLimitSize value.
     *
     * @param bool $useLimitSize
     */
    public function setUseLimitSize($useLimitSize)
    {
        $this->useLimitSize = $useLimitSize;
    }

    /**
     * Returns $maxSize value.
     *
     * @param int $maxSize
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * Sets $maxSize value.
     *
     * @param int $maxSize
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * Returns $useGzip value.
     *
     * @param bool $useGzip
     */
    public function getUseGzip()
    {
        return $this->useGzip;
    }

    /**
     * Sets $useGzip value.
     *
     * @param bool $useGzip
     */
    public function setUseGzip($useGzip = true)
    {
        $this->useGzip = $useGzip;
    }

    /**
     * Limit size of $items array to 50000 elements (1000 for google-news).
     */
    public function limitSize($max = 50000)
    {
        $this->items = array_slice($this->items, 0, $max);
    }

    /**
     * Reset $items array.
     *
     * @param array $items
     */
    public function resetItems($items = [])
    {
        $this->items = $items;
    }

    /**
     * Reset $sitemaps array.
     *
     * @param array $sitemaps
     */
    public function resetSitemaps($sitemaps = [])
    {
        $this->sitemaps = $sitemaps;
    }
}
