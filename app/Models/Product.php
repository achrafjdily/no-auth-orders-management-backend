<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Product extends Model
{
    use HasFactory, SoftDeletes , LaravelVueDatatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'order_id'
    ];

    protected $appends = [
        'total'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'quantity' => [
            'searchable' => true,
        ],
        'price' => [
            'searchable' => true,
        ],
        'order_id' => [
            'searchable' => true,
        ],
    ];

    protected $dataTableRelationships = [
        "belongsTo" => [
            "order" => [
                "model" => Order::class,
                "foreign_key" => "order_id",
                "columns" => [
                    'id' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'date' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'delivered_at' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'user_id' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                ],
            ],
        ],
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

}
