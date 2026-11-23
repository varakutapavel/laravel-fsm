<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceTransitionEnum;

final class ApprovedInvoiceStatus extends BaseInvoiceStatus
{
    public function awaitingPayment(): void
    {
        $this->transition(InvoiceTransitionEnum::AWAITING_PAYMENT);
    }
}
