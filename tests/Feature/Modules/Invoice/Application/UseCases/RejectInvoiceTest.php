<?php
declare(strict_types=1);

namespace Tests\Feature\Modules\Invoice\Application\UseCases;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use App\Modules\Invoice\Application\UseCases\RejectInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RejectInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rejects_pending_invoice(): void
    {
        $this->assertInvoiceCanBeRejected(
            InvoiceStatesEnum::PENDING,
        );
    }

    public function test_it_rejects_invoice_awaiting_payment(): void
    {
        $this->assertInvoiceCanBeRejected(
            InvoiceStatesEnum::AWAITING_PAIMENT,
        );
    }

    private function assertInvoiceCanBeRejected(
        InvoiceStatesEnum $initialStatus,
    ): void {
        $user = User::factory()->create();

        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = fake()->bothify('INVOICE-???-#####');
        $invoice->status = $initialStatus;
        $invoice->save();

        $useCase = app(RejectInvoice::class);

        $result = $useCase->execute($invoice);

        self::assertSame(
            InvoiceStatesEnum::REJECTED,
            $result->status,
        );

        self::assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => InvoiceStatesEnum::REJECTED->value,
        ]);
    }
}
