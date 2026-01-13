<?php

use App\Models\Invoice;

return [
    'invoices.states.draft' => 'Черновик',
    'invoices.states.pending' => "Накладная на рассмотрении",
    'invoices.states.approved' => "Накладная утверждена управляющим",
    'invoices.states.rejected' => "Накладная отклонена управляющим",
    'invoices.states.cancelled' => "Накладная отменена управляющим",
    'invoices.states.awaiting_paiment' => "Накладная ожидает оплаты",
    'nvoices.states.paid' => "Накладная оплачена",
];
