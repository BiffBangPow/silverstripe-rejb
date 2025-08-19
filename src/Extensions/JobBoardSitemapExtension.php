<?php

use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class JobBoardSitemapExtension extends DataExtension {

    public function updateGoogleSitemapItems($items, $class, $page)
    {
        $jobBoardURLPath = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'job_board_url_path');
        $apiBaseURL = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'api_base_url');
        $brandSlug = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'brand_slug');

        $now = new DateTime();
        $now->format('YYYY-MM-DD');

        $allJobsURL = sprintf(
            '%s/api/brands/%s/jobs?itemsPerPage=1000&expiryDate[strictly_after]=%s',
            $apiBaseURL,
            $brandSlug,
            $now->format('Y-m-d')
        );

        $client = new GuzzleHttp\Client(['base_uri' => $allJobsURL]);
        $response = $client->request('GET');
        $arrayResponse = json_decode((string)$response->getBody(), true);

        $jobs = $arrayResponse['hydra:member'];

        foreach ($jobs as $job) {

            $jobURL = rtrim(Director::absoluteBaseURL(),'/') .$jobBoardURLPath . '/job/' . substr($job['slug'], strlen($brandSlug . '-'));
            $items->push(new ArrayData(array(
                'AbsoluteLink' => $jobURL,
                'ChangeFrequency' => 'weekly',
                'GooglePriority' => 1,
            )));

        }
    }
}
