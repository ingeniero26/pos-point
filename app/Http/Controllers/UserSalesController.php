<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\ItemsModel;
use App\Models\PersonModel;
use App\Models\PaymentMethodModel;
use App\Models\PaymentTypeModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSalesController extends Controller
{
    public function list()
    {
        $data['sales'] = Sales::where('created_by', Auth::id())
            ->where('is_delete', 0)
            ->orderBy('id', 'desc')
            ->get();
        return view('user.sales.list', $data);
    }

    public function create()
    {
        $data['customers'] = PersonModel::where('is_delete', 0)
            ->where('type_third_id', 1)
            ->get();
        $data['products'] = ItemsModel::where('is_delete', 0)
            ->where('status', 0)
            ->get();
        $data['paymentMethods'] = PaymentMethodModel::where('is_delete', 0)->get();
        $data['paymentTypes'] = PaymentTypeModel::where('is_delete', 0)->get();
        $data['warehouses'] = WarehouseModel::where('is_delete', 0)->get();
        
        return view('user.sales.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $sale = new Sales();
            $sale->customer_id = $data['customer_id'];
            $sale->warehouse_id = $data['warehouse_id'];
            $sale->payment_form_id = $data['payment_form_id'];
            $sale->payment_method_id = $data['payment_method_id'];
            $sale->date_of_issue = now();
            $sale->total_subtotal = $data['total_subtotal'];
            $sale->total_tax = $data['total_tax'];
            $sale->total_amount = $data['total_amount'];
            $sale->created_by = Auth::id();
            $sale->company_id = Auth::user()->company_id;
            $sale->save();

            // Guardar los items de la venta
            foreach ($data['items'] as $item) {
                $saleItem = new \App\Models\SalesItems();
                $saleItem->sale_id = $sale->id;
                $saleItem->item_id = $item['id'];
                $saleItem->quantity = $item['quantity'];
                $saleItem->unit_price = $item['price'];
                $saleItem->discount = $item['discount'] ?? 0;
                $saleItem->tax_id = $item['tax_id'] ?? null;
                $saleItem->tax_rate = $item['tax_rate'] ?? 0;
                $saleItem->tax_amount = $item['tax_amount'] ?? 0;
                $saleItem->subtotal = $item['subtotal'];
                $saleItem->total = $item['total'];
                $saleItem->created_by = Auth::id();
                $saleItem->company_id = Auth::user()->company_id;
                $saleItem->save();

                // Actualizar inventario
                $inventory = \App\Models\InventoryModel::where('item_id', $item['id'])
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->first();
                
                if ($inventory) {
                    $inventory->stock -= $item['quantity'];
                    $inventory->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada exitosamente',
                'sale_id' => $sale->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la venta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $sale = Sales::with([
            'customers',
            'paymentForm',
            'payment_method',
            'warehouses',
            'sales_items.item'
        ])
        ->where('id', $id)
        ->where('created_by', Auth::id())
        ->where('is_delete', 0)
        ->firstOrFail();

        return view('user.sales.show', compact('sale'));
    }
} 