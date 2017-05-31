<?php

namespace App\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
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
    	$qb = $this->getEntityManager ()->createQueryBuilder ();
    //	$qb->select ( 'u' )->from ( 'Root\Entity\QUser', 'u' )->where ( 'u.idEnseigne = :idEnseigne' )->setParameter ( 'idEnseigne', $idEnseigne )->orderBy ( 'u.id', 'DESC' );
    	$qb->select ( 'COUNT(u)' )->from ( 'Root\Entity\QUser', 'u' );
    	$users = $qb->getQuery ()->getResult ();
//    	$adressesUser = $this->getEntityManager ()->getRepository ( 'Root\Entity\QUser' )->findBy ( ['idUtilisateur' => $user->getId ()], [ ] );
    	$qbt = $this->getEntityManager ()->createQueryBuilder ();
    	$qbt->select ( 'COUNT(t)' )->from ( 'Root\Entity\QTest', 't' );
    	$tests = $qbt->getQuery ()->getResult ();
    	$qbtg = $this->getEntityManager ()->createQueryBuilder ();
    	$qbtg->select ( 'COUNT(t)' )->from ( 'Root\Entity\QTest', 't' )->where ( 't.result = :result' )->setParameter ( 'result', 'Gagné' );
    	$testsG = $qbtg->getQuery ()->getResult ();
    	$qbtp = $this->getEntityManager ()->createQueryBuilder ();
    	$qbtp->select ( 'COUNT(t)' )->from ( 'Root\Entity\QTest', 't' )->where ( 't.result = :result' )->setParameter ( 'result', 'Perdu' );
    	$testsP = $qbtp->getQuery ()->getResult ();
    	$stats = [
    		'u' => 	$users != null ? $users[0][1]:0,
    		't' => 	$tests != null ? $tests[0][1]:0,
    		'g' => 	$testsG != null ? $testsG[0][1]:0,
    		'pg' => $testsG != null ? number_format(($testsG[0][1] / $tests[0][1])*100,2):0,
    		'p' => 	$testsP != null ? $testsP[0][1]:0,
    		'pp' => $testsP != null ? number_format(($testsP[0][1] / $tests[0][1])*100,2):0,
    	];
    	//var_dump($stats);exit;
        return new ViewModel([
        		'stats' => $stats
        ]);
    }


}

