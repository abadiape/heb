<?php
/**
 * Customerform Info Resource Collection
 *
 * @category    Heb
 * @package     Heb_Customerform
 * @author      Pedro Abadía <abadiape@gmail.com>
 */
class Heb_Customerform_Model_Resource_Info_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
            $this->_init('customerform/info');
    }
}

