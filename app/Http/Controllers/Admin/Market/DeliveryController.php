<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\DeliveryRequest;
use App\Models\Market\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_methods = Delivery::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.delivery.index', compact('delivery_methods'));
    }

    public function search(Request $request)
    {
        $delivery_methods = Delivery::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.delivery.index', compact('delivery_methods'));
    }
    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.market.delivery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(DeliveryRequest $request)
    {
        $inputs = $request->all();
        $delivery = Delivery::create($inputs);
        if($delivery)
        {
            return redirect()->route('admin.market.delivery.index')->with('swal-success', 'روش ' . $delivery->name . ' با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.market.delivery.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }

    public function status(Delivery $delivery)
    {
        $delivery->status = $delivery->status == 1 ? 2 : 1;
        $result = $delivery->save();
        if ($result) {
            if ($delivery->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' =>  'وضعیت با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        return view('admin.market.delivery.edit', compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        $inputs = $request->all();
        $update = $delivery->update($inputs);
        if($update)
        {
            return redirect()->route('admin.market.delivery.index')->with('swal-success', 'روش ' . $delivery->name . ' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.market.delivery.edit', $delivery->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
       
        $result = $delivery->delete();
        if($result)
        {
            return redirect()->route('admin.market.delivery.index')->with('swal-success', 'روش ' . $delivery->name . ' با موفقیت حذف شد');
        }
        else{
            return redirect()->route('admin.market.delivery.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
