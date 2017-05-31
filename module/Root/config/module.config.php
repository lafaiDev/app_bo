<?php

namespace Root;
use Root\Entity\QAdmin;

return array (
		'controllers' => array (
				'invokables' => array (
						'Root\Controller\ServiceLoginAuth' => 'Root\Controller\ServiceLoginAuthController',
				//		'Root\Controller\Index' 			=> 'Root\Controller\IndexController',
				//		'Root\Controller\Administration' => 'Root\Controller\AdministrationController',
						'Root\Controller\Customers' => 'Root\Controller\CustomersController',
				) 
		),
		'router' => array (
				'routes' => array (
						'Customers' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/Customers',
										'defaults' => array (
												'__NAMESPACE__' => 'Root\Controller',
												'controller' => 'Customers',
												'action' => 'Index'
										)
								)
						),
						'customers_datatable' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/customers_datatable',
										'defaults' => array (
												'__NAMESPACE__' => 'Root\Controller',
												'controller' => 'Customers',
												'action' => 'customerDatatable'
										)
								)
						),
						'login' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/',
										'defaults' => array (
												'__NAMESPACE__' => 'Root\Controller',
												'controller' => 'ServiceLoginAuth',
												'action' => 'Index' 
										) 
								) 
						),
						'service_login' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/ServiceLoginAuth',
										'defaults' => array (
												'__NAMESPACE__' => 'Root\Controller',
												'controller' => 'ServiceLoginAuth',
												'action' => 'authenticate' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'process' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:action]',
														'constraints' => array (
																'route' => array (
																		'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																		'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
																),
																'defaults' => array () 
														) 
												) 
										) 
								) 
						),
						'logout' => array (
								'type' => 'literal',
								'options' => array (
										'route' => '/logout',
										'defaults' => array (
												'__NAMESPACE__' => 'Root\Controller',
												'controller' => 'ServiceLoginAuth',
												'action' => 'logout' 
										) 
								) 
						) 
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
						'Root/layout' 			  	=> __DIR__ . '/../view/layout/layout.phtml',
						'Root/layout_auth' 			=> __DIR__ . '/../view/layout/layout_auth.phtml',
						'layout/layout'           	=> __DIR__ . '/../view/layout/layout.phtml',
						'navigation_root_mywebapp' => __DIR__ . '/../view/navigation/navigation.phtml',
						'root/index/index' 			=> __DIR__ . '/../view/root/index/index.phtml',
						'error/404'               	=> __DIR__ . '/../view/error/404.phtml',
						'error/index'             	=> __DIR__ . '/../view/error/index.phtml',
						
				),
				'template_path_stack' => array(
						'root' => __DIR__ . '/../view',
				),
// 				'template_path_stack' => array (
// 						'user' => __DIR__ . '/../view' 
// 				),
// 				'template_map' => array (
// 						'Root/layout' => __DIR__ . '/../view/layout/layout_auth.phtml' 
// 				),
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		),
		/**
		 * Configuration doctrine
		 */
		'doctrine' => array (
				'driver' => array (
						__NAMESPACE__ . '_driver' => array (
								'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
								'cache' => 'array',
								'paths' => array (
										__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
								)
						),
						'orm_default' => array (
								'drivers' => array (
										__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
								)
						)
				),
				'authentication' => array (
						'orm_default' => array (
								'object_manager' => 'Doctrine\ORM\EntityManager',
								'identity_class' => 'Root\Entity\QAdmin',
								'identity_property' => 'login',
								'credential_property' => 'password',
								'credential_callable' => function (Entity\QAdmin $user, $passwordGiven) {
									
									if ($user->getPassword () == md5 ( $passwordGiven )) {
										return true;
									}
									return false;
								} 
						) 
				) 
		) 
);