<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Invoice;
use App\Modules\Invoice\Application\UseCases\SubmitInvoiceForApproval;

final class InvoiceService
{

    public function __construct(
        private readonly SubmitInvoiceForApproval $submitInvoiceForApproval,
    ) {
    }
    public function pending(Invoice $invoice): Invoice
    {
        return $this->submitInvoiceForApproval->execute($invoice);
    }

    public function approve(Invoice $invoice): Invoice
    {
        $invoice->takeState()->approve();

        // В реальном проекте тут диспатчатся джобы в RabbitMQ для интеграции с 1С. Она работает в фоне и
        // и возвращает только task_uuid, по которому в дальнейшем мы забираем результат обработки.
        //Журналирование на каждой смене статуса

        return $invoice->refresh();

    }

    public function awaitingPayment(Invoice $invoice): Invoice
    {
        $invoice->takeState()->awaitingPayment();
        //Журналирование на каждой смене статуса
        return $invoice->refresh();
    }

    public function paid(Invoice $invoice): Invoice
    {
        $invoice->takeState()->paid();
        //Журналирование на каждой смене статуса
        return $invoice->refresh();
    }

    public function cancel(Invoice $invoice): Invoice
    {
        $invoice->takeState()->cancel();
        return $invoice->refresh();
    }

    public function draft(Invoice $invoice): Invoice
    {
        $invoice->takeState()->draft();
        //Фоновое уведомление автора накладной
        return $invoice->refresh();
    }

    public function reject(Invoice $invoice): Invoice
    {
        $invoice->takeState()->reject();
        //Фоновое уведомление автора накладной
        return $invoice->refresh();
    }

}
