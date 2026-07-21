<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display Orders List
     */
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function adminDestroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order #' . $orderNumber . ' has been deleted successfully.');
    }
    /**
     * View Single Order
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update Order Status (Admin Manual Updates)
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string',
            'order_status' => 'required|string',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
            'order_status'   => $request->order_status,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Cancel Order (User Request Handler with 3 Days PKT Window)
     */
    public function cancel($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Check if user owns this order
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }

            // Check 3-day window (Pakistan Timezone)
            $orderPlacedAt = Carbon::parse($order->created_at)->timezone('Asia/Karachi');
            $currentTime = Carbon::now('Asia/Karachi');

            // Get current status - check both 'order_status' and 'status' fields
            $currentStatus = strtolower($order->order_status ?? $order->status ?? 'pending');

            // Check if already delivered or cancelled
            if (in_array($currentStatus, ['delivered', 'cancelled'])) {
                return redirect()->back()->with('error', 'This order cannot be cancelled. It is already ' . $currentStatus . '.');
            }

            // Check 3-day limit
            if ($orderPlacedAt->diffInDays($currentTime) >= 3) {
                return redirect()->back()->with('error', 'You cannot cancel this order now! The 3-day cancellation period has expired.');
            }

            // Update status to cancelled
            $updateData = [];
            
            if (array_key_exists('order_status', $order->getAttributes())) {
                $updateData['order_status'] = 'Cancelled';
            }
            
            if (array_key_exists('status', $order->getAttributes())) {
                $updateData['status'] = 'cancelled';
            }
            
            if (empty($updateData)) {
                $order->order_status = 'Cancelled';
                $order->save();
            } else {
                $order->update($updateData);
            }

            return redirect()->back()->with('success', 'Order #' . $order->order_number . ' has been cancelled successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while cancelling the order. Please try again.');
        }
    }

    /**
     * Delete Order (Permanent Delete - Only for Cancelled Orders)
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Check if user owns this order
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }

            // Get current status
            $currentStatus = strtolower($order->order_status ?? $order->status ?? '');

            // Only allow deletion of cancelled orders
            if ($currentStatus !== 'cancelled') {
                return redirect()->back()->with('error', 'Only cancelled orders can be deleted.');
            }

            // Delete the order permanently
            $orderNumber = $order->order_number;
            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Order #' . $orderNumber . ' has been deleted permanently.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete order. Please try again.');
        }
    }
}