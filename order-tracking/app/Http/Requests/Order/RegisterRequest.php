<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Registro de pedido
 *
 * @bodyParam order_id string required O código identificador único do pedido. Example: 0097555536
 * @bodyParam channel string required O canal de venda do pedido. Example: RVD
 * @bodyParam origin object required O endereço de origem do pedido. Example: {"zipcode": "50950-170", "title": "NAGEM REC"}
 * @bodyParam origin.zipcode string required O CEP do endereço de origem do pedido. Example: 50950-170
 * @bodyParam origin.title string required O título do endereço de origem do pedido. Example: NAGEM REC
 * @bodyParam destination object required O endereço de destino do pedido. Example: {"zipcode": "50950-170", "city": "João Pessoa", "state": "PB"}
 * @bodyParam destination.zipcode string required O CEP do endereço de destino do pedido. Example: 50950-170
 * @bodyParam destination.city string required A cidade do endereço de destino do pedido. Example: João Pessoa
 * @bodyParam destination.state string required O estado do endereço de destino do pedido. Example: PB
 * @bodyParam estimated_delivery string A data estimada de entrega do pedido. Example: 2024-10-04
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
            'channel' => ['required', 'string'],
            'origin' => ['required', 'array'],
            'origin.zipcode' => ['required', 'string'],
            'origin.title' => ['required', 'string'],
            'destination' => ['required', 'array'],
            'destination.zipcode' => ['required', 'string'],
            'destination.city' => ['required', 'string'],
            'destination.state' => ['required', 'string'],
            'estimated_delivery' => ['string'],
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
