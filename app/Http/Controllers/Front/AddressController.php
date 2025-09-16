<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('front.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        DB::transaction(function() use ($data) {
            if (!empty($data['is_default'])) {
                Address::where('user_id', Auth::id())->update(['is_default' => false]);
            }
            Address::create($data);
        });

        return redirect()->route('front.address.index')
                         ->with('success', 'Đã thêm địa chỉ mới.');
    }

    /**
     * Display the specified resource.
     * (Không sử dụng, có thể redirect về index or 404)
     */
    public function show(Address $address)
    {
        return redirect()->route('front.address.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);
        return view('front.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);
        $data = $request->validated();

        DB::transaction(function() use ($data, $address) {
            if (!empty($data['is_default'])) {
                Address::where('user_id', Auth::id())->update(['is_default' => false]);
            }
            $address->update($data);
        });

        return redirect()->route('front.address.index')
                         ->with('success', 'Đã cập nhật địa chỉ.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return back()->with('success', 'Đã xóa địa chỉ.');
    }
}
