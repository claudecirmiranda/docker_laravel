<?php

namespace App\Http\Requests\Order\Tracking;

use App\Models\Order;
use App\Models\Tracking;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * Registro de rastreamento de pedido
 *
 * @bodyParam order_id string required O código identificador único do pedido. Example: 0097555536
 * @bodyParam tracking object[] required Lista de rastreamentos do pedido (Não enviar repetido). Example: [{"status": "recebido", "message": "Pedido recebido no CD", "observation": "Observação do rastreamento", "created_at": "2024-10-01 14:00:00"}]
 * @bodyParam tracking[].step string required O step do rastreamento. Example: recebido
 * @bodyParam tracking[].status string required O status do rastreamento. Example: Faturado
 * @bodyParam tracking[].message string required A mensagem do rastreamento. Example: Pedido recebido no CD
 * @bodyParam tracking[].observation string A observação do rastreamento. Example: Observação do rastreamento
 * @bodyParam tracking[].created_at string required A data e hora do rastreamento. Example: 2024-10-01 14:00:00
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'string'],
            'tracking' => ['required', 'array', 'min:1'],
            'tracking.*.step' => ['required', Rule::in(array_keys(Order::STEP))],
            'tracking.*.status' => ['required', 'string'],
            'tracking.*.message' => ['required', 'string'],
            'tracking.*.observation' => ['nullable', 'string'],
            'tracking.*.created_at' => ['required', 'date'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
