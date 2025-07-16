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

class JobBoardContentControllerLoadFilesExtension extends Extension
{
    /**
     * Place the necessary js and css
     *
     * @throws \Exception
     */
    public function onAfterInit()
    {
        Requirements::set_force_js_to_bottom(true);

        if (Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'dev_mode') === true) {

            $port = '8080';

            $portConfig = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'dev_port');

            if ($portConfig !== null) {
                $port = $portConfig;
            }

            Requirements::css(sprintf('http://localhost:%s/main.css', $port), '', ['defer' => true]);
            Requirements::javascript(sprintf('http://localhost:%s/bundle.js', $port), ['type' => false, 'async' => false, 'defer' => true]);
        } elseif (Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'alternate_cdn') !== null) {
            $cdnBaseURL = Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'alternate_cdn');
            Requirements::css($cdnBaseURL . '/main.css', '', ['defer' => true]);
            Requirements::javascript($cdnBaseURL . '/bundle.js', ['type' => false, 'async' => false, 'defer' => true]);
        } else {
            Requirements::css('https://jobs.recruitmentvc.com/cdn/main.css', '', ['defer' => true]);
            Requirements::javascript('https://jobs.recruitmentvc.com/cdn/bundle.js', ['type' => false, 'async' => false, 'defer' => true]);
        }

        if (Config::inst()->get('BiffBangPow\SilverStripeREJB\SilverstripeREJB', 'has_manual_apply') === true) {
            Requirements::javascript('https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit', ['defer']);
        }
    }
}
