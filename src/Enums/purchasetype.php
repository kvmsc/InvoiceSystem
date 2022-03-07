<?php

// Enum to maintain the possible transaction types in the system
enum PurchaseType: string
{
    case ANNUAL = "Annual Subscription";
    case MONTHLY = "Monthly Subscription";
}
