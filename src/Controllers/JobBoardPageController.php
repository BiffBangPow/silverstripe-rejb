<?php

namespace BiffBangPow\SilverStripeREJB\Controllers;

use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\HTTPRequest;
use PageController;

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
        return $this->renderWith(['JobBoard', 'Page'], ['MetaTitle' => 'Jobs']);
    }
}
