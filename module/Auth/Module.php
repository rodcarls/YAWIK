<?php
/**
 * Cross Applicant Management
 * Auth Module Bootstrap
 *
 * @copyright (c) 2013 Cross Solution (http://cross-solution.de)
 * @license   GPLv3
 */

namespace Auth;

use Zend\Mvc\MvcEvent;
use Auth\View\InjectLoginInfoListener;
/**
 * Bootstrap class of the Core module
 * 
 */
class Module
{

    /**
     * Loads module specific configuration.
     * 
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Loads module specific autoloader configuration.
     * 
     * @return array
     */
    public function getAutoloaderConfig()
    {
        
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                // This is an hack due to bad design of Hybridauth
                // This ensures the class from "addtional-providers" is loaded.
                array(
                    'Hybrid_Providers_XING'
                    => __DIR__ . '/../../vendor/hybridauth/hybridauth/additional-providers/hybridauth-xing/Providers/XING.php',
                ),
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getEventManager()->attach(
            MvcEvent::EVENT_RENDER,
            array(new InjectLoginInfoListener(), 'injectLoginInfo')
        );
    }
    
}
