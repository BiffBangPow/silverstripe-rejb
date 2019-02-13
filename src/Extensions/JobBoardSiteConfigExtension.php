<?php

namespace BiffBangPow\SilverStripeREJB\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBVarchar;

class JobBoardSiteConfigExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'PrivacyPolicyURLPath' => DBVarchar::class,
    ];

    /**
     * @param FieldList $fields
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.JobBoard', [
            TextField::create('PrivacyPolicyURLPath'),
        ]);
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
