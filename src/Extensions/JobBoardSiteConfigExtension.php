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
        'ItemsPerPageDefault'  => DBVarchar::class,
    ];

    /**
     * @param FieldList $fields
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.JobBoard', [
            TextField::create('PrivacyPolicyURLPath'),
            DropdownField::create('ItemsPerPageDefault', 'Items Per Page Default', [
                '10' => '10',
                '20' => '20',
                '50' => '50'
            ])
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
