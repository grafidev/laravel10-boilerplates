<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use ApiResponse;

    public function __construct(private ProductRepository $productRepository)
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $products = $this->productRepository
            ->query()
            ->enabledFor($request->user())
            ->get();

        return $this->sendResponse('List of products', ProductResource::collection($products));
    }
}
