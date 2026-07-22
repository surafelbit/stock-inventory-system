<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        return Inertia::render('Purchases/Index', [
            // Load purchases along with supplier and product details
            'purchases' => Purchase::with(['supplier', 'product'])->latest()->get(),
            'suppliers' => Supplier::select('id', 'name')->get(),
            'products' => Product::select('id', 'name', 'cost_price', 'stock')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        // Atomic transaction: Log purchase AND increase stock level together
        DB::transaction(function () use ($validated) {
            $totalPrice = $validated['quantity'] * $validated['cost_price'];

            Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'cost_price' => $validated['cost_price'],
                'total_price' => $totalPrice,
            ]);

            // Automatically increment product stock!
            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock', $validated['quantity']);
        });

        return redirect()->back()->with('success', 'Stock purchase recorded successfully.');
    }
}