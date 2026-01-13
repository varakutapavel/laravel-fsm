<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;

final class ApprovedInvoiceStatus extends BaseInvoiceStatus
{
    public function awaitingPayment(): void
    {
        $this->invoice->update([
            'status' => InvoiceStatesEnum::AWAITING_PAIMENT,
        ]);
    }
}
