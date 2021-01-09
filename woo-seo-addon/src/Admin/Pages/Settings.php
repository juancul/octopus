<?php namespace Premmerce\SeoAddon\Admin\Pages;


use Premmerce\SeoAddon\Core\Config\SettingsInterface;
use Premmerce\SeoAddon\Core\Plugins;

class Settings implements SettingsInterface
{
    public function getId()
    {
        return 'premmerce_seo_settings';
    }

    public function getTitle()
    {
        return __('Settings', 'woo-seo-addon');
    }

    public function getFields()
    {
        $options = ['' => __('Not specified', 'woo-seo-addon')];

        $taxonomies = get_taxonomies(['object_type' => ['product']], 'objects');
        foreach ($taxonomies as $taxonomy) {
            $options[$taxonomy->name] = $taxonomy->labels->singular_name;
        }

        $tcDoc = 'https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started.html';
        $ldDoc = 'https://schema.org/';
        $ogDoc = 'http://ogp.me/';

        $doc = __('See', 'woo-seo-addon') . ' <a target="_blank" href="%s">' . __('documentation',
                'woo-seo-addon') . '</a>';

        $settings['section'] = [
            'title' => __('Settings', 'woo-seo-addon'),
            'type'  => 'section'
        ];

        if (Plugins::isYoastActive()) {
            $settings['compat'] = [
                'title'       => __('Mode', 'woo-seo-addon'),
                'type'        => 'text',
                'value'       => 'Yoast SEO',
                'description' => __('The plugin is using the compatibility mode.Therefore, some features have been disabled.',
                    'woo-seo-addon')
            ];
        }


        $settings['markup'] = [
            'type'   => 'group',
            'title'  => __('Markup', 'woo-seo-addon'),
            'fields' => [
                'og' => [
                    'type'        => 'checkbox',
                    'label'       => __('Open Graph', 'woo-seo-addon'),
                    'description' => sprintf($doc, $ogDoc),
                ],
                'tc' => [
                    'type'        => 'checkbox',
                    'label'       => __('Twitter Cards', 'woo-seo-addon'),
                    'description' => sprintf($doc, $tcDoc),
                ],
                'ld' => [
                    'type'        => 'checkbox',
                    'label'       => __('schema.org', 'woo-seo-addon'),
                    'description' => sprintf($doc, $ldDoc),
                ],
            ],
        ];

        $settings['image_alts'] = [
            'type'        => 'checkbox',
            'title'       => __('Image alts', 'woo-seo-addon'),
            'label'       => __('Enable image alts', 'woo-seo-addon'),
            'description' => __('Generate product image alts from titles', 'woo-seo-addon')
        ];

        $settings['twitter']           = [
            'type'  => 'section',
            'title' => __('Twitter', 'woo-seo-addon'),
        ];
        $settings['twitter_card_type'] = [
            'type'    => 'select',
            'options' => [
                'summary_large_image' => __('Summary with large image', 'woo-seo-addon'),
                'summary'             => __('Summary', 'woo-seo-addon')
            ],
            'title'   => __('Twitter Card type', 'woo-seo-addon'),
        ];

        $settings['schema.org'] = [
            'type'  => 'section',
            'title' => __('schema.org', 'woo-seo-addon'),
        ];

        $settings['brand_field'] = [
            'type'        => 'select',
            'title'       => __('Brand', 'woo-seo-addon'),
            'description' => __('Select the taxonomy that is used as a brand', 'woo-seo-addon'),
            'options'     => $options
        ];

        $settings['links'] = [
            'type'   => 'group',
            'title'  => __('Links', 'woo-seo-addon'),
            'fields' => [
                'canonical' => [
                    'type'  => 'checkbox',
                    'label' => __('Enable canonical links', 'woo-seo-addon'),
                    'description' => __('Add canonical meta tags', 'woo-seo-addon')
                ],
                'navigation' => [
                    'type'  => 'checkbox',
                    'label' => __('Enable navigation links', 'woo-seo-addon'),
                    'description' => __('Add prev, next meta tags', 'woo-seo-addon'),
                ]
            ]
        ];

        return $settings;

    }

}