<?php
/*
 * solswebdesign.nl
 *
 * @category    Sols
 * @copyright   Copyright (c) 2017 SolsWebdesign
 */
$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE `{$installer->getTable('sales/invoice_grid')}`  ADD COLUMN `synchronized` tinyint(1) NOT NULL default '0';
    ALTER TABLE `{$installer->getTable('sales/creditmemo_grid')}`  ADD COLUMN `synchronized` tinyint(1) NOT NULL default '0';
");

$installer->endSetup();