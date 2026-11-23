<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;
use App\Enums\InvoiceTransitionEnum;
use App\StateMachines\Invoice\BaseInvoiceStatus;

final class RejectedInvoiceStatus extends BaseInvoiceStatus
{
    public function draft(): void
    {
        $this->transition(InvoiceTransitionEnum::DRAFT);
    }

    public function cancel(): void
    {
        $this->invoice->update([
            'status' => InvoiceStatesEnum::CANCELLED,
        ]);
    }
}
