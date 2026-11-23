<?php
declare(strict_types=1);

namespace Feature\Modules\Invoice\Application\UseCases;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use App\Modules\Invoice\Application\UseCases\PayInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PayInvoiceTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_moves_awaiting_payment_invoice_to_paid(): void
    {
        $user = User::factory()->create();
        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = fake()->bothify('## ??');
        $invoice->status = InvoiceStatesEnum::AWAITING_PAIMENT;
        $invoice->save();

        $useCase = app(PayInvoice::class);
        $result = $useCase->execute($invoice);

        self::assertSame(
            InvoiceStatesEnum::PAID,
            $result->status,
        );

        self::assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => InvoiceStatesEnum::PAID,
        ]);
    }
}
