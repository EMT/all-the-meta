<?php
/**
 * All The Meta plugin for Craft CMS 3.x
 *
 * Manage social and SEO meta tag content.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2020 Fieldwork
 */

namespace fieldwork\allthemeta\services;

use fieldwork\allthemeta\AllTheMeta;

use Craft;
use craft\base\Component;

/**
 * @author    Fieldwork
 * @package   AllTheMeta
 * @since     1.0.0
 */
class AllTheMetaService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public static function getSocialTags($entry) {
        $social = AllTheMeta::getInstance()->getSettings()->tags;
        $meta = self::_generateMeta($entry);
        $tags = [];

        foreach ($social as $name => $fieldKey) {
            if (!empty($meta[$fieldKey])) {
                $tags[] = [
                    'name' => $name,
                    'value' => $meta[$fieldKey],
                ];
            }
        }

        return $tags;
    }

    // Private Methods
    // =========================================================================

    /**
     * Given an entry-like object, use settings
     * to generate meta for social tags
     */
    private static function _generateMeta($entry) {
        $settings = AllTheMeta::getInstance()->getSettings();
        $globals = Craft::$app->globals;
        $fields = [];

        foreach ($settings['fields'] as $key => $value) {
            $fields[$key] = is_callable($value) ? $value($entry, $globals) : $value;
        }

        return $fields;
    }
}
