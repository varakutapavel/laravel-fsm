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

    public function approve()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function paid()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function reject()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function cancel()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function draft()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function awaitingPayment()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }

    public function pending()
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet.');
    }
}
