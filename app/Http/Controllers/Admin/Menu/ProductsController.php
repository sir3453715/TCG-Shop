<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Card;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendor_id = '';
        $user = Auth::user();
        if(Auth::user()->hasRole('vendor')){
            $vendor_id = $user->vendor->id;
        }elseif (Auth::user()->hasRole('staff')){
            $vendor_id = $user->vendorStaff->vendor->id;
        }

        $queried = ['keyword'=>'','card_id'=>'','status'=>''];

        $products = Product::whereNotNull('id');
        if(Auth::user()->hasRole(['vendor','staff'])){
            $products = $products->where('vendor_id',$vendor_id);
        }

        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $products = $products->where(function ($query) use ($keyword){
                $query->orwhere('id','LIKE','%'.$keyword.'%');//產品編號
                $query->orwhere('title','LIKE','%'.$keyword.'%');//產品標題
                $query->orwhere('sku','LIKE','%'.$keyword.'%');//SKU
            });
            $queried['keyword'] = $request->get('keyword');
        }
        $products = $products->orderBy('created_at','ASC')->paginate(20);


        return view('admin.products.products',[
            'queried'=>$queried,
            'products'=>$products,
            'vendor_id'=>$vendor_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor_id = '';
        $user = Auth::user();
        if(Auth::user()->hasRole('vendor')){
            $vendor_id = $user->vendor->id;
        }elseif (Auth::user()->hasRole('staff')){
            $vendor_id = $user->vendorStaff->vendor->id;
        }

        return view('admin.products.createProduct',[
            'vendor_id'=>$vendor_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data=[
            'card_id'=>$request->get('card_id'),
            'vendor_id'=>$request->get('vendor_id'),
            'price'=>$request->get('price'),
            'stock'=>$request->get('stock'),
            'status'=>$request->get('status'),
        ];
        $product = Product::create($data);

        ActionLog::create_log($product,'新增');

        return redirect(route('admin.product.index'))->with('message', '產品已建立!');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        return view('admin.products.editProduct',[
            'product'=>$product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Product::find($id);

        $data=[
            'card_id'=>$request->get('card_id'),
            'vendor_id'=>$request->get('vendor_id'),
            'price'=>$request->get('price'),
            'stock'=>$request->get('stock'),
            'status'=>$request->get('status'),
        ];

        $product->fill($data);
        ActionLog::create_log($product);
        $product->save();

        return redirect(route('admin.product.index'))->with('message', '產品已修改!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        ActionLog::create_log($product,'刪除');
        
        $product->delete();


        return redirect(route('admin.product.index'))->with('message', '產品已刪除!');
    }


    public function GetProductCard(Request $request){
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $cards = Card::whereNotNull('id');
            $cards = $cards->where(function ($query) use ($keyword){
                $query->orwhere('name','LIKE','%'.$keyword.'%');//產品編號
                $query->orwhere('series','LIKE','%'.$keyword.'%');//產品標題
//                $query->orwhere('skill','LIKE','%'.json_encode($keyword).'%');//技能
            });
            $cards = $cards->orderBy('created_at','ASC')->get();
        }else{
            return json_encode(['result'=>'0']);
        }

        $infoHTML = '';
        foreach($cards as $card){
            $infoHTML .= "<div class='col-md-2 col-4 p-1 CardOption' data-id='$card->id'>
                            <a href='javascript:void(0);' class='selectCardClick'>
                                <img class='w-100 p-1' src='$card->image'>
                                <div class='text-center'>
                                    <span class='card-name'>$card->name</span>
                                </div>
                            </a>
                        </div>";
        }

        $result = array_merge(['result'=>'1','html'=>$infoHTML]);
        return json_encode($result);
    }

}
