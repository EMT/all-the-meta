<?php
/**
 * All The Meta plugin for Craft CMS 3.x
 *
 * Manage social and SEO meta tag content.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2020 Fieldwork
 */

namespace fieldwork\allthemeta\variables;

use fieldwork\allthemeta\AllTheMeta;

use Craft;

/**
 * @author    Fieldwork
 * @package   AllTheMeta
 * @since     1.0.0
 */
class AllTheMetaVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
