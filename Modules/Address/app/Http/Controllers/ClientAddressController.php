<?php

namespace Modules\Address\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Address\app\Http\Requests\Client\ProfileAddressRequest;
use Modules\Address\app\Models\Address;
use Modules\Address\Services\AddressService;
use Modules\Province\app\Models\Province;

class ClientAddressController extends Controller
{
    protected $addressService;
    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }
    /**
     * Display a listing of the resource.
     */
    public function address()
    {
        $addresses = $this->addressService->getAddress();
        return view('address::client.profile.address.address',compact('addresses'));
    }

    public function create_address()
    {
        $provinces = Province::with('districts','districts.wards')
        ->select('id','name')
        ->get();
        return view('address::client.profile.address.create',compact('provinces'));
    }

    public function store_address(ProfileAddressRequest $request)
    {
        $address = new Address($request->all());
        $address->user_id = Auth::user()->id;

        if ($request->has('is_default')) {
            $address->is_default = true;
            // Set all other addresses for the same user to false
            Address::where('user_id', Auth::user()->id)
                ->where('id', '<>', $address->id)
                ->update(['is_default' => false]);
        } else {
            $address->is_default = false;
        }
        $address->save();
        return response()->json([
            'success' => 'Thêm địa chỉ thành công',
        ], 200);
    }

    public function edit_address(ProfileAddressRequest $request, $slug)
    {
        $address = Auth::user()->addresses()->where('slug',$slug)->first();
        $provinces = Province::with('districts','districts.wards')
        ->select('id','name')
        ->get();
        return view('address::client.profile.address.edit',compact('provinces', 'address'));
    }

    public function update_address(Request $request, $slug)
    {
        $address = Auth::user()->addresses()->where('slug', $slug)->first()->fill($request->all());
        $address->user_id = Auth::user()->id;

        $is_default = $request->has('is_default');
        if ($is_default) {
            $address->is_default = true;

            Address::where('user_id', Auth::user()->id)
            ->where('id', '<>', $address->id)
            ->update(['is_default' => false]);

        } else {
            $address->is_default = $address->is_default;
        }

        $address->save();
        return response()->json([
            'success' => 'Cập nhập địa chỉ thành công',
        ], 200);
    }

    public function destroy_address($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        $address->delete();
        return response()->json([
            'success' => 'Xóa địa chỉ thành công.',
        ], 200);
    }
}
