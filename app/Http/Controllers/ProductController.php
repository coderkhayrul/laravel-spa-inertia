<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkUpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = auth()->user()
            ->products()
            ->with('category')
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            })
            ->when(!request()->query('sort_by'), function ($query) {
                $query->latest();
            })
            ->when(in_array(request()->query('sort_by'), [
                'name',
                'price',
                'weight'
            ]), function ($query) {
                $sortBy = request()->query('sort_by');
                $field = ltrim($sortBy, '-');
                $direction = substr($sortBy, 0, 1) === '-' ? 'desc' : 'asc';
                $query->orderBy($field, $direction);
            })
            ->paginate(10)
            ->withQueryString();

        return inertia('Products/Index', [
            'products' => ProductResource::collection($products),
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
            'query' => (object) request()->query()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Products/Create', [
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $request->user()->products()->create($request->all());
        return redirect()
            ->route('products.index')
            ->with('message', 'Product created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return inertia('Products/Show', [
            'product' => ProductResource::make($product),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return inertia('Products/Edit', [
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
            'product' => ProductResource::make($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()
            ->route('products.index')
            ->with('message', 'Product updated.');
    }
    public function bulkUpdate(BulkUpdateProductRequest $request)
    {
        // dd($request->all());
        Product::whereIn('id', $request->product_ids)
            ->update([
                'category_id' => $request->category_id,
            ]);
        return redirect()
            ->route('products.index')
            ->with('message', 'Bulk Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()
            ->route('products.index')
            ->with('message', 'Product deleted.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDestroy(string $ids)
    {
        $ids = explode(',', $ids);
        Product::destroy($ids);
        return redirect()
            ->route('products.index')
            ->with('message', 'Selected Product deleted.');
    }
}
