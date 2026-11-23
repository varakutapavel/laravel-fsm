<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceTransitionEnum: string
{
    case PENDING = 'pending';
    case APPROVE = 'approve';
    case REJECT = 'reject';
    case AWAITING_PAYMENT = 'awaitingPayment';
    case PAID = 'paid';
    case CANCEL = 'cancel';
    case DRAFT = 'draft';
}
