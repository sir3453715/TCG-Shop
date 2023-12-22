<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\Card;
use App\Models\Deck;
use App\Models\FrequentContact;
use App\Models\Order;
use App\Models\OrderBox;
use App\Models\OrderComment;
use App\Models\OrderFile;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Sailing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use TsaiYiHua\ECPay\Checkout;

class OrdersController extends Controller
{
    protected $checkout;

    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

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
        $queried=['keyword'=>'','status'=>'','payment'=>'','pay_status'=>'','shipment'=>''];
        $orders = Order::whereNotNull('id');
        if(Auth::user()->hasRole(['vendor','staff'])){
            $orders = $orders->where('vendor_id',$vendor_id);
        }
        if ($request->get('keyword')){
            $keyword = $request->get('keyword');
            $orders = $orders->where(function ($query) use ($keyword){
                $query->orwhere('seccode','LIKE','%'.$keyword.'%');
                $query->orwhere('buyer_name','LIKE','%'.$keyword.'%');
                $query->orwhere('buyer_phone','LIKE','%'.$keyword.'%');
            });
            $queried['keyword']=$keyword;
        }
        if ($request->get('status')){
            $status = $request->get('status');
            $orders = $orders->where('status',$status);
            $queried['status']=$status;
        }
        if ($request->get('payment')){
            $payment = $request->get('payment');
            $orders = $orders->where('payment',$payment);
            $queried['payment']=$payment;
        }
        if ($request->get('pay_status')!=''){
            $pay_status = $request->get('pay_status');
            $orders = $orders->where('pay_status',$pay_status);
            $queried['pay_status']=$pay_status;
        }
        if ($request->get('shipment')){
            $shipment = $request->get('shipment');
            $orders = $orders->where('shipment',$shipment);
            $queried['shipment']=$shipment;
        }

        $orders = $orders->orderBy('created_at','desc')->paginate(20);

        $orderDefaultSetting = config('defaultSetting.order');

