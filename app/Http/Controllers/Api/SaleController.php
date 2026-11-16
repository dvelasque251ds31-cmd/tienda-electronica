<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index(): JsonResponse
    {
        $sales = Sale::with(['user:id,name', 'details.product:id,sku,name'])
            ->orderByDesc('id')
            ->paginate(15);

        return response()->json($sales);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_document' => ['nullable', 'string', 'max:20'],
            'payment_method' => ['required', 'in:efectivo,tarjeta,yape_plin,transferencia'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $sale = DB::transaction(function () use ($data, $request) {
            $subtotal = 0;
            $preparedItems = [];

            foreach ($data['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if (! $product->is_active) {
                    throw ValidationException::withMessages([
                        'items' => "El producto {$product->name} está inactivo.",
                    ]);
                }

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Stock insuficiente para {$product->name}. Disponible: {$product->stock}.",
                    ]);
                }

                $lineSubtotal = round($product->sale_price * $item['quantity'], 2);
                $subtotal += $lineSubtotal;

                $preparedItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->sale_price,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $tax = round($subtotal * 0.18, 2);
            $total = round($subtotal + $tax, 2);
            $nextNumber = (Sale::max('id') ?? 0) + 1;
            $invoiceNumber = 'BOL-' . str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);

            $sale = Sale::create([
                'user_id' => $request->user()->id,
                'invoice_number' => $invoiceNumber,
                'customer_name' => $data['customer_name'],
                'customer_document' => $data['customer_document'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'status' => 'completada',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($preparedItems as $line) {
                $sale->details()->create([
                    'product_id' => $line['product']->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'subtotal' => $line['subtotal'],
                ]);

                $line['product']->decrement('stock', $line['quantity']);
            }

            return $sale->load(['user:id,name', 'details.product:id,sku,name']);
        });

        return response()->json([
            'message' => 'Venta registrada correctamente.',
            'data' => $sale,
        ], 201);
    }

    public function show(Sale $sale): JsonResponse
    {
        return response()->json($sale->load(['user:id,name', 'details.product']));
    }

    public function destroy(Sale $sale): JsonResponse
    {
        if ($sale->status === 'anulada') {
            return response()->json([
                'message' => 'Esta venta ya fue anulada anteriormente.',
            ], 422);
        }

        DB::transaction(function () use ($sale) {
            foreach ($sale->details as $detail) {
                $detail->product()->increment('stock', $detail->quantity);
            }

            $sale->update(['status' => 'anulada']);
        });

        return response()->json([
            'message' => 'Venta anulada y stock repuesto correctamente.',
        ]);
    }
}