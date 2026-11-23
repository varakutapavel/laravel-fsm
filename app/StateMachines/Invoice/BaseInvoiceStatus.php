<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Models\Invoice;

class BaseInvoiceStatus implements InvoiceStateInterface
{
    /**
     * @param Invoice $invoice
     */
    public function __construct(
        public Invoice $invoice
    ){}

    public function approve(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function paid(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function reject(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function cancel(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function draft(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function awaitingPayment(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function pending(): void
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }
}
