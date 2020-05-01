<?php
/**
 * All The Meta plugin for Craft CMS 3.x
 *
 * Manage social and SEO meta tag content.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2020 Fieldwork
 */

/**
 * All The Meta config.php
 *
 * This file exists only as a template for the All The Meta settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'all-the-meta.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

$siteTitle = 'My Website';

function findImage( $entry ) {
  if ( !empty( $entry->metaImage ) ) {
    return findFirstImage( $entry->metaImage );
  }
  else if ( !empty( $entry->image ) ) {
    return findFirstImage( $entry->image );
  }

  return null;
}

function findFirstImage( $image ) {
  if ( is_array( $image ) && $image[ 0 ] ) {
    return $image[ 0 ];
  }
  else {
    return $image->one();
  }

  return null;
}

return [
  'fields' => [
    'url' => function($entry) {
      return $entry->getUrl();
    },
    'title' => function($entry) use ($siteTitle) {
      if (!empty($entry->metaTitle)) {
        return $entry->metaTitle;
      }

      switch($entry->getSection()->handle) {
        case 'projects':
          return $entry->title . ' — ' . $siteTitle;
        default:
          return strpos($entry->title, $siteTitle) !== false ?
            $entry->title : $entry->title . ' — ' . $siteTitle;
      }
    },
    'description' => function($entry) {
      if (!empty($entry->metaDescription)) {
        return $entry->metaDescription;
      }

      return '';
    },
    'twitterImage' => function($entry) {
      $image = findImage( $entry );

      if ( $image ) {
        return $image->getUrl( [
          'width' => 600,
          'height' => 300,
        ] );
      }
    },
    'facebookImage' => function($entry) {
      $image = findImage( $entry );

      if ( $image ) {
        return $image->getUrl( [
          'width' => 1200,
          'height' => 630,
        ] );
      }
    },
    'twitter:card' => function( $entry ) {
      if ( findImage( $entry ) ) {
        return 'summary_large_image';
      }

      return 'summary';
    },
    'twitter:site' => '@amyabarry',
    'twitter:creator' => '@amyabarry',
  ],
  'tags' => [
    'title' => 'title',
    'description' => 'description',
    'twitter:card' => 'twitter:card',
    'twitter:url' => 'url',
    'twitter:site' => 'twitter:site',
    'twitter:creator' => 'twitter:creator',
    'twitter:image' => 'twitterImage',
    'og:type' => 'website',
    'og:url' => 'url',
    'og:title' => 'title',
    'og:description' => 'description',
    'og:image' => 'facebookImage',
  ]
];
