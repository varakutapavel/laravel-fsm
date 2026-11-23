<?php
declare(strict_types=1);

namespace App\Modules\Invoice\Application\UseCases;

use App\Models\Invoice;

final class MoveInvoiceToAwaitingPayment
{
    public function execute(Invoice $invoice): Invoice
    {
        $invoice->takeState()->awaitingPayment();
        return $invoice->refresh();
    }

}
