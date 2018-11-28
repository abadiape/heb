<?php
class Heb_Customerform_AccountController extends Mage_Core_Controller_Front_Action
{   
    /**
     * Retrieve customer session object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
    /**
     * Customer custom form
     */
    public function indexAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()):
            $this->_redirect('customer/account/login');
            return;
        endif;

        $this->loadLayout();
        $this->renderLayout();
    }
    
}

