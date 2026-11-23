<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Invoice\Application\UseCases;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use App\Modules\Invoice\Application\UseCases\SubmitInvoiceForApproval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SubmitInvoiceForApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_submits_draft_invoice_for_approval(): void
    {
        $user = User::factory()->create();

        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = fake()->bothify("INVOICE-???-#####");
        $invoice->status = InvoiceStatesEnum::DRAFT;
        $invoice->save();

        $useCase = app(SubmitInvoiceForApproval::class);

        $result = $useCase->execute($invoice);

        self::assertSame(
            InvoiceStatesEnum::PENDING,
            $result->status,
        );

        self::assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => InvoiceStatesEnum::PENDING->value,
        ]);
    }
}
