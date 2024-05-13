<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * returns the relationship with the income model
     *
     * @return void
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
