<?php
namespace Nviba\Bundle\SuluOverridesBundle\Content\Types;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sulu\Bundle\LocationBundle\Content\Types\LocationContentType as SuluLocationContentType;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\Compat\PropertyParameter;
use Sulu\Component\Content\ComplexContentType;
use PHPCR\NodeInterface;
use Sulu\Bundle\ContentBundle\Repository\NodeRepositoryInterface;
use Sulu\Bundle\LocationBundle\Map\MapManager;
use Symfony\Component\Intl\Intl;

/**
 * Description of LocationContentType
 *
 * @author daniel
 */
/**
 * ContentType for TextEditor.
 */
class LocationContentType extends ComplexContentType
{
    /**
     * @var NodeRepositoryInterface
     */
    private $nodeRepository;

    /**
     * @var string
     */
    private $template;

    /**
     * @var MapManager
     */
    private $mapManager;

    /**
     * @var string
     */
    private $geolocatorName;
    
    
    private $countryList = array(
	"AF" => "Afghanistan",
	"AL" => "Albania",
	"DZ" => "Algeria",
	"AS" => "American Samoa",
	"AD" => "Andorra",
	"AO" => "Angola",
	"AI" => "Anguilla",
	"AQ" => "Antarctica",
	"AG" => "Antigua and Barbuda",
	"AR" => "Argentina",
	"AM" => "Armenia",
	"AW" => "Aruba",
	"AU" => "Australia",
	"AT" => "Austria",
	"AZ" => "Azerbaijan",
	"BS" => "Bahamas",
	"BH" => "Bahrain",
	"BD" => "Bangladesh",
	"BB" => "Barbados",
	"BY" => "Belarus",
	"BE" => "Belgium",
	"BZ" => "Belize",
	"BJ" => "Benin",
	"BM" => "Bermuda",
	"BT" => "Bhutan",
	"BO" => "Bolivia",
	"BA" => "Bosnia and Herzegovina",
	"BW" => "Botswana",
	"BV" => "Bouvet Island",
	"BR" => "Brazil",
	"BQ" => "British Antarctic Territory",
	"IO" => "British Indian Ocean Territory",
	"VG" => "British Virgin Islands",
	"BN" => "Brunei",
	"BG" => "Bulgaria",
	"BF" => "Burkina Faso",
	"BI" => "Burundi",
	"KH" => "Cambodia",
	"CM" => "Cameroon",
	"CA" => "Canada",
	"CT" => "Canton and Enderbury Islands",
	"CV" => "Cape Verde",
	"KY" => "Cayman Islands",
	"CF" => "Central African Republic",
	"TD" => "Chad",
	"CL" => "Chile",
	"CN" => "China",
	"CX" => "Christmas Island",
	"CC" => "Cocos [Keeling] Islands",
	"CO" => "Colombia",
	"KM" => "Comoros",
	"CG" => "Congo - Brazzaville",
	"CD" => "Congo - Kinshasa",
	"CK" => "Cook Islands",
	"CR" => "Costa Rica",
	"HR" => "Croatia",
	"CU" => "Cuba",
	"CY" => "Cyprus",
	"CZ" => "Czech Republic",
	"CI" => "Côte d’Ivoire",
	"DK" => "Denmark",
	"DJ" => "Djibouti",
	"DM" => "Dominica",
	"DO" => "Dominican Republic",
	"NQ" => "Dronning Maud Land",
	"DD" => "East Germany",
	"EC" => "Ecuador",
	"EG" => "Egypt",
	"SV" => "El Salvador",
	"GQ" => "Equatorial Guinea",
	"ER" => "Eritrea",
	"EE" => "Estonia",
	"ET" => "Ethiopia",
	"FK" => "Falkland Islands",
	"FO" => "Faroe Islands",
	"FJ" => "Fiji",
	"FI" => "Finland",
	"FR" => "France",
	"GF" => "French Guiana",
	"PF" => "French Polynesia",
	"TF" => "French Southern Territories",
	"FQ" => "French Southern and Antarctic Territories",
	"GA" => "Gabon",
	"GM" => "Gambia",
	"GE" => "Georgia",
	"DE" => "Germany",
	"GH" => "Ghana",
	"GI" => "Gibraltar",
	"GR" => "Greece",
	"GL" => "Greenland",
	"GD" => "Grenada",
	"GP" => "Guadeloupe",
	"GU" => "Guam",
	"GT" => "Guatemala",
	"GG" => "Guernsey",
	"GN" => "Guinea",
	"GW" => "Guinea-Bissau",
	"GY" => "Guyana",
	"HT" => "Haiti",
	"HM" => "Heard Island and McDonald Islands",
	"HN" => "Honduras",
	"HK" => "Hong Kong SAR China",
	"HU" => "Hungary",
	"IS" => "Iceland",
	"IN" => "India",
	"ID" => "Indonesia",
	"IR" => "Iran",
	"IQ" => "Iraq",
	"IE" => "Ireland",
	"IM" => "Isle of Man",
	"IL" => "Israel",
	"IT" => "Italy",
	"JM" => "Jamaica",
	"JP" => "Japan",
	"JE" => "Jersey",
	"JT" => "Johnston Island",
	"JO" => "Jordan",
	"KZ" => "Kazakhstan",
	"KE" => "Kenya",
	"KI" => "Kiribati",
	"KW" => "Kuwait",
	"KG" => "Kyrgyzstan",
	"LA" => "Laos",
	"LV" => "Latvia",
	"LB" => "Lebanon",
	"LS" => "Lesotho",
	"LR" => "Liberia",
	"LY" => "Libya",
	"LI" => "Liechtenstein",
	"LT" => "Lithuania",
	"LU" => "Luxembourg",
	"MO" => "Macau SAR China",
	"MK" => "Macedonia",
	"MG" => "Madagascar",
	"MW" => "Malawi",
	"MY" => "Malaysia",
	"MV" => "Maldives",
	"ML" => "Mali",
	"MT" => "Malta",
	"MH" => "Marshall Islands",
	"MQ" => "Martinique",
	"MR" => "Mauritania",
	"MU" => "Mauritius",
	"YT" => "Mayotte",
	"FX" => "Metropolitan France",
	"MX" => "Mexico",
	"FM" => "Micronesia",
	"MI" => "Midway Islands",
	"MD" => "Moldova",
	"MC" => "Monaco",
	"MN" => "Mongolia",
	"ME" => "Montenegro",
	"MS" => "Montserrat",
	"MA" => "Morocco",
	"MZ" => "Mozambique",
	"MM" => "Myanmar [Burma]",
	"NA" => "Namibia",
	"NR" => "Nauru",
	"NP" => "Nepal",
	"NL" => "Netherlands",
	"AN" => "Netherlands Antilles",
	"NT" => "Neutral Zone",
	"NC" => "New Caledonia",
	"NZ" => "New Zealand",
	"NI" => "Nicaragua",
	"NE" => "Niger",
	"NG" => "Nigeria",
	"NU" => "Niue",
	"NF" => "Norfolk Island",
	"KP" => "North Korea",
	"VD" => "North Vietnam",
	"MP" => "Northern Mariana Islands",
	"NO" => "Norway",
	"OM" => "Oman",
	"PC" => "Pacific Islands Trust Territory",
	"PK" => "Pakistan",
	"PW" => "Palau",
	"PS" => "Palestinian Territories",
	"PA" => "Panama",
	"PZ" => "Panama Canal Zone",
	"PG" => "Papua New Guinea",
	"PY" => "Paraguay",
	"YD" => "People's Democratic Republic of Yemen",
	"PE" => "Peru",
	"PH" => "Philippines",
	"PN" => "Pitcairn Islands",
	"PL" => "Poland",
	"PT" => "Portugal",
	"PR" => "Puerto Rico",
	"QA" => "Qatar",
	"RO" => "Romania",
	"RU" => "Russia",
	"RW" => "Rwanda",
	"RE" => "Réunion",
	"BL" => "Saint Barthélemy",
	"SH" => "Saint Helena",
	"KN" => "Saint Kitts and Nevis",
	"LC" => "Saint Lucia",
	"MF" => "Saint Martin",
	"PM" => "Saint Pierre and Miquelon",
	"VC" => "Saint Vincent and the Grenadines",
	"WS" => "Samoa",
	"SM" => "San Marino",
	"SA" => "Saudi Arabia",
	"SN" => "Senegal",
	"RS" => "Serbia",
	"CS" => "Serbia and Montenegro",
	"SC" => "Seychelles",
	"SL" => "Sierra Leone",
	"SG" => "Singapore",
	"SK" => "Slovakia",
	"SI" => "Slovenia",
	"SB" => "Solomon Islands",
	"SO" => "Somalia",
	"ZA" => "South Africa",
	"GS" => "South Georgia and the South Sandwich Islands",
	"KR" => "South Korea",
	"ES" => "Spain",
	"LK" => "Sri Lanka",
	"SD" => "Sudan",
	"SR" => "Suriname",
	"SJ" => "Svalbard and Jan Mayen",
	"SZ" => "Swaziland",
	"SE" => "Sweden",
	"CH" => "Switzerland",
	"SY" => "Syria",
	"ST" => "São Tomé and Príncipe",
	"TW" => "Taiwan",
	"TJ" => "Tajikistan",
	"TZ" => "Tanzania",
	"TH" => "Thailand",
	"TL" => "Timor-Leste",
	"TG" => "Togo",
	"TK" => "Tokelau",
	"TO" => "Tonga",
	"TT" => "Trinidad and Tobago",
	"TN" => "Tunisia",
	"TR" => "Turkey",
	"TM" => "Turkmenistan",
	"TC" => "Turks and Caicos Islands",
	"TV" => "Tuvalu",
	"UM" => "U.S. Minor Outlying Islands",
	"PU" => "U.S. Miscellaneous Pacific Islands",
	"VI" => "U.S. Virgin Islands",
	"UG" => "Uganda",
	"UA" => "Ukraine",
	"SU" => "Union of Soviet Socialist Republics",
	"AE" => "United Arab Emirates",
	"GB" => "United Kingdom",
	"US" => "United States",
	"ZZ" => "Unknown or Invalid Region",
	"UY" => "Uruguay",
	"UZ" => "Uzbekistan",
	"VU" => "Vanuatu",
	"VA" => "Vatican City",
	"VE" => "Venezuela",
	"VN" => "Vietnam",
	"WK" => "Wake Island",
	"WF" => "Wallis and Futuna",
	"EH" => "Western Sahara",
	"YE" => "Yemen",
	"ZM" => "Zambia",
	"ZW" => "Zimbabwe",
	"AX" => "Åland Islands",
);

