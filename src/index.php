<?php

include('Models/customer.php');
include('Models/lineitem.php');
include('Utils/utils.php');
include('Enums/purchasetype.php');

// Driver code to generate two invoices which will be saved as text files,
// A third invoice when was tried to be generated when there were no unbilled transactions,
// will print "No line items to create invoice" in console.

// Creating a custoemr
$customer = new Customer('Tiny India Pvt Ltd', 'India');

// Creating transactions
$lineItem1 = new LineItem();
$lineItem1->setPurchaseType(PurchaseType::MONTHLY)->setItem("Product A")->setQuantity(10)->setPrice(9.99);

$lineItem2 = new LineItem();
$lineItem2->setPurchaseType(PurchaseType::ANNUAL)->setItem("Product B")->setQuantity(2)->setPrice(199.99);

// Associating transactions to the customer
$customer->addLineItem($lineItem1);
$customer->addLineItem($lineItem2);

// Generating the invoice
$invoice = $customer->getInvoice(0);
$invoice->printInvoice();


// Creating new transactions
$lineItem3 = new LineItem();
$lineItem3->setPurchaseType(PurchaseType::MONTHLY)->setItem("Product C")->setQuantity(5)->setPrice(7.99);

$lineItem4 = new LineItem();
$lineItem4->setPurchaseType(PurchaseType::ANNUAL)->setItem("Product D")->setQuantity(9)->setPrice(19.99);

// Associating transactions to the customer
$customer->addLineItem($lineItem3);
$customer->addLineItem($lineItem4);

// Generating the invoice
$invoice2 = $customer->getInvoice(30);
$invoice2->printInvoice();


// prints "No line items to create invoice" as there were no new transactions
$invoice3 = $customer->getInvoice(10);
