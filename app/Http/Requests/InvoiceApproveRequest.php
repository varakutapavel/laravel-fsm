<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

final class InvoiceApproveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        $invoice = $this->route('invoice');
        return $request->user()->can('can-approve-invoice', $invoice);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [

        ];
    }
}
