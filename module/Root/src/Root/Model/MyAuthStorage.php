<?php
namespace Root\Model;
 
use Zend\Authentication\Storage;
 
class MyAuthStorage extends Storage\Session
{
    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    } 
}