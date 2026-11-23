<?php

namespace Tests\Unit\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use App\Models\User;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Str;

class InvoiceStateTransitionTest extends TestCase
{
    use RefreshDatabase;

    public static function allowedTransitions(): array
    {
        return [
            'draft to pending' => [
                InvoiceStatesEnum::DRAFT,
                'pending',
                InvoiceStatesEnum::PENDING,
            ],
            'pending to approved' => [
                InvoiceStatesEnum::PENDING,
                'approve',
                InvoiceStatesEnum::APPROVED,
            ],
            'pending to rejected' => [
                InvoiceStatesEnum::PENDING,
                'reject',
                InvoiceStatesEnum::REJECTED,
            ],
            'approved to awaiting payment' => [
                InvoiceStatesEnum::APPROVED,
                'awaitingPayment',
                InvoiceStatesEnum::AWAITING_PAIMENT,
            ],
            'rejected to draft' => [
                InvoiceStatesEnum::REJECTED,
                'draft',
                InvoiceStatesEnum::DRAFT,
            ],
            'rejected to cancelled' => [
                InvoiceStatesEnum::REJECTED,
                'cancel',
                InvoiceStatesEnum::CANCELLED,
            ],
            'awaiting payment to paid' => [
                InvoiceStatesEnum::AWAITING_PAIMENT,
                'paid',
                InvoiceStatesEnum::PAID,
            ],
            'awaiting payment to rejected' => [
                InvoiceStatesEnum::AWAITING_PAIMENT,
                'reject',
                InvoiceStatesEnum::REJECTED,
            ],
        ];
    }

    public static function InvalidTransitions(): array
    {
        $allowed = [];
        foreach (self::allowedTransitions() as [$from, $method]) {
            $allowed[$from->value][] = $method;
        }

        $methods = [
            'pending',
            'approve',
            'awaitingPayment',
            'paid',
            'reject',
            'cancel',
            'draft',
        ];

        $invalid = [];

        foreach (InvoiceStatesEnum::cases() as $state) {
            foreach ($methods as $method) {
                if (in_array($method, $allowed[$state->value] ?? [], true)) {
                    continue;
                }

                $invalid["{$state->name} -> {$method}"] = [
                    $state,
                    $method,
                ];
            }
        }

        return $invalid;
    }

    #[DataProvider('allowedTransitions')]
    public function test_it_performs_allowed_transition(
        InvoiceStatesEnum $initialState,
        string $method,
        InvoiceStatesEnum $expectedState,
    ): void {
        $invoice = $this->createInvoice($initialState);

        $invoice->takeState()->{$method}();

        self::assertSame(
            $expectedState->value,
            DB::table('invoices')
                ->where('id', $invoice->id)
                ->value('status'),
        );

        $reloadedInvoice = Invoice::query()
            ->where('id', $invoice->id)
            ->firstOrFail();

        self::assertSame($expectedState, $reloadedInvoice->status);
    }

    #[DataProvider('invalidTransitions')]
    public function test_it_rejects_invalid_transition(
        InvoiceStatesEnum $initialState,
        string $method,
    ): void {
        $invoice = $this->createInvoice($initialState);

        try {
            $invoice->takeState()->{$method}();

            self::fail(
                "Expected LogicException for {$initialState->name} -> {$method}"
            );
        } catch (\LogicException) {
            // Expected behavior.
        }

        $reloadedInvoice = Invoice::query()
            ->where('id', $invoice->id)
            ->firstOrFail();

        self::assertSame($initialState, $reloadedInvoice->status);

        self::assertSame(
            $initialState->value,
            DB::table('invoices')
                ->where('id', $invoice->id)
                ->value('status'),
        );
    }

    private function createInvoice(
        InvoiceStatesEnum $status,
    ): Invoice {
        $user = User::factory()->create();

        $id = (string) Str::uuid();
        $now = now();

        DB::table('invoices')->insert([
            'id' => $id,
            'user_id' => $user->id,
            'invoice_number' => 'TEST-' . Str::uuid(),
            'status' => $status->value,
            'amount' => 10000,
            'one_c_task_uuid' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return Invoice::query()
            ->where('id', $id)
            ->firstOrFail();
    }

}
