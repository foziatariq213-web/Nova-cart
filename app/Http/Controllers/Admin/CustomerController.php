<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display customer details.
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Not used.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Not used.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Not used.
     */
    public function edit(Customer $customer)
    {
        abort(404);
    }

    /**
     * Not used.
     */
    public function update(Request $request, Customer $customer)
    {
        abort(404);
    }

    /**
     * Delete a customer record.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}