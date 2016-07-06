<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nviba\Bundle\ToolsBundle\Twig;

use Symfony\Component\Intl\Intl;

/**
 * Description of newPHPClass
 *
 * @author daniel
 */
class IntlExtension extends \Twig_Extension{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('nv_language_name', array($this, 'languageName')),
            new \Twig_SimpleFilter('nv_country_name', array($this, 'countryName')),
        );
    }

    public function languageName($language_code)
    {
        $originalLang = \Locale::getDefault();
        \Locale::setDefault($language_code);
        $language = Intl::getLanguageBundle()->getLanguageName($language_code);
        \Locale::setDefault($originalLang);
        return $language;
    }
    
    public function countryName($country_code){
        $country = Intl::getRegionBundle()->getCountryName($country_code);
        
        return $country;
    }

    public function getName()
    {
        return 'nviba_intl';
    }
}
