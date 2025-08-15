<?php

namespace BiffBangPow\SilverStripeREJB\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\HTTPRequest;
use PageController;
use SilverStripe\SiteConfig\SiteConfig;
use Stringy\Stringy;
use SilverStripe\Core\Config\Config;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Core\Injector\Injector;

/**
 * @package BiffBangPow\SilverStripeREJB
 */
class JobBoardPageController extends PageController
{
    /**
     * @param HTTPRequest $request
     * @return DBHTMLText
     */
    public function index(HTTPRequest $request)
    {
        $metaTitle = 'Jobs';

        $jobBoardURLPath = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'job_board_url_path');
        $absoluteLink = Director::absoluteBaseURL() . $request->getURL();

        $rejbPageType = 'REJBIndex';

        if ($request->getURL() !== ltrim($jobBoardURLPath, '/')) {
            $urlParts = explode('/', $request->getURL());

            if ($this->checkJobExists(end($urlParts)) !== true) {
                return $this->httpError(404);
            }

            $title = str_replace('-', ' ', end($urlParts));
            $titleString = new Stringy($title);
            $metaTitle = $titleString->titleize()->__toString();
            $rejbPageType = 'REJBJob';
        }

        $siteConfig = SiteConfig::current_site_config();

        return $this->renderWith(
            [
                'JobBoard',
                'Page',
            ],
            [
                'MetaTitle'       => $metaTitle,
                'Title'           => $metaTitle,
                'MetaDescription' => $siteConfig->JobBoardShareDescription,
                'AbsoluteLink'    => $absoluteLink,
                'REJBPageType'    => $rejbPageType,
            ]
        );
    }

    /**
     * @param $slug
     * @return bool
     * @throws GuzzleException
     */
    public function checkJobExists($slug)
    {
        $cache = Injector::inst()->get(CacheInterface::class . '.rejbcache');

        if ($cache->has($slug) === true) {
            return true;
        }

        $apiBaseURL = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'api_base_url');
        $brandSlug = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'brand_slug');

        $now = new \DateTime();
        $now->format('YYYY-MM-DD');

        $jobURL = sprintf(
            '%s/api/brands/%s/jobs?expiryDate[strictly_after]=%s&slug=%s',
            $apiBaseURL,
            $brandSlug,
            $now->format('Y-m-d'),
            $brandSlug . '-' . $slug
        );

        $client = new Client(['base_uri' => $jobURL]);
        $response = $client->request('GET');
        $arrayResponse = json_decode((string)$response->getBody(), true);

        $jobs = $arrayResponse['hydra:member'];

        if (count($jobs) > 0) {
            $cache->set($slug, 1, 1200); // cache for 20 mins
            return true;
        } else {
            return false;
        }
    }
}
