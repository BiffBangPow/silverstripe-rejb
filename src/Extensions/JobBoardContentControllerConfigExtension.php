<?php

namespace BiffBangPow\SilverStripeREJB\Extensions;

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\SiteConfig\SiteConfig;

class JobBoardContentControllerConfigExtension extends Extension
{
    const STYLE_DEFAULTS = [
        'primary' => '#69CDF5',
        'primaryBorder' => '#69CDF5',
        'primaryText' => '#ffffff',
        'primaryHover' => '#29A6CC',
        'primaryHoverBorder' => '#29A6CC',
        'primaryHoverText' => '#ffffff',
        'secondary' => '#3F6070',
        'secondaryBorder' => '#3F6070',
        'secondaryText' => '#ffffff',
        'secondaryHover' => '#3D5865',
        'secondaryHoverBorder' => '#3D5865',
        'secondaryHoverText' => '#ffffff',
        'panelBackground' => '#ffffff',
        'panelDropShadow' => '#E6E5E5',
        'panelBorder' => '#E6E5E5',
        'inputBackground' => '#ffffff',
        'bodyText' => '#484748',
        'buttonBorderRadius' => '10px',
        'inputBorderRadius' => '10px',
        'searchFormFieldsBorderColour' => '#69CDF5',
        'searchFormFieldsBorderRadius' => '"15px',
        'searchFormFieldsBackground' => 'transparent',
        'searchFormFieldsTextColour' => '#FFFFFF',
        'sectorCardBorderWidth' => '20px',
        'sectorCardBorderColour' => '#FFFFFF',
        'sectorCardBorderOpacity' => '0.4',
        'sectorCardBorderRadius' => '10px',
    ];

    /**
     * @return false|string
     */
    public function getJobBoardConfig()
    {
        $styleConfig = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'style');

        if ($styleConfig !== null) {
            $styleConfig = array_merge(self::STYLE_DEFAULTS, $styleConfig);
        } else {
            $styleConfig = self::STYLE_DEFAULTS;
        }

        $jobBoardURLPath = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'job_board_url_path');
        $apiBaseURL = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'api_base_url');
        $brandSlug = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'brand_slug');
        $analyticsID = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'analytics_id');

        $siteConfig = SiteConfig::current_site_config();

        $config = sprintf(
            'var rejbConfig = {"apiBaseUrl":"%s","brandSlug":"%s","privacyPolicyUrlPath":"%s","jobBoardUrlPath":"%s","style":%s,"analyticsId":"%s", "itemsPerPage":"%s"}',
            $apiBaseURL,
            $brandSlug,
            $siteConfig->PrivacyPolicyURLPath,
            $jobBoardURLPath,
            json_encode($styleConfig),
            $analyticsID,
            $siteConfig->ItemsPerPageDefault
        );

        return $config;
    }

    /**
     * @return string
     */
    public function getJobBoardFullURL()
    {
        $jobBoardURLPath = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'job_board_url_path');

        if ($jobBoardURLPath === '/') {
            return Director::absoluteBaseURL();
        } else {
            return Director::absoluteBaseURL() . $jobBoardURLPath;
        }
    }
}