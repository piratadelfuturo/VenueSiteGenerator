<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'AbstractKernel.php';

class WebsiteKernel extends \AbstractKernel
{
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
        $this->setContext(self::CONTEXT_WEBSITE);
    }

    public function registerBundles()
    {
        $bundles = parent::registerBundles();
        $bundles[] = new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle();

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new JMS\DiExtraBundle\JMSDiExtraBundle($this);
            $bundles[] = new JMS\AopBundle\JMSAopBundle();
        }
        
        return $bundles;
    }
}
