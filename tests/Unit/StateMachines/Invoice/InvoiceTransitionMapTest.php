<?php

declare(strict_types=1);

namespace Tests\Unit\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;
use App\Enums\InvoiceTransitionEnum;
use App\StateMachines\Invoice\InvoiceTransitionMap;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class InvoiceTransitionMapTest extends TestCase
{
    #[DataProvider('allowedTransitions')]
    public function test_it_returns_next_state_for_allowed_transition(
        InvoiceStatesEnum $current,
        InvoiceTransitionEnum $transition,
        InvoiceStatesEnum $expected,
    ): void {
        $map = new InvoiceTransitionMap();

        self::assertSame(
            $expected,
            $map->next($current, $transition),
        );
    }

    public static function allowedTransitions(): iterable
    {
        yield 'draft to pending' => [
            InvoiceStatesEnum::DRAFT,
            InvoiceTransitionEnum::PENDING,
            InvoiceStatesEnum::PENDING,
        ];

        yield 'pending to approved' => [
            InvoiceStatesEnum::PENDING,
            InvoiceTransitionEnum::APPROVE,
            InvoiceStatesEnum::APPROVED,
        ];

        yield 'pending to rejected' => [
            InvoiceStatesEnum::PENDING,
            InvoiceTransitionEnum::REJECT,
            InvoiceStatesEnum::REJECTED,
        ];

        yield 'approved to awaiting payment' => [
            InvoiceStatesEnum::APPROVED,
            InvoiceTransitionEnum::AWAITING_PAYMENT,
            InvoiceStatesEnum::AWAITING_PAIMENT,
        ];

        yield 'awaiting payment to paid' => [
            InvoiceStatesEnum::AWAITING_PAIMENT,
            InvoiceTransitionEnum::PAID,
            InvoiceStatesEnum::PAID,
        ];

        yield 'awaiting payment to rejected' => [
            InvoiceStatesEnum::AWAITING_PAIMENT,
            InvoiceTransitionEnum::REJECT,
            InvoiceStatesEnum::REJECTED,
        ];

        yield 'rejected to draft' => [
            InvoiceStatesEnum::REJECTED,
            InvoiceTransitionEnum::DRAFT,
            InvoiceStatesEnum::DRAFT,
        ];

        yield 'rejected to cancelled' => [
            InvoiceStatesEnum::REJECTED,
            InvoiceTransitionEnum::CANCEL,
            InvoiceStatesEnum::CANCELLED,
        ];
    }

    #[DataProvider('invalidTransitions')]
    public function test_it_rejects_invalid_transition(
        InvoiceStatesEnum $current,
        InvoiceTransitionEnum $transition,
    ): void {
        $map = new InvoiceTransitionMap();

        $this->expectException(LogicException::class);

        $map->next($current, $transition);
    }

    public static function invalidTransitions(): iterable
    {
        $allowed = [
            InvoiceTransitionEnum::PENDING->name => [
                InvoiceStatesEnum::DRAFT,
            ],
            InvoiceTransitionEnum::APPROVE->name => [
                InvoiceStatesEnum::PENDING,
            ],
            InvoiceTransitionEnum::REJECT->name => [
                InvoiceStatesEnum::PENDING,
                InvoiceStatesEnum::AWAITING_PAIMENT,
            ],
            InvoiceTransitionEnum::AWAITING_PAYMENT->name => [
                InvoiceStatesEnum::APPROVED,
            ],
            InvoiceTransitionEnum::PAID->name => [
                InvoiceStatesEnum::AWAITING_PAIMENT,
            ],
            InvoiceTransitionEnum::CANCEL->name => [
                InvoiceStatesEnum::REJECTED,
            ],
            InvoiceTransitionEnum::DRAFT->name => [
                InvoiceStatesEnum::REJECTED,
            ],
        ];

        foreach (InvoiceTransitionEnum::cases() as $transition) {
            $validStates = $allowed[$transition->name];

            foreach (InvoiceStatesEnum::cases() as $state) {
                if (in_array($state, $validStates, true)) {
                    continue;
                }

                yield "{$state->name} with {$transition->value}" => [
                    $state,
                    $transition,
                ];
            }
        }
    }
}
