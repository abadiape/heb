<?php
/**
 * Customerform info resource model
 *
 * @category    Heb
 * @package     Heb_Customerform
 * @author      Pedro Abadía <abadiape@gmail.com>
 */
class Heb_Customerform_Model_Resource_Info extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('customerform/hebcustomer_info', 'entity_id');
    }
}
