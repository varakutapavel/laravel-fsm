<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\UseCases;

use App\Models\Invoice;

final class SubmitInvoiceForApproval
{
    public function execute(Invoice $invoice): Invoice
    {
        $invoice->takeState()->pending();

        return $invoice->refresh();
    }
}
