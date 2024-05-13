<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * returns the relationship with the user model
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * returns the relationship with the supplier model
     *
     * @return void
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * returns the relationship with the income_products model
     *
     * @return void
     */
    public function income_products()
    {
        return $this->hasMany(Income_Products::class);
    }
}
