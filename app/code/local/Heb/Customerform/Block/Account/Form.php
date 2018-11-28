<?php
class Heb_Customerform_Block_Account_Form extends Mage_Core_Block_Template
{   
    public function getBackButtonUrl()
    {
        if ($this->getCustomerAddressCount()) {
            return $this->getUrl('customer/address');
        } else {
            return $this->getUrl('customer/account/');
        }
    }    
    
    public function getBackUrl()
    {
        if ($this->getData('back_url')) {
            return $this->getData('back_url');
        }

        if ($this->getCustomerAddressCount()) {
            return $this->getUrl('customer/address');
        } else {
            return $this->getUrl('customer/account/');
        }
    }
    
    public function getCustomer()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if ($customer->getId()):
            return $customer;
        endif;

        return false;
    }
    
    public function getSaveUrl()
    {
        return Mage::getUrl('customerform/account/formPost', array('_secure'=>true, 'id'=>$this->getCustomer()->getId()));
    }
    
    public function getTitle()
    {
        return 'Cliente Preferencial';
    }
}


