## Invoice System

While there can be multiple correct ways to refactor, when compared to the original file,
the Invoice, it was a single large class and could be divided into smaller models like,

- Invoice - Where the invoice details are stored.
- Customer - Any Customer related data will be part of this Model
- LineItem - Underlying details of each transaction will be in this Model

### How to run

```
git clone https://github.com/kvmsc/InvoiceSystem.git
cd InvoiceSystem/src
php index.php
```

### Possible additions:

- Currently it is only adding unbilled transactions in the latest invoice, but more functionality can be built around the date of subscription, and the date of invoice generation.
- There might be a better way to structure the project, so can look into structuring it a better way.
- Currently the driver logic of creating a customer, adding a transaction and generating the invoice is hardcoded, can be modified into a command line application that runs continuously and acts based on user input.
- Documentation can be improved
