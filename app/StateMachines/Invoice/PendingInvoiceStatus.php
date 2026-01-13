<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;

final class PendingInvoiceStatus extends BaseInvoiceStatus
{
    public function approve(): void
    {
        $this->invoice->update([
            'status' => InvoiceStatesEnum::APPROVED,
        ]);
    }

    public function reject(): void
    {
        $this->invoice->update([
            'status' => InvoiceStatesEnum::REJECTED,
        ]);
    }
}
