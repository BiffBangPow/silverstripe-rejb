# Recruitment Entrepreneur Group Wide Job Board SilverStripe

## Setup

`composer require biffbangpow/silverstripe-rejb`

You will need to set some config settings in `mysite.yml` for this package to work, the required settings are:

~~~
BiffBangPow\SilverStripeREJB\SilverstripeREJB:
  job_board_url_path: "/jobs"
  api_base_url: "https://jobs.recruitmentvc.com"
  brand_slug: "brand-slug-here"
~~~

You will also need to direct all requests to the job board to the job board controller, add this to your `mysite.yml`, replace `/jobs` with the url you want your job board to reside at, this should be the same `job_board_url_path` you set above

~~~
SilverStripe\Control\Director:
  rules:
    'jobs/job/$ID': 'BiffBangPow\SilverStripeREJB\Controllers\JobBoardPageController'
    'jobs': 'BiffBangPow\SilverStripeREJB\Controllers\JobBoardPageController'
~~~

You can also override the default style variables using this config, all of the available values are listed below

~~~
BiffBangPow\SilverStripeREJB\SilverstripeREJB:
  style:
    primary: "#69CDF5"
    primaryBorder: "#69CDF5"
    primaryText: "#ffffff"
    primaryHover: "#29A6CC"
    primaryHoverBorder: "#29A6CC"
    primaryHoverText: "#ffffff"
    secondary: "#3F6070"
    secondaryBorder: "#3F6070"
    secondaryText: "#ffffff"
    secondaryHover: "#3D5865"
    secondaryHoverBorder: "#3D5865"
    secondaryHoverText: "#ffffff"
    panelBackground: "#ffffff"
    panelDropShadow: "#E6E5E5"
    panelBorder: "#E6E5E5"
    inputBackground: "#ffffff"
    bodyText: "#484748"
    buttonBorderRadius: "10px"
    inputBorderRadius: "10px"
    searchFormFieldsBorderColour: "#69CDF5"
    searchFormFieldsBorderRadius:  "15px"
    searchFormFieldsBackground: "transparent"
    searchFormFieldsTextColour: "#FFFFFF"
    sectorCardBorderWidth: "20px"
    sectorCardBorderColour: "#FFFFFF"
    sectorCardBorderOpacity: "0.4"
    sectorCardBorderRadius: "10px"
~~~

Finally you need to add the following near the bottom of your main `Page.ss` template file

~~~
<% include JobBoardConfig %>
~~~

## Configuration

Head to the settings section in the CMS and fill in the values under 'Job Board', the style settings all have defaults that can be left alone or adjusted to fit the relevant brand

## Development

Setting the package in dev mode will load css from `http://localhost:8000/main.css` and the javascript from `http://localhost:8000/bundle.js`

~~~
BiffBangPow\SilverStripeREJB\SilverstripeREJB:
  dev_mode: true
~~~

You can also control which port it uses for the local resources:

~~~
BiffBangPow\SilverStripeREJB\SilverstripeREJB:
  dev_port: 8000
~~~

If the package is not set in dev mode it will load css from `https://jobs.recruitmentvc.com/cdn/main.css` and the javascript from `https://jobs.recruitmentvc.com/cdn/bundle.js`
