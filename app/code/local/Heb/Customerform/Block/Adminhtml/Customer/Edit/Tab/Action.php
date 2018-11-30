<?php

class Heb_Customerform_Block_Adminhtml_Customer_Edit_Tab_Action extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    /**
     * Set the template for the block
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('customerform/hebcustomer/hebform.phtml');
    }
    /**
     * Retrieve the label used for the related tab 
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Formulario');
    }
    /**
     * Retrieve the tab title 
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Haga clic aquí para visualizar el contenido del Formulario');
    }
    /**
     * Determines whether to display the tab
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * Stops the tab being hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
    /**
     * Gets related customer object
     *
     * @return bool
     */
    public function getCustomer()
    {
        $customerId = $this->getRequest()->getParam('id');
        
        if ($customerId):
            $customer = Mage::getSingleton('customer/customer')->load($customerId);
            return $customer;
        endif;

        return false;
    }
    /**
     * Retrieve HEB customer email field value from table heb_customer_info
     *
     * @return string
     */
    public function getEmail()
    {
        $customerId = $this->getRequest()->getParam('id'); 
        $hebCustomerCollection  = Mage::getModel('customerform/info')
                                ->getCollection()
                                ->addFieldToFilter('parent_id', $customerId);
        
        foreach($hebCustomerCollection as $collection)
        {
            return $collection->getData('email');
        }
    }
    /**
     * Retrieve HEB customer phone field value from table heb_customer_info
     *
     * @return string
     */
    public function getPhone()
    {        
        $customerId = $this->getRequest()->getParam('id'); 
        $hebCustomerCollection  = Mage::getModel('customerform/info')
                                ->getCollection()
                                ->addFieldToFilter('parent_id', $customerId);
        
        foreach($hebCustomerCollection as $collection)
        {
            return $collection->getData('phone');
        }
    }
}

