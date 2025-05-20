<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "orders";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'channel', 'origin_zipcode', 'origin_title', 'destination_zipcode',
        'destination_city', 'destination_state', 'estimated_delivery', 'raw'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'raw'
    ];

    protected $casts = [
        'estimated_delivery' => 'datetime'
    ];

    public const STEP = [
        'recebido' => [
            'title' => 'Recebido',
            'icon' => 'check-circle',
            'pos' => 1
        ],
        'despachado' => [
            'title' => 'Despachado',
            'icon' => 'send',
            'pos' => 2
        ],
        'em-transito' => [
            'title' => 'Em trânsito',
            'icon' => 'truck',
            'pos' => 3
        ],
        'saiu-para-entrega' => [
            'title' => 'Saiu para Entrega',
            'icon' => 'map-pin',
            'pos' => 4
        ],
        'entregue' => [
            'title' => 'Entregue',
            'icon' => 'home',
            'pos' => 5
        ],
    ];

    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'order_id', 'order_id')->orderBy('created_at', 'desc');
    }
}
