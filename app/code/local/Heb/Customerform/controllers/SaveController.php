<?php
/* 
 * Saves HEB customer custom form data when modified from admin.
 * 
 */
class Heb_Customerform_SaveController extends Mage_Core_Controller_Front_Action 
{
    
    public function formPostAction() {        
        // Save data
        if ($this->getRequest()->isPost()) {                                                    
            $customerId = $this->getRequest()->getParam('id');            
            $date = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s');
            $data = $this->getRequest()->getParams();            
            
            /* @var $info Heb_Customerform_Model_Info */
            $infoModel  = Mage::getModel('customerform/info');

            $info = [];
            foreach ($data as $key => $value)
            {
               if ($key !== 'form_key' && $key !== 'dob' && $key !== 'email-confirmation')
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
            $info['dob'] = $info['month'] . "/" . $info['day'] . "/" . $info['year'];
            if (!$hebCustomerCollection->getSize())
            {
                $info['created_at'] = $date;
                $info['updated_at'] = $date;
            }

            $infoModel->setData($info);                 
            
        }
        
        $errors = [];
        
        try {            
            if ($info['email'] !== $data['email-confirmation'])
            {
                $errors[] = 'Verifique por favor su email, los campos relacionados deben coincidir.';
            }
            if (count($errors) === 0) {
                $infoModel->save();                
                echo 'Los datos del cliente han sido guardados.';
            } else {
                echo 'Los datos no pudieron ser guardados!';
            }
        } catch (Mage_Core_Exception $e) {
            Mage::log(print_r($e->getMessage(), true));
        } catch (Exception $e) {
            Mage::log(print_r($e->getMessage(), true));
        }
   
    } 
    
    public function deleteFormAction() {
        if ($this->getRequest()->isPost()) {                                                    
            $customerId = $this->getRequest()->getParam('id');
            $collection = Mage::getModel('customerform/info')->getCollection()->addFieldToFilter('parent_id', $customerId);                    
            foreach ($collection as $item) {
                try {
                    $item->delete();
                    echo 'Los datos del cliente han sido eliminados.';
                } catch (Exception $e) {
                    Mage::log(print_r($e->getMessage(), true));
                }
                
            }
        }
    }
}

