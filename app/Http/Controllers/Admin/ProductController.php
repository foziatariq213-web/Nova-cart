<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Mood;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $moods = Mood::all();
        return view('admin.products.create', compact('moods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'new_price' => 'required|numeric',  // Direct new_price
            'old_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'mood_id' => 'nullable|exists:moods,id',
            'gift_for' => 'nullable|string|max:255',
            'occasion' => 'nullable|string|max:255',
        ]);

        if (!empty($data['category'])) {
            $category = Category::firstOrCreate(
                ['name' => trim($data['category'])],
                ['slug' => Str::slug($data['category'])]
            );
            $data['category_id'] = $category->id;
        }

        unset($data['category']);
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->processAndStoreImage($request->file('image'));
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $moods = Mood::all();
        return view('admin.products.edit', compact('product', 'moods'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'new_price' => 'required|numeric',  // Direct new_price
            'old_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'mood_id' => 'nullable|exists:moods,id',
            'gift_for' => 'nullable|string|max:255',
            'occasion' => 'nullable|string|max:255',
        ]);

        if (!empty($data['category'])) {
            $category = Category::firstOrCreate(
                ['name' => trim($data['category'])],
                ['slug' => Str::slug($data['category'])]
            );
            $data['category_id'] = $category->id;
        }

        unset($data['category']);
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $this->deleteImageWithWebp($product->image);
            $data['image'] = $this->processAndStoreImage($request->file('image'));
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImageWithWebp($product->image);

        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    /**
     * Resize, compress, and store the uploaded image.
     * Also generates a matching .webp version for <picture> tags.
     */
    private function processAndStoreImage($file)
    {
        $destination = public_path('uploads/products');

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $fullPath = $destination.'/'.$filename;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getPathname());

        // Resize only if wider than 800px (keeps aspect ratio)
        if ($image->width() > 800) {
            $image->scale(width: 800);
        }

        // Save the compressed original-format image (quality 80)
        $image->save($fullPath, quality: 80);

        // Also generate a WebP version alongside it
        $webpFilename = pathinfo($filename, PATHINFO_FILENAME).'.webp';
        $image->toWebp(75)->save($destination.'/'.$webpFilename);

        return 'uploads/products/'.$filename;
    }

    /**
     * Delete both the main image and its .webp counterpart.
     */
    private function deleteImageWithWebp($imagePath)
    {
        if (!$imagePath) {
            return;
        }

        if (file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }

        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imagePath);
        if ($webpPath !== $imagePath && file_exists(public_path($webpPath))) {
            unlink(public_path($webpPath));
        }
    }
}