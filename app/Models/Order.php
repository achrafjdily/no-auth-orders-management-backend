<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Order extends Model
{
    use HasFactory, SoftDeletes, LaravelVueDatatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'delivered_at'
    ];

    protected $appends = [
        'total'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ],
        'delivered_at' => [
            'searchable' => true,
        ],
    ];

    protected $dataTableRelationships = [
        "belongsTo" => [
            "client" => [
                "model" => User::class,
                "foreign_key" => "user_id",
                "columns" => [
                    'id' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'name' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'email' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'phone' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    'address' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                ],
            ],
        ],
        "hasMany" => [
            "products" => [
                "model" => Product::class,
                "foreign_key" => "order_id",
                "columns" => [
                    "id" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                    "name" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                    'quantity' => [
                        'searchable' => true,
                        "orderable" => true,
                    ],
                    "price" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                    "order_id" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                ],
            ],
        ],
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'order_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTotalAttribute()
    {
        return $this->products->sum('total');
    }

    public function scopeAwaiting($query)
    {
        return $query->where('delivered_at',null);
    }

    public function scopeDelivered($query)
    {
        return $query->where('delivered_at','!=',null);
    }


}
