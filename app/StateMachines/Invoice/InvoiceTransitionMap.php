<?php

declare(strict_types=1);

namespace App\StateMachines\Invoice;

use App\Enums\InvoiceStatesEnum;
use App\Enums\InvoiceTransitionEnum;
use LogicException;

final class InvoiceTransitionMap
{
    public function next(
        InvoiceStatesEnum $current,
        InvoiceTransitionEnum $transition,
    ): InvoiceStatesEnum {
        $next = match ($transition) {
            InvoiceTransitionEnum::PENDING => match ($current) {
                InvoiceStatesEnum::DRAFT => InvoiceStatesEnum::PENDING,
                default => null,
            },
            InvoiceTransitionEnum::APPROVE => match ($current) {
                InvoiceStatesEnum::PENDING => InvoiceStatesEnum::APPROVED,
                default => null,
            },
            InvoiceTransitionEnum::REJECT => match ($current) {
                InvoiceStatesEnum::PENDING,
                InvoiceStatesEnum::AWAITING_PAIMENT => InvoiceStatesEnum::REJECTED,
                default => null,
            },
            InvoiceTransitionEnum::AWAITING_PAYMENT => match ($current) {
                InvoiceStatesEnum::APPROVED => InvoiceStatesEnum::AWAITING_PAIMENT,
                default => null,
            },
            InvoiceTransitionEnum::PAID => match ($current) {
                InvoiceStatesEnum::AWAITING_PAIMENT => InvoiceStatesEnum::PAID,
                default => null,
            },
            InvoiceTransitionEnum::CANCEL => match ($current) {
                InvoiceStatesEnum::REJECTED => InvoiceStatesEnum::CANCELLED,
                default => null,
            },
            InvoiceTransitionEnum::DRAFT => match ($current) {
                InvoiceStatesEnum::REJECTED => InvoiceStatesEnum::DRAFT,
                default => null,
            },
        };

        if ($next === null) {
            throw new LogicException(sprintf(
                'Transition "%s" is not allowed from state "%s".',
                $transition->value,
                $current->name,
            ));
        }

        return $next;
    }
}