        return view('admin.orders.orders',[
            'orders'=>$orders,
            'queried'=>$queried,
            'orderDefaultSetting'=>$orderDefaultSetting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orderDefaultSetting = config('defaultSetting.order');
        return view('admin.orders.createOrder',[
            'orderDefaultSetting'=>$orderDefaultSetting,
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
        $tempcode2 = 'TS'.date('ymd');
        $seccode_order = Order::where('seccode','LIKE','%'.$tempcode2.'%')->orderBy('created_at','DESC')->get();
        if($seccode_order){
            $num = count($seccode_order);
            do{
                $num ++;
                $tempseccode = $tempcode2.str_pad($num,4,0,STR_PAD_LEFT);
                $chk_seccode = Order::where('seccode','=',$tempseccode)->first();//判斷已產生的訂單編號是否存在
            } while ($chk_seccode);
        }else{
            $tempseccode = $tempcode2.'0001';
        }

        $data =[
            'seccode'=>$tempseccode,
            'user_id'=>$request->get('user_id'),
            "payment" => $request->get('payment'),
            "pay_status" => $request->get('pay_status'),
            "shipment" => $request->get('shipment'),
            "buyer_name" => $request->get('buyer_name'),
            "buyer_phone" => $request->get('buyer_phone'),
            "buyer_address" => $request->get('buyer_address'),
            "note" => $request->get('note'),
            "status" => $request->get('status'),
            "shipping_code" => $request->get('shipping_code'),
            "CVS_name" => $request->get('CVS_name'),
            "CVS_code" => $request->get('CVS_code'),
        ];

        $order = Order::create($data);

        $card_ids = $request->get('item_card_id');
        $number = $request->get('item_number');
        $unit_price = $request->get('item_unit_price');
        $card_name = $request->get('item_card_name');

        $total = 0;
        foreach ($card_ids as $index => $card_id){
            $itemData = [
                'order_id'=>$order->id,
                'card_id'=>$card_id,
                'number'=>$number[$index],
                'unit_price'=>$unit_price[$index],
                'subtotal'=>intval($number[$index])*intval($unit_price[$index]),
                'title'=>$card_name[$index],
            ];
            $orderItem = OrderItem::create($itemData);

            $total += $itemData['subtotal'];
        }


        $order->fill(['total'=>$total]);
        $order->save();
        ActionLog::create_log($order,'新增');


        return redirect(route('admin.order.index'))->with('message', '訂單已建立!');

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
        //
        $order = Order::find($id);

        $orderDefaultSetting = config('defaultSetting.order');
        return view('admin.orders.editOrder',[
            'order'=>$order,
            'orderDefaultSetting'=>$orderDefaultSetting,
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
        $order = Order::find($id);
        $oldOrderItemsIDs = $order->orderItems->pluck('id')->toArray();
        $newOrderItemsIDs = $request->get('item_id');

        $deleteOrderItemIDs = array_diff($oldOrderItemsIDs,$newOrderItemsIDs);//從舊的Item IDs 中 排除保留Item ID

        $total = 0;
        $card_ids = $request->get('item_card_id');
        $card_name = $request->get('item_card_name');
        $number = $request->get('item_number');
        $unit_price = $request->get('item_unit_price');

        foreach ($deleteOrderItemIDs as $deleteOrderItemID){
            $item = OrderItem::find($deleteOrderItemID);
            $item->delete();
        }

        foreach ($card_ids as $index => $card_id){
            $item = OrderItem::where('card_id',$card_id)->first();
            if($item){
                $itemData = [
                    'order_id'=>$order->id,
                    'card_id'=>$card_id,
                    'number'=>$number[$index],
                    'unit_price'=>$unit_price[$index],
                    'subtotal'=>intval($number[$index])*intval($unit_price[$index]),
                    'title'=>$card_name[$index],
                ];
                $item->fill($itemData);
                $item->save();
            }else{
                $itemData = [
                    'order_id'=>$order->id,
                    'card_id'=>$card_id,
                    'number'=>$number[$index],
                    'unit_price'=>$unit_price[$index],
                    'subtotal'=>intval($number[$index])*intval($unit_price[$index]),
                    'title'=>$card_name[$index],
                ];
                $orderItem = OrderItem::create($itemData);
            }
            $total += $itemData['subtotal'];
        }


        $data =[
            'user_id'=>$request->get('user_id'),
            "payment" => $request->get('payment'),
            "pay_status" => $request->get('pay_status'),
            "shipment" => $request->get('shipment'),
            "buyer_name" => $request->get('buyer_name'),
            "buyer_phone" => $request->get('buyer_phone'),
            "buyer_address" => $request->get('buyer_address'),
            "note" => $request->get('note'),
            "total" => $total,
            "status" => $request->get('status'),
            "shipping_code" => $request->get('shipping_code'),
            "CVS_name" => $request->get('CVS_name'),
            "CVS_code" => $request->get('CVS_code'),
        ];

        $order->fill($data);
        ActionLog::create_log($order);
        $order->save();


        return redirect(route('admin.order.index'))->with('message', '訂單 <a class="text-dark" href="'.route('admin.order.edit',['order'=>$order->id]).'">'.$order->seccode.'</a> 已完成修改!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $order = Order::find($id);
//
//        if ($order)
//            $order->delete();
//
//        return redirect(route('admin.order.index'))->with('message', '訂單已刪除!');
    }



    public function GetItemCard(Request $request){
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $competition = 'ptcg_'.$request->get('competition');
            $competition_number = app('Option')->$competition;
            $cards = Card::whereNotNull('id');
            $cards = $cards->whereIn('competition_number',explode(',',$competition_number));
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
            $infoHTML .= "<div class='col-md-2 col-4 p-1 CardOption'>
                            <a href='javascript:void(0);' class='selectItemClick' data-id='$card->id'>
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

    public function ImportCodeCard(Request $request){
        if($request->get('code')){
            $code = $request->get('code');
            $deck = Deck::where('code',$code)->first();
            $cards = $deck->deckCardCategoryInfo();
        }else{
            return json_encode(['result'=>'0']);
        }

        $infoHTML = '';
        foreach($cards as $type => $cardCategory){
            foreach($cardCategory as $id => $card){
                $infoHTML .= "<div class='col-md-1 col-4 border p-1' id='DeckCardInfo-$id' >
                                <small>".$card['name']."</small>
                                <img class='w-100 p-1' src='".$card['image']."' />
                                <div class='d-flex justify-content-between'>
                                    <a class='changeCardNumber' href='javascript:void(0)' data-id='$id' data-model='plus'>                                                                            <span class='badge badge-warning '>
                                            <i class='fa fa-plus'></i>
                                        </span>
                                    </a>
                                        <span class='badge badge-secondary fa-1x' id='CardNum-$id'>".$card['num']."</span>
                                    <a class='changeCardNumber' href='javascript:void(0)' data-id='$id' data-model='minus'>                                                                            <span class='badge badge-warning '>
                                            <i class='fa fa-minus'></i>
                                        </span>
                                    </a>
                                </div>
                                <input type='hidden' name='card_id[]' value='$id'>
                                <input type='hidden' name='card_num[]' value='".$card['num']."' id='cardNumInput-".$card['num']."'>
                            </div>";
            }
        }

        $result = array_merge(['result'=>'1','html'=>$infoHTML]);
        return json_encode($result);

    }

    public function addOrderItem(Request $request){
        if($request->get('card_ids') && $request->get('card_nums')){
            $card_ids = $request->get('card_ids');
            $card_nums = $request->get('card_nums');
        }else{
            return json_encode(['result'=>'0']);
        }
        $addItemArray=[];
        foreach ($card_ids as $index => $card_id){
            $cardFind = Card::find($card_id);
            $addItemArray[]=[
                'item_card_id'=>$cardFind->id,
                'item_card_name'=>$cardFind->name,
                'item_card_image'=>$cardFind->image,
                'item_card_type'=>$cardFind->type,
                'item_number'=>$card_nums[$index],
                'item_unit_price'=>$cardFind->default_price,
                'item_subtotal'=>(intval($card_nums[$index])*intval($cardFind->default_price)),
            ];
        }

        $result = array_merge(['result'=>'1','addItemArray'=>$addItemArray]);
        return json_encode($result);

    }
//    public function addOrderItem(Request $request){
//        if($request->get('card_ids') && $request->get('card_nums')){
//            $card_ids = $request->get('card_ids');
//            $card_nums = $request->get('card_nums');
//        }else{
//            return json_encode(['result'=>'0']);
//        }
//
//        $infoHTML = '';
//        foreach ($card_ids as $index => $card_id){
//            $cardFind = Card::find($card_id);
//            $infoHTML .= "<tr>
//                            <td><div class='d-flex'><input type='hidden' class='form-control' name='item_card_id[]' value='$cardFind->id' readonly>
//                                <img src='$cardFind->image' style='width: 40px'></div></td>
//                            <td><input type='text' class='form-control' name='item_card_name[]' value='$cardFind->name' readonly></td>
//                            <td><input type='text' class='form-control' name='item_card_type[]' value='$cardFind->type' readonly></td>
//                            <td><input type='number' min='1' step='1' class='form-control item_change' id='number-$cardFind->id' data-id='$cardFind->id' name='item_number[]' value='".$card_nums[$index]."'></td>
//                            <td><input type='number' min='0' step='1' class='form-control item_change' id='unit_price-$cardFind->id' data-id='$cardFind->id' name='item_unit_price[]' value='$cardFind->default_price'></td>
//                            <td><input type='number' min='1' step='1' class='form-control item_subtotal' id='subtotal-$cardFind->id' data-id='$cardFind->id' name='item_subtotal[]' value='".(intval($card_nums[$index])*intval($cardFind->default_price))."' disabled></td>
//                            <td><button type='button' class='btn btn-sm btn-danger item-delete'><i class='fa fa-trash'></i></button></td>
//                          </tr>";
//        }
//
//        $result = array_merge(['result'=>'1','html'=>$infoHTML]);
//        return json_encode($result);
//
//    }
}
