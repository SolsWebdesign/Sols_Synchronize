<?php
/*
 * solswebdesign.nl
 *
 * @category    Sols
 * @copyright   Copyright (c) 2017 SolsWebdesign
 */
class Sols_Synchronized_Block_Adminhtml_Invoicegrid extends Mage_Adminhtml_Block_Sales_Invoice_Grid
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('synchronized', array(
            'header'    => Mage::helper('sales')->__('Synchronized'),
            'index'     => 'synchronized',
            'type'      => 'text',
            'width'     => '80px',
            'renderer'  => 'Sols_Synchronized_Block_Renderer_Check'
        ));

        return parent::_prepareColumns();
    }
}