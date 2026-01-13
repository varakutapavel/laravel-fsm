<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Models\Invoice;

interface InvoiceStateInterface
{
    public function __construct(Invoice $invoice);
    public function pending();
    public function approve();
    public function awaitingPayment();
    public function paid();
    public function reject();
    public function cancel();
    public function draft();

}
