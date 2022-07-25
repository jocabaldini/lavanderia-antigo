<?php

namespace Lavanderia\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Model attributes
    |--------------------------------------------------------------------------
    */
    const IS_NOT_READY = 0;
    const IS_READY = 1;

    const IS_NOT_DELIVERED = false;
    const IS_DELIVERED = true;

    const STATUS_NOT_READY = 1;
    const STATUS_READY = 2;
    const STATUS_NOT_DELIVERED = 3;
    const STATUS_DELIVERED = 4;
    const STATUS_LATE = 5;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_ready',
        'delivery_at',
        'delivered_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'delivery_at',
        'delivered_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_ready' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_late',
        'value',
        'total_weight'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    /**
     * Define an inverse one-to-one or many relationship.
     * Many Service belongs to a Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Define a one-to-many relationship.
     * One Service has many ServiceItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getIsLateAttribute()
    {
        return Carbon::now()->startOfDay()->gt($this->delivery_at);
    }
    
    public function getValueAttribute()
    {
        $value = $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        return $value;
    }

    public function getTotalWeightAttribute()
    {
        $value = $this->items->sum(function ($item) {
            return $item->quantity;
        });
        return $value; 
    }

    /*
    |--------------------------------------------------------------------------
    | Local Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeLate($query)
    {
        $today = Carbon::now()->startOfDay();
        return $query->ofDelivered(self::IS_NOT_DELIVERED)
                    ->where('delivery_at', '<', $today);
    }

    public function scopeOfReady($query, $isReady)
    {
        return $query->where('is_ready', $isReady);
    }

    public function scopeOfDelivered($query, $isDelivered)
    {
        return $isDelivered ? $query->whereNotNull('delivered_at') : $query->whereNull('delivered_at');
    }

    public function scopeOfDelivery($query, $date)
    {
        return $query->where('delivery_at', $date);
    }

    public function scopeOfDeliveryStart($query, $date)
    {
        return $query->where('delivery_at', '>=', $date);
    }

    public function scopeOfDeliveryEnd($query, $date)
    {
        return $query->where('delivery_at', '<=', $date);
    }

    public function scopeOfType($query, $type)
    {
        switch ($type) {
            case self::STATUS_NOT_READY:
                $query->ofReady(self::IS_NOT_READY)
                    ->ofDelivered(self::IS_NOT_DELIVERED);
                break;

            case self::STATUS_READY:
                $query->ofReady(self::IS_READY)
                    ->ofDelivered(self::IS_NOT_DELIVERED);
                break;

            case self::STATUS_NOT_DELIVERED:
                $query->ofDelivered(self::IS_NOT_DELIVERED);
                break;

            case self::STATUS_DELIVERED:
                $query->ofDelivered(self::IS_DELIVERED);
                break;

            case self::STATUS_LATE:
                $query->late();

            default:
                break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */
}
