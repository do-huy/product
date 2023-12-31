<?php

namespace Modules\Bill\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Bill\app\Models\Bill;

class ClientBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = auth()->user()->bills()
        ->with('billDetails')
        ->orderBy('id', 'DESC')
        ->get();
        return view('bill::client.index',compact('bills'));
    }

    public function detail($id)
    {
        $bill = auth()->user()->bills()
        ->with('billDetails')
        ->find($id);
        return view('bill::client.detail',compact('bill'));
    }

}
