<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceTransitionEnum;

final class DraftInvoiceStatus extends BaseInvoiceStatus
{
    public function pending(): void
    {
        $this->transition(InvoiceTransitionEnum::PENDING);
    }
}
