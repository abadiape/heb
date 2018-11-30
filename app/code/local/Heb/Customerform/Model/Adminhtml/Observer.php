<?php
/* 
 * Saves HEB customer custom form data when modified from admin.
 * 
 */
class Heb_Customerform_Model_Adminhtml_Observer {
    
    public function saveFormulario($observer) {
        $customer = $observer->getCustomer();
        // Save data
        if ($this->_getRequest()->isPost()) {                                                    
            $customerId = $customer->getId();
            $email = $this->_getRequest()->getParam('email');
            $date = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
            $data = $this->_getRequest()->getParams();            
            
            /* @var $info Heb_Customerform_Model_Info */
            $infoModel  = Mage::getModel('customerform/info');

            $info = [];
            foreach ($data as $key => $value)
            {
               if ($key !== 'form_key' && $key !== 'year' && $key !== 'email-confirmation' && strlen($value) > 2)
               {
                  $info[$key] = $value; 
               }                   
            }

            $hebCustomerCollection  = $infoModel->getCollection()->addFieldToFilter('parent_id', $customerId);        
            foreach($hebCustomerCollection as $collection)
            {
                $info['entity_id'] = $collection->getData('entity_id');
                $info['updated_at'] = $date;
            }                

            $info['parent_id'] = $customerId; 
            if (!$hebCustomerCollection->getSize())
            {
                $info['created_at'] = $date;
                $info['updated_at'] = $date;
            }

            $infoModel->setData($info);                 
            
        }
        
        $errors = [];
        Mage::log(print_r($info, true), null, 'papu.log');
        Mage::log(print_r($data, true), null, 'papu.log');
    } 
    
    /**
     * Shortcut to getRequest
     *
     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }
}

