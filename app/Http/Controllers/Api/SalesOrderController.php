<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\SalesRepresentative;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * الحصول على طلبات المندوب
     * Get sales representative's orders
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $salesRep = SalesRepresentative::where('user_id', $user->id)->first();

        if (!$salesRep) {
            return response()->json([
                'success' => false,
                'message' => 'المندوب غير موجود',
            ], 404);
        }

        $orders = SalesOrder::where('sales_representative_id', $salesRep->id)
            ->with(['customer:id,name,phone', 'store:id,name', 'items.productUnit.product:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $orders->items(),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    /**
     * عرض تفاصيل طلب
     * Show order details
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $salesRep = SalesRepresentative::where('user_id', $user->id)->first();

        if (!$salesRep) {
            return response()->json([
                'success' => false,
                'message' => 'المندوب غير موجود',
            ], 404);
        }

        $order = SalesOrder::where('id', $id)
            ->where('sales_representative_id', $salesRep->id)
            ->with([
                'customer',
                'store',
                'items.productUnit.product',
                'items.productUnit.unit',
            ])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * إنشاء طلب جديد
     * Create new order
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'store_id' => 'required|exists:stores,id',
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_unit_id' => 'required|exists:product_units,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        $user = $request->user();
        $salesRep = SalesRepresentative::where('user_id', $user->id)->first();

        if (!$salesRep) {
            return response()->json([
                'success' => false,
                'message' => 'المندوب غير موجود',
            ], 404);
        }

        try {
            DB::beginTransaction();

            // حساب المجاميع
            $subtotal = 0;
            $totalDiscount = 0;

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $discount = $item['discount'] ?? 0;
                $subtotal += $lineTotal;
                $totalDiscount += $discount;
            }

            $totalAmount = $subtotal - $totalDiscount;

            // إنشاء رقم الطلب
            $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(
                SalesOrder::whereYear('created_at', date('Y'))->count() + 1,
                5,
                '0',
                STR_PAD_LEFT
            );

            // إنشاء الطلب
            $order = SalesOrder::create([
                'order_number' => $orderNumber,
                'customer_id' => $request->customer_id,
                'sales_representative_id' => $salesRep->id,
                'store_id' => $request->store_id,
                'order_date' => now(),
                'delivery_date' => $request->delivery_date,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'tax_amount' => 0,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
                'created_by' => $user->id,
            ]);

            // إنشاء بنود الطلب
            foreach ($request->items as $item) {
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_unit_id' => $item['product_unit_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'] ?? 0,
                    'total' => ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0),
                ]);
            }

            DB::commit();

            // تحميل العلاقات
            $order->load(['customer', 'items.productUnit.product']);

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الطلب بنجاح',
                'data' => $order,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الطلب',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * الحصول على العملاء المتاحين للمندوب
     * Get available customers
     */
    public function getCustomers(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        $customers = Customer::where('active', true)
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'phone', 'address', 'credit_limit', 'balance')
            ->orderBy('name')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customers,
        ]);
    }

    /**
     * الحصول على المنتجات
     * Get products
     */
    public function getProducts(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $categoryId = $request->get('category_id');

        $products = Product::where('status', 'active')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->with(['productUnits.unit', 'category:id,name'])
            ->select('id', 'name', 'category_id')
            ->orderBy('name')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
