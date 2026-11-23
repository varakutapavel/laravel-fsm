<?php
declare(strict_types=1);

namespace Feature\Modules\Invoice\Application\UseCases;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use App\Modules\Invoice\Application\UseCases\ApproveInvoice;
use App\Modules\Invoice\Application\UseCases\SubmitInvoiceForApproval;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ApproveInvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_approves_penfing_invoice()
    {
        $user = User::factory()->create();

        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = fake()->bothify("INVOICE-???-#####");
        $invoice->status = InvoiceStatesEnum::PENDING;
        $invoice->save();

        $useCase = app(ApproveInvoice::class);
        $result = $useCase->execute($invoice);

        self::assertSame(
            InvoiceStatesEnum::APPROVED,
            $result->status,
        );

        self::assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => InvoiceStatesEnum::APPROVED->value,
        ]);
    }

}
