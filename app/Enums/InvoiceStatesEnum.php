<?php
declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatesEnum: int
{
    case DRAFT = 0;
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case CANCELLED = 4;
    case AWAITING_PAIMENT = 5;
    case PAID = 6;

    public function getName(): string
    {
        return match ($this) {
            self::DRAFT => __('messages.invoices.states.draft'),
            self::PENDING => __('messages.invoices.states.pending'),
            self::APPROVED => __('messages.invoices.states.approved'),
            self::REJECTED => __('messages.invoices.states.rejected'),
            self::CANCELLED => __('messages.invoices.states.cancelled'),
            self::AWAITING_PAIMENT => __('messages.invoices.states.awaiting_paiment'),
            self::PAID => __('messages.invoices.states.paid'),
        };
    }

}
