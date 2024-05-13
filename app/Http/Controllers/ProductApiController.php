<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ReportServices;
use App\Services\ResponseServices;
use Illuminate\Http\Request;


class ProductApiController extends Controller
{
    function getProducts() {
        try {
            $products = Product::where('stock', '>', 0)
                ->select('id', 'sku', 'name', 'price', 'image', 'category_id')
                ->paginate(9);

            return ResponseServices::responseSuccess('list', $products);
        } catch (\Throwable $th) {
            ReportServices::reportError($th, class_basename($this), __FUNCTION__);
            return ResponseServices::responseError();
        }
    }
}
