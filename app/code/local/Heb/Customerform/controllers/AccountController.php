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
    /**
     * Saves customer custom form data in DB table heb_customer_info
     */
    public function formPostAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }
        // Save data
        if ($this->getRequest()->isPost()) {
            $customer = $this->_getSession()->getCustomer();                                         
            $customerId = $this->getRequest()->getParam('id');
            $email = $this->getRequest()->getParam('email');
            $date = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
            $data = $this->getRequest()->getParams();
            
            if ($customerId == $customer->getId()) {
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

            try {
                /*$addressErrors = $address->validate();
                if ($addressErrors !== true) {
                    $errors = array_merge($errors, $addressErrors);
                }*/
                if ($email !== $this->getRequest()->getParam('email-confirmation'))
                {
                    $errors[] = 'Verifique por favor su email, los campos relacionados deben coincidir.';
                }
                if (count($errors) === 0) {
                    $infoModel->save();
                    $this->_getSession()->addSuccess($this->__('Sus datos han sido guardados.'));
                    $this->_redirectSuccess(Mage::getUrl('customer/account/index', array('_secure'=>true)));
                    return;
                } else {
                    $this->_getSession()->setAddressFormData($this->getRequest()->getPost());
                    foreach ($errors as $errorMessage) {
                        $this->_getSession()->addError($errorMessage);
                    }
                }
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->setAddressFormData($this->getRequest()->getPost())
                    ->addException($e, $e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->setAddressFormData($this->getRequest()->getPost())
                    ->addException($e, $this->__('Cannot save form.'));
            }
        }

        return $this->_redirectError(Mage::getUrl('*/*/edit', array('id' => $customerId)));
    }
}

