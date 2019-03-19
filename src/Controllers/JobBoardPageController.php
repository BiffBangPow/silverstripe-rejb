<?php

namespace BiffBangPow\SilverStripeREJB\Controllers;

use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\HTTPRequest;
use PageController;
use Stringy\Stringy;
use SilverStripe\Core\Config\Config;

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

        if ($request->getURL() !== $jobBoardURLPath) {
            $urlParts = explode('/', $request->getURL());
            $title = str_replace('-', ' ', end($urlParts));
            $titleString = new Stringy($title);
            $metaTitle = $titleString->titleize()->__toString();
        }

        return $this->renderWith(['JobBoard', 'Page'], ['MetaTitle' => $metaTitle]);
    }
}
