<?php

include_once("ledgersvc.php");
include_once(dirname(__FILE__) . "/../AbstractService.php");
include_once(dirname(__FILE__) . "/../../Models/invoice.php");

class InvoiceService extends AbstractService
{
    private $customerInvoices = [];

    protected function _addInvoice(Invoice $invoice)
    {
        $customerId = $invoice->getCustomer()->getCustomerId();
        $invoiceNumber = $invoice->getNumber();
        if (!isset($this->customerInvoices[$customerId])) {
            $this->customerInvoices[$customerId] = [];
        }

        if (!isset($this->customerInvoices[$customerId][$invoiceNumber])) {
            $this->customerInvoices[$customerId][$invoiceNumber] = $invoice;
        }
    }

    // Static method that generates the invoice for the given 
    // customer and applies the given discount
    public static function createInvoiceForCustomer(Customer $customer, int $discount)
    {
        // Fetches all the unbilled transactions done by the customer
        $lineItems = LedgerService::getUnbilledLineItemsByCustomer($customer) ?? [];
        if (empty($lineItems)) {
            return null;
        }

        // Creates a new invoice
        $invoice = new Invoice();
        $invoice->setCustomer($customer)->bulkAddLines($lineItems)->addDiscount($discount);

        // Adds the invoice to the system
        $service = static::getInstance();
        $service->_addInvoice($invoice);

        // Marking the transactions as Billed, so further invoices 
        // will not show already invoiced transactions
        array_map('LedgerService::markLineItemAsBilled', $lineItems);
        return $invoice;
    }

    // Static method that generates a file for the given invoice
    public static function writeInvoiceToFile(Invoice $invoice)
    {
        $file = fopen($invoice->getNumber() . ".txt", "w");
        $content = $invoice->getInvoiceContent();
        fwrite($file, $content);
        fclose($file);
    }
}
