<?php

namespace App;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module {
	public function onBootstrap(MvcEvent $event) {
		$eventManager = $event->getApplication ()->getEventManager ();
		$moduleRouteListener = new ModuleRouteListener ();
		$moduleRouteListener->attach ( $eventManager );
		// add function authPreDispatch before every action in every module
// 		$eventManager->attach ( MvcEvent::EVENT_DISPATCH, array (
// 				$this,
// 				'authPreDispatch'
// 		), 1 );
	}
	/**
	 * redirect not autentificated user to login route
	 */
// 	public function authPreDispatch(MvcEvent $event) {
// 		$authenticationService = new AuthenticationService ();
// 		$authenticationService_u = new AuthenticationService ();
// 		// La liste des routes non sécurisé
// 		$routes_non_secured = array (
// 				"forgot_password",
// 				"reset-password",
// 				"update_newpassword",
// 		);
	
// 		if (! in_array ( $event->getRouteMatch ()->getMatchedRouteName (), $routes_non_secured )) {
	
// 			$identity = $authenticationService->getIdentity ();
// 			// var_dump($event->getRouteMatch ());
// 			// var_dump($identity->getIdfkprofil()->getNameprofil());
	
// 			if ($identity) {
// 				$authenticationService_u = $event->getApplication ()->getServiceManager ()->get ( 'Zend\Authentication\AuthenticationService' );
// 				$loggedUser = $authenticationService_u->getIdentity ();
// 				// publish identity to viewmodel for use in layout
// 				$event->getViewModel ()->setVariable ( 'loggedUser', $loggedUser );
// 				$event->getViewModel ()->setVariable ( 'identity', $identity );
// 				// get username from MyAuthStorage to publish to viewmodel
// 				$event->getViewModel ()->setVariable ( 'username', $event->getApplication ()->getServiceManager ()->get ( 'App\Model\MyAuthStorage' )->read () );
// 			}
// 			// redirect if not logged in and not in route 'login'
// 			if (! $identity && $event->getRouteMatch ()->getMatchedRouteName () != "login") {
// 				$url = $event->getRouter ()->assemble ( array (), array (
// 						'name' => 'login'
// 				) );
	
// 				$response = $event->getResponse ();
// 				$response->getHeaders ()->addHeaderLine ( 'Location', $url );
// 				$response->setStatusCode ( 302 );
// 				$response->sendHeaders ();
// 				exit ();
// 			}
// 		}
// 	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function init(ModuleManager $mm) {
		$mm->getEventManager ()->getSharedManager ()->attach ( __NAMESPACE__, 'dispatch', function ($e) {
			$e->getTarget ()->layout ( 'App/layout' );
		} );
	}
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
// 	public function getServiceConfig() {
// 		return array (
// 				"factories" => array (
// 						"App\Model\MyAuthStorage" => function ($serviceManager) {
// 							return new \App\Model\MyAuthStorage ( "myauthstorage" );
// 						},
// 						'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
// 							// If you are using DoctrineORMModule:
// 							return $serviceManager->get ( 'doctrine.authenticationservice.orm_default' );
// 						} 
// 				) 
// 		);
// 	}
}
