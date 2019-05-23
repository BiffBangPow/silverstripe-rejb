<?php

namespace BiffBangPow\SilverStripeREJB\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\ORM\FieldType\DBText;

class JobBoardSiteConfigExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'PrivacyPolicyURLPath'     => DBVarchar::class,
        'ItemsPerPageDefault'      => DBVarchar::class,
        'JobBoardShareDescription' => DBText::class,
    ];

    /**
     * @var array
     */
    private static $defaults = [
        'ItemsPerPageDefault' => "10",
    ];

    /**
     * @param FieldList $fields
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.JobBoard', [
            TextField::create('PrivacyPolicyURLPath', 'Privacy Policy URL Path'),
            TextareaField::create('JobBoardShareDescription', 'Job Board Share Description')->setDescription('This text will display when sharing the jobs on social media, because the job loads with Javascript it is not on the page when Linked in etc reads the page to generate the share text, so fill something generic in here about your site.'),
            DropdownField::create('ItemsPerPageDefault', 'Items Per Page Default', [
                '10' => '10',
                '20' => '20',
                '50' => '50',
            ]),
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
