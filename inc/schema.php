<?php
/**
 * Schema.org JSON-LD: LegalService + Organization + Article + WebPage
 *
 * @package lanotte-2026
 */

if (!defined('ABSPATH')) exit;

add_action('wp_head', 'lanotte_output_jsonld', 5);
function lanotte_output_jsonld() {
    $org_url = home_url('/');
    $org_name = 'Studio Legale LANOTTE & Partners';
    $tel = lanotte_phone(true) ?: '+3908831955533';
    $email = lanotte_email();
    // Catena di fallback: Customizer → ACF Branding → logo nel tema
    $logo_url = function_exists('lanotte_logo_url') ? lanotte_logo_url() : '';
    if (!$logo_url) {
        $logo_id = get_theme_mod('custom_logo');
        $logo_url = $logo_id
            ? wp_get_attachment_image_url($logo_id, 'full')
            : LANOTTE_THEME_URI . '/assets/img/logo.png';
    }

    $legal_service = [
        '@context'    => 'https://schema.org',
        '@type'       => 'LegalService',
        '@id'         => $org_url . '#legalservice',
        'name'        => $org_name,
        'alternateName' => 'Studio Legale Lanotte',
        'description' => 'Studio Legale LANOTTE & Partners, iscritto al Foro di Trani con sede in Barletta. Assistenza in materia civile, penale, commerciale, del lavoro, tributaria, internazionale privato e diritto industriale (marchi, brevetti, design davanti a UIBM, EUIPO, OMPI).',
        'url'         => $org_url,
        'telephone'   => $tel,
        'email'       => $email,
        'logo'        => [
            '@type' => 'ImageObject',
            'url'   => $logo_url,
        ],
        'image'       => $logo_url,
        'founder'     => [
            '@type' => 'Person',
            'name'  => 'Avv. Giuseppe LANOTTE',
            'jobTitle' => 'Avvocato',
            'memberOf' => [
                '@type' => 'Organization',
                'name'  => 'Ordine degli Avvocati di Trani',
            ],
        ],
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Viale Falcone e Borsellino, 75',
            'addressLocality' => 'Barletta',
            'addressRegion'   => 'BT',
            'postalCode'      => '76121',
            'addressCountry'  => 'IT',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => '41.3171',
            'longitude' => '16.2806',
        ],
        'openingHoursSpecification' => [
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Wednesday', 'Friday'],
                'opens'     => '09:00',
                'closes'    => '13:00',
            ],
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Wednesday', 'Friday'],
                'opens'     => '16:00',
                'closes'    => '21:00',
            ],
        ],
        'areaServed' => [
            ['@type' => 'AdministrativeArea', 'name' => 'Italia'],
            ['@type' => 'AdministrativeArea', 'name' => 'Puglia'],
            ['@type' => 'City', 'name' => 'Barletta'],
            ['@type' => 'City', 'name' => 'Trani'],
            ['@type' => 'City', 'name' => 'Bari'],
            ['@type' => 'AdministrativeArea', 'name' => 'European Union'],
            ['@type' => 'AdministrativeArea', 'name' => 'Worldwide (intellectual property)'],
        ],
        'knowsLanguage' => ['it', 'en', 'es'],
        'priceRange'    => '€€',
        'sameAs'        => array_filter([
            lanotte_acf_option('social_facebook',  'https://www.facebook.com/studiolegalelanotte/'),
            lanotte_acf_option('social_instagram', 'https://www.instagram.com/studio_legale_lanotte'),
            lanotte_acf_option('social_linkedin'),
            lanotte_acf_option('google_business_url'),
        ]),
    ];

    echo "\n<script type=\"application/ld+json\" id=\"lanotte-legalservice\">\n";
    echo wp_json_encode($legal_service, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";

    // Article schema sui post del blog
    if (is_singular('post')) {
        $post = get_post();
        $thumb_id = get_post_thumbnail_id($post);
        $img_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : $logo_url;

        $article = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => get_the_title($post),
            'description'      => get_the_excerpt($post),
            'image'            => $img_url,
            'datePublished'    => get_the_date(DATE_W3C, $post),
            'dateModified'     => get_the_modified_date(DATE_W3C, $post),
            'author' => [
                '@type' => 'Person',
                'name'  => get_the_author_meta('display_name', $post->post_author),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name'  => $org_name,
                'logo'  => ['@type' => 'ImageObject', 'url' => $logo_url],
            ],
            'mainEntityOfPage' => get_permalink($post),
        ];

        echo "\n<script type=\"application/ld+json\" id=\"lanotte-article\">\n";
        echo wp_json_encode($article, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n</script>\n";
    }

    // Area di competenza schema (Service)
    if (is_singular('area')) {
        $service = [
            '@context'       => 'https://schema.org',
            '@type'          => 'Service',
            'serviceType'    => get_the_title(),
            'description'    => function_exists('get_field') ? (string) get_field('tagline') : get_the_excerpt(),
            'provider'       => [
                '@id' => $org_url . '#legalservice',
            ],
            'areaServed'     => 'Italia',
        ];

        echo "\n<script type=\"application/ld+json\" id=\"lanotte-service\">\n";
        echo wp_json_encode($service, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n</script>\n";

        // FAQ Page schema se ci sono FAQ
        if (function_exists('have_rows') && have_rows('faq')) {
            $main_entity = [];
            while (have_rows('faq')) {
                the_row();
                $main_entity[] = [
                    '@type'          => 'Question',
                    'name'           => get_sub_field('domanda'),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => wp_strip_all_tags(get_sub_field('risposta')),
                    ],
                ];
            }
            if ($main_entity) {
                $faqpage = [
                    '@context'   => 'https://schema.org',
                    '@type'      => 'FAQPage',
                    'mainEntity' => $main_entity,
                ];
                echo "\n<script type=\"application/ld+json\" id=\"lanotte-faqpage\">\n";
                echo wp_json_encode($faqpage, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                echo "\n</script>\n";
            }
        }
    }

    // Calcolatori: schema WebApplication + FAQPage per le pagine WordPress vere.
    if (function_exists('lanotte_current_calcolatore_data')) {
        $calc = lanotte_current_calcolatore_data();
        if ($calc) {
            $webapp = [
                '@context' => 'https://schema.org',
                '@type' => 'WebApplication',
                'name' => $calc['title'],
                'url' => get_permalink(),
                'applicationCategory' => 'LegalApplication',
                'operatingSystem' => 'Any',
                'isAccessibleForFree' => true,
                'description' => wp_strip_all_tags($calc['intro']),
                'provider' => [
                    '@id' => $org_url . '#legalservice',
                ],
            ];
            echo "\n<script type=\"application/ld+json\" id=\"lanotte-calcolatore-webapp\">\n";
            echo wp_json_encode($webapp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            echo "\n</script>\n";

            $main_entity = [];
            foreach ($calc['faq'] as $item) {
                $main_entity[] = [
                    '@type' => 'Question',
                    'name' => $item[0],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($item[1]),
                    ],
                ];
            }
            if ($main_entity) {
                $faqpage = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $main_entity,
                ];
                echo "\n<script type=\"application/ld+json\" id=\"lanotte-calcolatore-faqpage\">\n";
                echo wp_json_encode($faqpage, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                echo "\n</script>\n";
            }
        }
    }
}
