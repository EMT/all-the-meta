<?php
/**
 * All The Meta plugin for Craft CMS 3.x
 *
 * Manage social and SEO meta tag content.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2020 Fieldwork
 */

namespace fieldwork\allthemeta\models;

use fieldwork\allthemeta\AllTheMeta;

use Craft;
use craft\base\Model;

/**
 * @author    Fieldwork
 * @package   AllTheMeta
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var array The default fields
     */
    public $fields = [];

    /**
     * @var array The default tags
     */
    public $tags = [
        'title' => 'title',
        'description' => 'description',
        'twitter:card' => 'twitter:card',
        'og:url' => 'url',
        'og:title' => 'title',
        'og:description' => 'description',
        'og:image' => 'image',
    ];

    function __construct() {
        $this->fields = [
            'url' => function($entry) {
                return $entry->getUrl();
            },
            'title' => function($entry) {
                return $entry->title;
            },
            'description' => function($entry) {
                return '';
            },
            'image' => function($entry) {
                return null;
            },
            'twitter:card' => 'summary',
        ];
    }
}
