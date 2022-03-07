<?php

include_once(dirname(__FILE__) . "/../Services/impl/invoicesvc.php");
include_once(dirname(__FILE__) . "/../Services/impl/ledgersvc.php");

class Customer
{
    private $customerId;
    private $name;
    private $address;

    public function __construct($name, $address)
    {
        $this->customerId = "cID-" . Util::guidv4();
        $this->name = $name;
        $this->address = $address;
    }

    /**
     * Get the customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function __toString()
    {
        return "Name: " . $this->name . PHP_EOL . "Address: " . $this->address;
    }

    /**
     * Generates and prints the latest invoice using the Invoice Service for the current user based on the discount
     */
    public function getInvoice($discount)
    {
        $latestInvoice = InvoiceService::createInvoiceForCustomer($this, $discount);
        if ($latestInvoice == null) {
            echo 'No line items to create invoice' . PHP_EOL;
            return;
        }
        return $latestInvoice;
    }

    /**
     * Creates a new transaction against the current user with the Ledger Service
     */
    public function addLineItem(LineItem $lineItem)
    {
        LedgerService::addLineItem($this, $lineItem);
    }
}
