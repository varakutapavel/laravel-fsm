<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Models\Invoice;

interface InvoiceStateInterface
{
    public function __construct(Invoice $invoice);
    public function pending(): void;
    public function approve(): void;
    public function awaitingPayment(): void;
    public function paid(): void;
    public function reject(): void;
    public function cancel(): void;
    public function draft(): void;

}
