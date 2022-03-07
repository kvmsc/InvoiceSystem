<?php

include_once(dirname(__FILE__) . "/../Services/impl/invoicesvc.php");

class Invoice
{
    protected $number;
    protected $customer;
    protected $lines = [];
    protected $total = 0;
    protected $discount = 0;
    protected $outstanding = 0;

    public function __construct()
    {
        $this->number = "invID-" . Util::guidv4();
    }

    /**
     * Get the value of customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the value of customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Add a lineItem to Invoice
     */
    public function addLine(LineItem $lineItem)
    {
        array_push($this->lines, $lineItem);
        $this->total += $lineItem->getAmount();
        $this->calculateOutstanding();
        return $this;
    }

    /**
     * Add a lineItem to Invoice
     */
    public function bulkAddLines($lineItems)
    {
        array_map('self::addLine', $lineItems);
        return $this;
    }

    private function calculateOutstanding()
    {
        $this->outstanding = $this->total - ($this->total * ($this->discount / 100));
    }

    /**
     * Get the value of outstanding amount
     */
    public function getOutstanding()
    {
        return $this->outstanding;
    }

    /**
     * Get the value of lines
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Add a discount to the invoice
     */
    public function addDiscount($percent)
    {
        $this->discount = $percent;
        $this->calculateOutstanding();
        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Get the value of number
     */
    public function getNumber()
    {
        return $this->number;
    }

    public function getInvoiceContent()
    {

        $lines = "";
        foreach ($this->getLines() as $line) {
            $lines = $lines . $line;
        }

        return '============= INVOICE ' . $this->getNumber() . ' =============' . PHP_EOL .
            'CUSTOMER:' . PHP_EOL .
            $this->getCustomer() . PHP_EOL .
            PHP_EOL .
            'LINES:' . PHP_EOL .
            $lines . PHP_EOL .
            'Total           ==================             ' . $this->getTotal() . PHP_EOL .
            'Discount        ==================             ' .  $this->getTotal() - $this->getOutstanding()  . PHP_EOL .
            'Outstanding     ==================             ' . $this->getOutstanding() . PHP_EOL;
    }

    public function __toString()
    {
        return $this->getInvoiceContent();
    }

    public function printInvoice()
    {
        InvoiceService::writeInvoiceToFile($this);
    }
}
