<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Customer
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'heb_customer_info'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('customerform/hebcustomer_info'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('firstname', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        ), 'Nombres')
    ->addColumn('father_lastname', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        ), 'Apellido Paterno')
    ->addColumn('mother_lastname', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        ), 'Apellido Materno')
    ->addColumn('dob', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Fecha de Nacimiento')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Email')
    ->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, 16, array(
        ), 'Telefono')    
    ->addColumn('parent_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => true,
        ), 'Parent Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Updated At')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
        ), 'Is Active')
    ->addIndex($installer->getIdxName('customerform/hebcustomer_info', array('parent_id')),
        array('parent_id'))
    ->addForeignKey($installer->getFkName('customerform/hebcustomer_info', 'parent_id', 'customer/entity', 'entity_id'),
        'parent_id', $installer->getTable('customer/entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('HEB Customer Custom Data');
$installer->getConnection()->createTable($table);

$installer->endSetup();

