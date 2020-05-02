<?php
/**
 * All The Meta plugin for Craft CMS 3.x
 *
 * Manage social and SEO meta tag content.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2020 Fieldwork
 */

namespace fieldwork\allthemeta;

use fieldwork\allthemeta\services\AllTheMetaService;
use fieldwork\allthemeta\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\events\DefineGqlTypeFieldsEvent;
use craft\gql\TypeManager;
use craft\gql\TypeLoader;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;

use yii\base\Event;

/**
 * Class AllTheMeta
 *
 * @author    Fieldwork
 * @package   AllTheMeta
 * @since     1.0.0
 *
 * @property  AllTheMetaServiceService $allTheMetaService
 */
class AllTheMeta extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var AllTheMeta
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    protected function createSettingsModel() {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Event::on(
        //     CraftVariable::class,
        //     CraftVariable::EVENT_INIT,
        //     function (Event $event) {
        //         /** @var CraftVariable $variable */
        //         $variable = $event->sender;
        //         $variable->set('allTheMeta', AllTheMetaVariable::class);
        //     }
        // );

        Event::on(
            TypeManager::class,
            TypeManager::EVENT_DEFINE_GQL_TYPE_FIELDS,
            function (DefineGqlTypeFieldsEvent $event) {
                // Add meta tag fields for entries as specified in settings
                if ($event->typeName == 'EntryInterface') {
                    $metaTagTypeName = 'MetaTag';

                    $metaTagType = new ObjectType([
                        'name' => $metaTagTypeName,
                        'description' => 'A meta tag.',
                        'fields' => [
                            'name' => Type::string(),
                            'value' => Type::string(),
                        ],
                    ]);

                    TypeLoader::registerType(
                        $metaTagTypeName,
                        function () use ($metaTagType) {
                            return $metaTagType ;
                        }
                    );

                    $event->fields['metaTags'] = [
                        'name' => 'metaTags',
                        'type' => Type::listOf($metaTagType),
                        'resolve' => function ($source, array $arguments, $context, ResolveInfo $resolveInfo) {
                            return AllTheMetaService::getSocialTags($source);
                        }
                    ];
                }
            }
        );

        Craft::info(
            Craft::t(
                'all-the-meta',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    // protected function createSettingsModel()
    // {
    //     return new Settings();
    // }

    /**
     * @inheritdoc
     */
    // protected function settingsHtml(): string
    // {
    //     return Craft::$app->view->renderTemplate(
    //         'all-the-meta/settings',
    //         [
    //             'settings' => $this->getSettings()
    //         ]
    //     );
    // }
}
