<?php
/*
 * solswebdesign.nl
 *
 * @category    Sols
 * @copyright   Copyright (c) 2017 SolsWebdesign
 */
class Sols_Synchronized_Model_Synchronize extends Mage_Core_Model_Abstract
{
    protected $logging = false;
    public    $logfile;
    protected $tblPrfx;

    public function _construct()
    {
        $date               = date('Y-m-d');
        $this->logfile      = 'sols_synchronized_' . $date . '.log';
        $this->tblPrfx      = (string)Mage::getConfig()->getTablePrefix();
    }

    public function checkInvoices()
    {
        $syncArray  = array();
        $mageDb     = Mage::getSingleton('core/resource')->getConnection('core_read');
        $mageDbW    = Mage::getSingleton('core/resource')->getConnection('core_write');
        $sql        = "SELECT entity_id FROM ".$this->tblPrfx."sales_flat_invoice_grid WHERE synchronized = 0";
        $results    = $mageDb->query($sql);
        if($results) {
            $i = 0;
            while($obj  = $results->fetch()){
                if(isset($obj['entity_id'])) {
                    $invoiceId = $obj['entity_id'];
                    $synced    = $this->checkIfInvoiceSynchronized($invoiceId);
                    if($synced) {
                        array_push($syncArray, $invoiceId);
                    }
                }
                $i++;
            }
            if($this->logging) {
                Mage::log('checkInvoices ' . $i . ' invoices doorlopen', null, $this->logfile);
            }
        } else {
            if($this->logging) {
                Mage::log('checkInvoices geen resultaten gevonden', null, $this->logfile);
            }
        }
        if(count($syncArray) > 0) {
            foreach ($syncArray as $invoiceId) {
                $sqlUpdate = "UPDATE " . $this->tblPrfx . "sales_flat_invoice_grid SET synchronized = 1 WHERE entity_id = ?";
                $results = $mageDbW->query($sqlUpdate, $invoiceId);
            }
        }
    }

    public function checkCreditMemos()
    {
        $mageDb     = Mage::getSingleton('core/resource')->getConnection('core_read');
        $mageDbW    = Mage::getSingleton('core/resource')->getConnection('core_write');
        $syncArray  = array();
        $sql        = "SELECT entity_id FROM ".$this->tblPrfx."sales_flat_creditmemo_grid WHERE synchronized = 0";
        $results    = $mageDb->query($sql);
        if($results) {
            while($obj  = $results->fetch()){
                if(isset($obj['entity_id'])) {
                    $creditMemoId   = $obj['entity_id'];
                    $synced         = $this->checkIfCreditMemoSynchronized($creditMemoId);
                    if($synced) {
                        array_push($syncArray, $creditMemoId);
                    }
                }
            }
        }
        if(count($syncArray) > 0) {
            foreach ($syncArray as $creditMemoId) {
                $sqlUpdate = "UPDATE " . $this->tblPrfx . "sales_flat_creditmemo_grid SET synchronized = 1 WHERE entity_id = ?";
                $results = $mageDbW->query($sqlUpdate, $creditMemoId);
            }
        }
    }

    public function checkIfInvoiceSynchronized($invoiceId)
    {
        $mageDb     = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql        = "SELECT * FROM ".$this->tblPrfx."sales_flat_invoice_comment WHERE comment = ? AND parent_id = ? LIMIT 1";
        $stmt       = $mageDb->query($sql, array('synchronized', $invoiceId));
        $entity     = $stmt->fetch();
        if ($entity) {
            return true;
        } else {
            return false;
        }
    }

    public function checkIfCreditMemoSynchronized($creditMemoId)
    {
        $mageDb     = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql        = "SELECT * FROM ".$this->tblPrfx."sales_flat_creditmemo_comment WHERE comment = ? AND parent_id = ? LIMIT 1";
        $stmt       = $mageDb->query($sql, array('synchronized', $creditMemoId));
        $entity     = $stmt->fetch();
        if ($entity) {
            return true;
        } else {
            return false;
        }
    }
}