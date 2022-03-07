<?php

include_once(dirname(__FILE__) . "/../AbstractService.php");

// The Service that tracks all the transactions done in the system
// ideally these sorts of services are a bridge between the 
// Database and Application
class LedgerService extends AbstractService
{
    private $ledger = [];

    protected function _addLineItem(LineItem $line)
    {
        if (!isset($this->ledger[$line->getId()])) {
            $this->ledger[$line->getId()] = $line;
        }
    }

    // Static method that adds the LineItem to the ledger
    // after fetching the singleton service instance
    public static function addLineItem(Customer $customer, LineItem $line)
    {
        $line->setCustomerId($customer->getCustomerId());

        $service = static::getInstance();
        $service->_addLineItem($line);
    }

    // Static method that gets all the unbilled LineItems from the ledger
    // for the given customer after fetching the singleton service instance
    public static function getUnbilledLineItemsByCustomer(Customer $customer)
    {
        $service = static::getInstance();
        $customerId = $customer->getCustomerId();
        $unbilledLineItems = [];

        // Iterates through the ledger and combs for the transactions associated 
        // to the customer and is yet to be billed
        foreach ($service->ledger as $lineItemId => $lineItem) {
            if ($lineItem->getCustomerId() == $customerId && !$lineItem->getIsBilled()) {
                array_push($unbilledLineItems, $lineItem);
            }
        }
        return $unbilledLineItems;
    }

    // Static method that marks all the unbilled LineItems 
    // in the ledger as billed, so that it wouldn't be 
    // reflecting in further invoices 
    public static function markLineItemAsBilled(LineItem $lineItem)
    {
        $service = static::getInstance();
        $lineItemId = $lineItem->getId();
        if (isset($service->ledger[$lineItemId])) {
            $service->ledger[$lineItemId]->setIsBilled(true);
        }
    }
}
