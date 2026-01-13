<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;
use App\StateMachines\Invoice\BaseInvoiceStatus;

final class AwaitingPaymentInvoiceStatus extends BaseInvoiceStatus
{
    public function paid(): void
    {
        $this->invoice->update(['status' => InvoiceStatesEnum::PAID]);
    }

    public function reject(): void
    {
        $this->invoice->update(['status' => InvoiceStatesEnum::REJECTED]);
    }

}
