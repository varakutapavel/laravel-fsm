<?php
declare(strict_types=1);

namespace Feature\Modules\Invoice\Application\UseCases;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use App\Modules\Invoice\Application\UseCases\MoveInvoiceToAwaitingPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class MoveInvoiceToAwaitingPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_moves_approved_invoice_to_awaiting_payment(): void
    {
        $user = User::factory()->create();

        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = fake()->bothify('INVOICE #???');
        $invoice->status = InvoiceStatesEnum::APPROVED;
        $invoice->save();

        $useCase = app(MoveInvoiceToAwaitingPayment::class);
        $result = $useCase->execute($invoice);

        self::assertSame(
            $result->status,
            InvoiceStatesEnum::AWAITING_PAIMENT
        );

        self::assertDatabaseHas('invoices', [
                'id' => $invoice->id,
                'status' => InvoiceStatesEnum::AWAITING_PAIMENT->value,
            ]
        );
    }
}
