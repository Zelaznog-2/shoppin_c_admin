<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income_Products extends Model
{
    use HasFactory;

    /**
     * returns the relationship with the income model
     *
     * @return void
     */
    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    /**
     * returns the relationship with the product model
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
