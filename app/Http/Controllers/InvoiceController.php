<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceApproveRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;

final class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ){}

    public function sendToApprove(Invoice $invoice): InvoiceResource
    {
        $this->invoiceService->pending($invoice);
        return InvoiceResource::make($invoice);
    }

    public function approve(InvoiceApproveRequest $request, Invoice $invoice): InvoiceResource
    {
        $this->invoiceService->approve($invoice);
        return InvoiceResource::make($invoice);
    }

    public function cancel(Invoice $invoice): InvoiceResource
    {
        $this->invoiceService->cancel($invoice);
        return InvoiceResource::make($invoice->refresh());
    }

    public function reject(Invoice  $invoice): InvoiceResource
    {
        $invoice->takeState()->reject();
        return InvoiceResource::make($invoice->refresh());
    }

    public function show(Invoice $invoice): InvoiceResource
    {
        return InvoiceResource::make($invoice);
    }

    public function sendToCustomer(Invoice $invoice): InvoiceResource
    {
        $this->invoiceService->awaitingPayment($invoice);
        return InvoiceResource::make($invoice->refresh());
    }

    public function draft(Invoice $invoice): InvoiceResource
    {
        $this->invoiceService->draft($invoice);
        return InvoiceResource::make($invoice->refresh());
    }
}
