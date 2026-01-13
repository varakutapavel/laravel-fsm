<?php

namespace App\Models;

use App\Enums\InvoiceStatesEnum;
use App\StateMachines\Invoice\ApprovedInvoiceStatus;
use App\StateMachines\Invoice\AwaitingPaymentInvoiceStatus;
use App\StateMachines\Invoice\BaseInvoiceStatus;
use App\StateMachines\Invoice\InvoiceStateInterface;
use App\StateMachines\Invoice\PendingInvoiceStatus;
use App\StateMachines\Invoice\RejectedInvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\StateMachines\Invoice\DraftInvoiceStatus;

/**
 * @mixin IdeHelperInvoice
 */
class Invoice extends Model
{
    protected $fillable = [
        'status',
        'user_id',
        'invoice_number',
        'id'
    ];
    protected $casts = [
        'status' => InvoiceStatesEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function takeState(): InvoiceStateInterface
    {
        $s = match($this->status) {
            InvoiceStatesEnum::DRAFT => new DraftInvoiceStatus($this),
            InvoiceStatesEnum::PENDING => new PendingInvoiceStatus($this),
            InvoiceStatesEnum::APPROVED => new ApprovedInvoiceStatus($this),
            InvoiceStatesEnum::REJECTED => new RejectedInvoiceStatus($this),
            InvoiceStatesEnum::AWAITING_PAIMENT => new AwaitingPaymentInvoiceStatus($this),
            InvoiceStatesEnum::CANCELLED => new BaseInvoiceStatus($this),
            InvoiceStatesEnum::PAID => new BaseInvoiceStatus($this),
            default => throw new \InvalidArgumentException('Invalid Status'),
        };
        return $s;
    }
}
