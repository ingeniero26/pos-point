<?php

namespace App\Http\Controllers;

use App\Models\ItemsModel;
use App\Models\SalesItems;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $products = ItemsModel::where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('code', 'like', "%{$query}%");
        })
        ->where('status', 1)
        ->select('id', 'name', 'code', 'price', 'stock')
        ->limit(10)
        ->get();

        return response()->json($products);
    }

    public function frequent()
    {
        $frequentProducts = SalesItems::select('item_id')
            ->selectRaw('COUNT(*) as frequency')
            ->groupBy('item_id')
            ->orderBy('frequency', 'desc')
            ->limit(8)
            ->get()
            ->pluck('item_id');

        $products = ItemsModel::whereIn('id', $frequentProducts)
            ->where('status', 1)
            ->select('id', 'name', 'code', 'price', 'stock', 'image')
            ->get();

        return response()->json($products);
    }
} 