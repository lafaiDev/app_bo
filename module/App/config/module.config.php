<?php

namespace App;
//use Root\Entity\QAdmin;

return array (
		'controllers' => array (
				'invokables' => array (
						'App\Controller\Index' 			=> 'App\Controller\IndexController',
						'App\Controller\Administration' => 'App\Controller\AdministrationController',
					
				) 
		),
		'router' => array (
				'routes' => array (
						'Q_Dashboard' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/Q_Dashboard',
										'defaults' => array (
												'__NAMESPACE__' => 'App\Controller',
												'controller' => 'Index',
												'action' => 'Index'
										)
								)
						),
						'Q_Configuration' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/Q_Configuration',
										'defaults' => array (
												'__NAMESPACE__' => 'App\Controller',
												'controller' => 'Administration',
												'action' => 'Index'
										)
								)
						),

				) 
		),
		'service_manager' => array(
				'abstract_factories' => array(
						'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
						'Zend\Log\LoggerAbstractServiceFactory',
				),
				'factories' => array(
						'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
				),
		),
		'view_manager' => array (
				'display_not_found_reason' => true,
				'display_exceptions'       => true,
				'doctype'                  => 'HTML5',
				'not_found_template'       => 'error/404',
				'exception_template'       => 'error/index',
				'template_map' => array(
						'App/layout' 			  	=> __DIR__ . '/../view/layout/layout.phtml',
		//				'App/layout_auth' 			  	=> __DIR__ . '/../view/layout/layout_auth.phtml',
						'layout/layout'           	=> __DIR__ . '/../view/layout/layout.phtml',
						'navigation_quizz_mywebapp' => __DIR__ . '/../view/navigation/navigation.phtml',
						'app/index/index' 			=> __DIR__ . '/../view/app/index/index.phtml',
						'error/404'               	=> __DIR__ . '/../view/error/404.phtml',
						'error/index'             	=> __DIR__ . '/../view/error/index.phtml',
						
				),
				'template_path_stack' => array(
						'app' => __DIR__ . '/../view',
				),
// 				'template_path_stack' => array (
// 						'user' => __DIR__ . '/../view' 
// 				),
// 				'template_map' => array (
// 						'App/layout' => __DIR__ . '/../view/layout/layout_auth.phtml' 
// 				),
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		),
	
);