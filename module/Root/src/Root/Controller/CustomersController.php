<?php

namespace Root\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomersController extends AbstractActionController
{
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

    public function indexAction()
    {
        return (new ViewModel());
    }

    public function customerDatatableAction()
    {
    	$tabjson=[];
    	$customers = $this->getEntityManager ()->getRepository ( 'Root\Entity\QAdmin' )->findBy ( ['type' => 'Customer'], [ ] );
    	if ($customers != null) {
    		foreach ( $customers as $c ) {
    			$tempTab = [];
    			$tempTab [] = '<input type="checkbox" class="checkboxes" value="" />';
    			$tempTab [] = $c->getCompany ();
    			$tempTab [] = $c->getLogin ();
    			$tempTab [] = ($c->getCreationdate () != null) ? $c->getCreationdate ()->format ('d/m/Y') : '--';
    		
    			$tempTab [] = ($c->getIsactive () == 1) ? '<span class="label label-sm label-success">Oui</span>' : '<span class="label label-sm label-danger">Non</span>';
    			
    			$tempTab [] = '<a href="" class="btn default green-stripe btn-sm"> <i class="fa fa-edit"></i> Editer </a>
    						<a href="' . $c->getRouting () . '" class="btn default blue-stripe btn-sm"> <i class="fa fa-sign-in"></i> Autologin </a>'; // fa-tags fa-superscript
    	
    			$tabjson [] = $tempTab;
    		}
    	}
    	
    	$resultsajax = array (
    			"aaData" => $tabjson
    	);
    	echo json_encode( $resultsajax );
    	exit ();
    }

}

