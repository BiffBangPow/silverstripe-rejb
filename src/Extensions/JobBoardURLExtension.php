<?php

namespace BiffBangPow\SilverStripeREJB\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Director;

class JobBoardURLExtension extends Extension
{
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
