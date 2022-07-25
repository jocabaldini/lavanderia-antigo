<?php

namespace Lavanderia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Model attributes
    |--------------------------------------------------------------------------
    */
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    /**
     * Define a one-to-many relationship.
     * One Item has many ItemValue (but only ONE should not is soft deleted)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(ItemValue::class);
    }

    /**
     * Define a one-to-many relationship.
     * One Item has many ServiceItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceItems()
    {
        return $this->hasMany(ServiceItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */
    public function getCurrentValue()
    {
        return $this->values()->first();
    }
}
