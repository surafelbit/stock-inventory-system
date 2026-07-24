<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomerController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

use App\Models\Product;
use App\Models\Category;

Route::get('/dashboard', function () {
    $totalProducts = Product::count();
    $totalStock = (int) Product::sum('stock');
    
    $stockValue = (float) Product::selectRaw('SUM(stock * cost_price) as total_val')->value('total_val');
    
    $lowStockCount = Product::where('stock', '<', 10)->count();
    
    $recentProducts = Product::with('category')->latest()->take(5)->get();
    
    // Get all categories with their product count
    $categoryCounts = Category::withCount('products')->get()->map(function ($cat) {
        return [
            'id' => $cat->id,
            'name' => $cat->name,
            'count' => $cat->products_count,
        ];
    });

    return Inertia::render('Dashboard', [
        'stats' => [
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'stockValue' => $stockValue,
            'lowStockCount' => $lowStockCount,
        ],
        'recentProducts' => $recentProducts,
        'categoryCounts' => $categoryCounts,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
});

require __DIR__.'/auth.php';
