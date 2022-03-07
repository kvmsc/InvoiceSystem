<?php

class LineItem
{
    private string $id;
    private int $quantity = 0;
    private float $price = 0;
    private string $item = "";
    private PurchaseType $purchaseType;
    private float $amount = 0;
    private string $customerId;
    private bool $isBilled = false;

    public function __construct()
    {
        $this->id = "lID-" . Util::guidv4();
    }

    public function __toString()
    {
        return $this->purchaseType->value . " of " . $this->item . " ============= " . $this->quantity . "x" . $this->price . " = " . $this->amount . PHP_EOL;
    }


    /**
     * Get the line item ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->amount = $this->price * $this->quantity;
        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->amount = $this->price * $this->quantity;
        return $this;
    }

    /**
     * Get the value of item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set the value of item
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * Get the value of purchaseType
     */
    public function getPurchaseType()
    {
        return $this->purchaseType;
    }

    /**
     * Set the value of purchaseType
     */
    public function setPurchaseType($purchaseType)
    {
        $this->purchaseType = $purchaseType;
        return $this;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId
     *
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * Get the value of isBilled
     */
    public function getIsBilled()
    {
        return $this->isBilled;
    }

    /**
     * Set the value of isBilled
     *
     */
    public function setIsBilled($isBilled)
    {
        $this->isBilled = $isBilled;
        return $this;
    }
}
