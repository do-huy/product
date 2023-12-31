<?php

namespace Modules\Product\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\app\Models\Product;

class ClientProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with([
                'productItems',
                'productItems.variantOptions',
                'productItems.variantOptions.media',
            ])
            ->first();

        if (!$product) {
            throw new ModelNotFoundException();
        }

        $variantQuery = request('variantQuery', []);
        if (!is_array($variantQuery)) {
            $variantQuery = [];
        }

        $productItemSelected = !empty($variantQuery)
            ? $product->getProductItemSelected($variantQuery)
            : null;
        return view('product::client.product.detail',compact(
            'product',
            'variantQuery',
            'productItemSelected',
        ));
    }


}
