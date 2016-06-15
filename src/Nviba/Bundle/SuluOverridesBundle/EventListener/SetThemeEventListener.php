<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nviba\Bundle\SuluOverridesBundle\EventListener;

use Sulu\Bundle\WebsiteBundle\EventListener\SetThemeEventListener as BaseThemeEventListener;
use Liip\ThemeBundle\ActiveTheme;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;

/**
 * Description of SetThemeEventListener
 *
 * @author daniel
 */
class SetThemeEventListener extends BaseThemeEventListener{

    protected $originalListener;
    
    public function __construct(
        RequestAnalyzerInterface $requestAnalyzer,
        ActiveTheme $activeTheme,
        $portalThemesConfig
    ) {
        $this->requestAnalyzer = $requestAnalyzer;
        $this->activeTheme = $activeTheme;
        $this->portalThemesConfig = $portalThemesConfig;
    }

    
    /**
     * Set the active theme if there is a portal.
     */
    public function setActiveTheme()
    {
        $portal = $this->requestAnalyzer->getPortal();
        
        if (null === $portal) {
            return;
        }

        if(array_key_exists($portal->getKey(),$this->portalThemesConfig)){
            $themeKey = $portal->getKey();
        }else{        
            $themeKey = $portal->getWebspace()->getTheme()->getKey();
        }
        $this->activeTheme->setName($themeKey);
    }
    
}
