<?php

namespace App\Http\Controllers;

use App\Models\CurrenciesModel;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ItemsModel;
use App\Models\PersonModel;
use App\Models\CurrencyModel;
use App\Models\PaymentTypeModel;
use App\Models\StatusOrder;
use App\Models\StatusOrderModel;
use App\Models\StatusOrderDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //  public function list()
    // {
    //     //
    //     $data['customers'] = PersonModel::where('is_delete', '=', 0)
    //     ->where('type_third_id','=', 1)
    //     ->get();
    //     return view('admin.sales.list', $data);
    // }
    public function index()
    {
         $data['customers'] = PersonModel::where('is_delete', '=', 0)
            ->where('type_third_id', '=', 1)
            ->get();
            
        return view('admin.orders.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'customers' => PersonModel::where('is_delete', 0)
                ->where('type_third_id', 1)
                ->get(),
            'products' => ItemsModel::where('is_delete', 0)
                ->where('status', 0)
                ->get(),
            'currencies' => CurrenciesModel::where('is_delete', 0)->get(),
            'paymentForms' => PaymentTypeModel::where('is_delete', 0)->get(),
            'statuses' => StatusOrder::where('is_delete', 0)->get(),
            'detailStatuses' => StatusOrderDetailModel::where('is_delete', 0)->get()
        ];
        
        return view('admin.orders.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Generar número de pedido
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            // Crear pedido
            $order = new Order();
            $order->order_number = $orderNumber;
            $order->person_id = $request->person_id;
            $order->issue_date = $request->issue_date;
            $order->delivery_date = $request->delivery_date;
            $order->currency_id = $request->currency_id;
            $order->exchange_rate = $request->exchange_rate ?? 1;
            $order->subtotal = $request->subtotal;
            $order->discount = $request->discount;
            $order->vat = $request->vat;
            $order->total = $request->total;
            $order->payment_form_id = $request->payment_form_id;
            $order->delivery_address = $request->delivery_address;
            $order->created_by = Auth::id();
            $order->status_order_id = $request->status_order_id;
            $order->company_id = Auth::user()->company_id;
            $order->save();

            // Guardar detalles
            foreach ($request->items as $item) {
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->item_id = $item['item_id'];
                $detail->quantity = $item['quantity'];
                $detail->unit_price = $item['unit_price'];
                $detail->discount = $item['discount'];
                $detail->subtotal = $item['subtotal'];
                $detail->vat_rate = $item['vat_rate'];
                $detail->vat_value = $item['vat_value'];
                $detail->total = $item['total'];
                $detail->status_order_detail_id = $request->status_order_detail_id;
                $detail->save();
            }

            DB::commit();
            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Pedido creado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['person', 'currency', 'paymentForm', 'status', 'details.item', 'details.status'])
            ->findOrFail($id);
            
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::with(['details'])->findOrFail($id);
        
        $data = [
            'order' => $order,
            'customers' => PersonModel::where('is_delete', 0)
                ->where('type_third_id', 1)
                ->get(),
            'products' => ItemsModel::where('is_delete', 0)
                ->where('status', 0)
                ->get(),
            'currencies' => CurrenciesModel::where('is_delete', 0)->get(),
            'paymentForms' => PaymentTypeModel::where('is_delete', 0)->get(),
            'statuses' => StatusOrder::where('is_delete', 0)->get(),
            'detailStatuses' => StatusOrderDetailModel::where('is_delete', 0)->get()
        ];
        
        return view('admin.orders.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            
            // Actualizar pedido
            $order->person_id = $request->person_id;
            $order->issue_date = $request->issue_date;
            $order->delivery_date = $request->delivery_date;
            $order->currency_id = $request->currency_id;
            $order->exchange_rate = $request->exchange_rate ?? 1;
            $order->subtotal = $request->subtotal;
            $order->discount = $request->discount;
            $order->vat = $request->vat;
            $order->total = $request->total;
            $order->payment_form_id = $request->payment_form_id;
            $order->delivery_address = $request->delivery_address;
            $order->status_order_id = $request->status_order_id;
            $order->save();

            // Eliminar detalles existentes
            OrderDetail::where('order_id', $order->id)->delete();

            // Guardar nuevos detalles
            foreach ($request->items as $item) {
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->item_id = $item['item_id'];
                $detail->quantity = $item['quantity'];
                $detail->unit_price = $item['unit_price'];
                $detail->discount = $item['discount'];
                $detail->subtotal = $item['subtotal'];
                $detail->vat_rate = $item['vat_rate'];
                $detail->vat_value = $item['vat_value'];
                $detail->total = $item['total'];
                $detail->status_order_detail_id = $request->status_order_detail_id;
                $detail->save();
            }

            DB::commit();
            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Pedido actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            
            // Eliminar detalles
            OrderDetail::where('order_id', $order->id)->delete();
            
            // Eliminar pedido
            $order->delete();

            DB::commit();
            return redirect()->route('admin.orders.index')
                ->with('success', 'Pedido eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }

    public function searchItems(Request $request)
    {
        $term = $request->term;
        
        $items = ItemsModel::where('is_delete', 0)
            ->where('status', 0)
            ->where(function($query) use ($term) {
                $query->where('product_name', 'LIKE', "%{$term}%")
                    ->orWhere('code', 'LIKE', "%{$term}%");
            })
            ->get();
            
        return response()->json($items);
    }
}
