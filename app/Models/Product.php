<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * returns the full url of the image
     *
     * @param String $value
     * @return string
     */
    function getImageAttribute($value) : string
    {
        return asset('app/'. $value);
    }


    /**
     * returns the relationship with the category model
     *
     * @return void
     */
    function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * returns the relationship with the income_products model
     *
     * @return void
     */
    function income_products() {
        return $this->hasMany(Income_Products::class);
    }

    /**
     * returns the relationship with the sale_client_product model
     *
     * @return void
     */
    function sale_client_product() {
        return $this->hasMany(Sale_Client_Product::class);
    }



}
