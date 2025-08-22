<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            // dd($request->all()); 
            // Upload thumbnail
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
            }
            $galleryPaths = [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $path = $file->store('products/gallery', 'public'); // lưu vào storage/app/public/products
                    $galleryPaths[] = $path;
                }
            }
            // Upload gallery
            $data['gallery'] = json_encode($galleryPaths);

            // Slug
            $data['slug'] = Str::slug($data['name']);
            // dd($data['gallery']);
            $product = Product::create($data);
            if ($request->has('specs')) {
                foreach ($request->specs as $spec) {
                    if (!empty($spec['name']) && !empty($spec['value'])) {
                        $product->specs()->create([
                            'spec_name'  => $spec['name'],
                            'spec_value' => $spec['value'],
                        ]);
                    }
                }
            }
            return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Không thể thêm sản phẩm: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function uploadTemp(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('products/gallery', 'public');
            // dd($path);
            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
