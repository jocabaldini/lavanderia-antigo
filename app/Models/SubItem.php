<?php

namespace Lavanderia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubItem extends Model
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
    protected $table = 'sub_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'desc'
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
     * Define an inverse one-to-one or many relationship.
     * Many SubItem belongs to a ServiceItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceItem()
    {
        return $this->belongsTo(ServiceItem::class);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */
}
