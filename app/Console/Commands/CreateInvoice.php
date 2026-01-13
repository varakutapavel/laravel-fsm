<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatesEnum;
use App\Models\Invoice;
use Illuminate\Console\Command;

class CreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-invoice {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает рандомную накладную указанному как параметр юзеру';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = fake()->uuid();
        $user_id = $this->argument('user_id');
        $no = fake()->bothify("INVOICE-???-#####");
        $one_c_task_uuid = fake()->uuid();

        $invoice = Invoice::create([
            'id' => $id,
            'user_id' => $user_id,
            'invoice_number' => $no,
            'one_c_task_uuid' => $one_c_task_uuid,
            'status' => InvoiceStatesEnum::DRAFT,
            'created_at' => \Illuminate\Support\now(),
            'updated_at' => \Illuminate\Support\now()
        ]);
    }
}
