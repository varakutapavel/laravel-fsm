<?php
declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\StateMachines\Invoice\BaseInvoiceStatus;

final class DraftInvoiceStatus extends BaseInvoiceStatus
{
    public function pending(): void
    {
        $this->invoice->update(['status' => InvoiceStatesEnum::PENDING]);
    }
}
