<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Generate breadcrumb schema
     */
    public static function breadcrumbSchema($items = [])
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        foreach ($items as $index => $item) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url']
            ];
        }

        return json_encode($schema);
    }

    /**
     * Generate organization schema
     */
    public static function organizationSchema()
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'LegalService',
            'name' => 'SK Sharif & Associates',
            'description' => 'Professional legal services provider in Bangladesh',
            'url' => config('app.url'),
            'logo' => asset('frontend_assets/img/logo.png'),
            'telephone' => '+8801710884561',
            'email' => 'sksharifnassociates2002@gmail.com',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '3rd Floor Room No - 412, Supreme Court BAR Association Main Building',
                'addressLocality' => 'Dhaka',
                'postalCode' => '1100',
                'addressCountry' => 'BD'
            ],
            'sameAs' => [
                'https://www.facebook.com/sksharif',
                'https://www.linkedin.com/company/sksharif'
            ]
        ]);
    }

    /**
     * Generate article schema
     */
    public static function articleSchema($title, $description, $image, $published, $modified)
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $title,
            'description' => $description,
            'image' => $image,
            'datePublished' => $published,
            'dateModified' => $modified,
            'author' => [
                '@type' => 'Organization',
                'name' => 'SK Sharif & Associates'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'SK Sharif & Associates',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('frontend_assets/img/logo.png')
                ]
            ]
        ]);
    }

    /**
     * Generate job posting schema
     */
    public static function jobPostingSchema($job)
    {
        return json_encode([
            '@context' => 'https://schema.org/',
            '@type' => 'JobPosting',
            'title' => $job->title,
            'description' => strip_tags($job->description),
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => 'SK Sharif & Associates',
                'sameAs' => config('app.url'),
                'logo' => asset('frontend_assets/img/logo.png')
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job->location ?? 'Dhaka',
                    'addressCountry' => 'BD'
                ]
            ],
            'baseSalary' => [
                '@type' => 'PriceSpecification',
                'priceCurrency' => 'BDT',
                'price' => $job->salary_range ?? 'Competitive'
            ],
            'validThrough' => $job->deadline->toIso8601String(),
            'employmentType' => 'FULL_TIME'
        ]);
    }

    /**
     * Generate faq schema
     */
    public static function faqSchema($questions = [])
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($questions as $question => $answer) {
            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer
                ]
            ];
        }

        return json_encode($schema);
    }

    /**
     * Truncate text to specified length
     */
    public static function truncate($text, $length = 160)
    {
        $text = strip_tags($text);
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }

    /**
     * Generate canonical URL
     */
    public static function canonical($url = null)
    {
        return $url ?? request()->url();
    }

    /**
     * Generate robots meta tag
     */
    public static function robots($index = true, $follow = true)
    {
        $content = ($index ? 'index' : 'noindex') . ', ' . ($follow ? 'follow' : 'nofollow');
        return $content;
    }
}
