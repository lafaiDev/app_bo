<?php

namespace Root\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;


class ServiceLoginAuthController extends AbstractActionController
{
	protected $storage;
	protected $authservice;
	protected $em = null;

	/**
	 * getEntityManager
	 */
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
		}
		return $this->em;
	}
	
	public function getAuthService() {
		if (! $this->authservice) {
			$this->authservice = $this->getServiceLocator ()->get ( 'Zend\Authentication\AuthenticationService' );
		}
		return $this->authservice;
	}
	
	public function getSessionStorage() {
		if (! $this->storage) {
			$this->storage = $this->getServiceLocator ()->get ( 'Root\Model\MyAuthStorage' );
		}
		return $this->storage;
	}
	
	/**
	 * Formulaire de login
	 * {@inheritDoc}
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
    public function indexAction()
    {
        return (new ViewModel())->setTerminal(true);
    }
	
    /**
     * La fonction authenticate
     */
    public function authenticateAction() {
    	$redirect = "login";

    	$request = $this->getRequest ();
    	
    	if ($request->isPost ()) {
    		$data = $this->getRequest ()->getPost ();
    		// check authentification
    		$this->getAuthService ()->getAdapter ()->setIdentity ( $data ['login'] )->setCredential ( $data ['password'] );
    		$result = $this->getAuthService ()->authenticate ();
    //		var_dump($result);exit;
    		if ($result->isValid ()) {
    			// redirect to home route, Todo: remember orginal route and redirect there after authentification
    			$authenticationService = new AuthenticationService ();
    			$authenticationService = $this->getServiceLocator ()->get ( 'Zend\Authentication\AuthenticationService' );
    			$loggedRoot = $authenticationService->getIdentity ();
    			// Si le user est blocker
    			 if ($loggedRoot->getIsactive() != 0) {
    				$redirect = $loggedRoot->getRouting();
    				
    				$this->getSessionStorage ()->write ( $data ['login'] );
    				$responseJson = array (
    						'success' => true,
    						'redirect' => $redirect
    				);
    			} else {
    				//error_log('Utilisateur blocker');
    				$responseJson = array (
    						'success' => false
    				);
    			} 
    		} else {
    			$responseJson = array (
    					'success' => false
    			);
    		}
    	}
    
    	return new JsonModel ( $responseJson );
    }
    /**
     * La fonction logout
     */
    public function logoutAction() {
    	$this->getSessionStorage ()->forgetMe ();
    	$this->getAuthService ()->clearIdentity ();
    
    	$this->flashMessenger ()->addMessage ( "You have been logged out!" );
    	return $this->redirect ()->toRoute ( "login" );
    }

}

