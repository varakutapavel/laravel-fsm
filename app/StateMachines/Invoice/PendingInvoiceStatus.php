<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceTransitionEnum;

final class PendingInvoiceStatus extends BaseInvoiceStatus
{
    public function approve(): void
    {
        $this->transition(InvoiceTransitionEnum::APPROVE);
    }

    public function reject(): void
    {
        $this->transition(InvoiceTransitionEnum::REJECT);
    }
}