    public function __construct(
        NodeRepositoryInterface $nodeRepository,
        $template,
        MapManager $mapManager,
        $geolocatorName
    ) {
        $this->nodeRepository = $nodeRepository;
        $this->template = $template;
        $this->mapManager = $mapManager;
        $this->geolocatorName = $geolocatorName;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParams(PropertyInterface $property = null)
    {
        $countries = array();
        foreach(Intl::getRegionBundle()->getCountryNames() as $countryCode => $countryName){
            $countries[strtolower($countryCode)] = new PropertyParameter(strtolower($countryCode), $countryName);
        }
        
        // Need a service to provide countries, see: https://github.com/sulu-cmf/SuluContactBundle/issues/121
        return [
            'countries' => new PropertyParameter(
                'countries',
                $countries,
                'collection'
            ),
            'mapProviders' => new PropertyParameter(
                'mapProviders',
                $this->mapManager->getProvidersAsArray(),
                'collection'
            ),
            'defaultProvider' => new PropertyParameter(
                'defaultProvider',
                $this->mapManager->getDefaultProviderName()
            ),
            'geolocatorName' => new PropertyParameter('geolocatorName', $this->geolocatorName),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::PRE_SAVE;
    }

    /**
     * @param $data
     * @param PropertyInterface $property
     * @param string            $webspaceKey
     * @param string            $languageCode
     * @param string            $segmentKey
     * @param bool              $preview
     */
    protected function setData(
        $data,
        PropertyInterface $property,
        $webspaceKey,
        $languageCode,
        $segmentKey,
        $preview = false
    ) {
        $property->setValue($data);
    }

    /**
     * {@inheritdoc}
     */
    public function read(NodeInterface $node, PropertyInterface $property, $webspaceKey, $languageCode, $segmentKey)
    {
        $data = json_decode($node->getPropertyValueWithDefault($property->getName(), '{}'), true);
        $this->setData($data, $property, $webspaceKey, $languageCode, $segmentKey);
    }

    /**
     * {@inheritdoc}
     */
    public function readForPreview($data, PropertyInterface $property, $webspaceKey, $languageCode, $segmentKey)
    {
        $this->setData($data, $property, $webspaceKey, $languageCode, $segmentKey, true);
    }

    /**
     * {@inheritdoc}
     */
    public function write(
        NodeInterface $node,
        PropertyInterface $property,
        $userId,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        $value = $property->getValue();
        $node->setProperty($property->getName(), json_encode($value));
    }

    /**
     * {@inheritdoc}
     */
    public function remove(NodeInterface $node, PropertyInterface $property, $webspaceKey, $languageCode, $segmentKey)
    {
        if ($node->hasProperty($property->getName())) {
            $node->getProperty($property->getName())->remove();
        }
    }
}