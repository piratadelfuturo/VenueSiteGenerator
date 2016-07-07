<?php
namespace Nviba\Bundle\SuluOverridesBundle\Controller;

use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sulu\Bundle\WebsiteBundle\Controller\ExceptionController as BaseController;
use Liip\ThemeBundle\ActiveTheme;
use Sulu\Bundle\WebsiteBundle\Resolver\ParameterResolverInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;


/**
 * Description of ExceptionController
 *
 * @author daniel
 */
class ExceptionController extends BaseController{

    
    protected $requestAnalyzer;
    
    protected $parameterResolver;
    
    protected $activeTheme;
    
        public function __construct(
        \Twig_Environment $twig,
        $debug,
        ParameterResolverInterface $parameterResolver,
        RequestAnalyzerInterface $requestAnalyzer = null,
        ActiveTheme $activeTheme
    ) {
        $this->requestAnalyzer = $requestAnalyzer;
        $this->parameterResolver = $parameterResolver;
        $this->activeTheme = $activeTheme;
        parent::__construct($twig, $debug, $this->parameterResolver, $this->requestAnalyzer);

    }
    
    
    public function showAction(
        Request $request,
        FlattenException $exception,
        DebugLoggerInterface $logger = null            
    ) {
        
        if ($webspace = $this->requestAnalyzer->getWebspace()) {
            $this->activeTheme->setName($webspace->getTheme()->getKey());
        }
        
        return parent::showAction($request,$exception,$logger);
    }
    
}