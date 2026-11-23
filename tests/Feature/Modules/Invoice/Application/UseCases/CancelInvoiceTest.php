<?php
declare(strict_types=1);

namespace Feature\Modules\Invoice\Application\UseCases;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use App\Modules\Invoice\Application\UseCases\CancelInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CancelInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_moves_rejected_invoice_to_cancel(): void
    {
        $user = User::factory()->create();
        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = fake()->bothify('### - ???');
        $invoice->status = InvoiceStatesEnum::REJECTED;
        $invoice->save();

        $useCase = app(CancelInvoice::class);
        $result = $useCase->execute($invoice);

        self::assertSame(InvoiceStatesEnum::CANCELLED, $result->status);
        self::assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => InvoiceStatesEnum::CANCELLED,
        ]);

    }

}
