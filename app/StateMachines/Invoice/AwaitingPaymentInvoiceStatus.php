<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceTransitionEnum;

final class AwaitingPaymentInvoiceStatus extends BaseInvoiceStatus
{
    public function paid(): void
    {
        $this->transition(InvoiceTransitionEnum::PAID);
    }

    public function reject(): void
    {
        $this->transition(InvoiceTransitionEnum::REJECT);
    }

}
