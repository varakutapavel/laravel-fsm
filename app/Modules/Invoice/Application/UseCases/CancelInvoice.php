<?php
declare(strict_types=1);

namespace App\Modules\Invoice\Application\UseCases;

use App\Models\Invoice;

final class CancelInvoice
{
    public function execute(Invoice $invoice):Invoice
    {
        $invoice->takeState()->cancel();
        return $invoice->refresh();
    }
}
