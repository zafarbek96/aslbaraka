<?php

namespace App\Http\Controllers;
use App\Buy;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Product;
use App\Type;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    public function create(Request $request){
        $orders = new Order();
        $orders->product_id = $request->input('product_id');
        $orders->count = $request->input('count');
        $orders->user_id = $request->input('user_id');

        $orders->save();
        return response()->json($orders);
    }

    public function showapi(Request $request){
        $user = JWTAuth::authenticate();
        $user_id = $user->id;
        $orders = Order::where('user_id', $user_id)
        //$orders = Order::where('user_id', $request->input('user_id'))
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*',
                    'products.name as product_name',
                    'products.img as product_img',
                    'products.type as product_type'
                    )
            ->offset($request->input('page')*20)->limit(20)
            ->get();

        return response()->json($orders);
    }

    public function many(Request $request){
        $user = JWTAuth::authenticate();
        $user_id = $user->id;
        /*$orders = Order::where('user_id', $user_id )
        ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('products.name as product_name',
                     'products.img as product_img',
                     'products.type as product_type',
                     'products.price as product_price',
                     'products.tovar as product_tovar',
                     'products.action as product_action',
                     'products.description as product_description',
                     'products.new_old as product_new_old'
                     )
            ->selectRaw('product_id, sum(count) as sum')
            ->orderBy('sum', 'desc')
            ->groupBy('product_id')
            ->offset($request->input('page')*20)->limit(20)
            ->get();*/

        $orders = Order::where('user_id', $user_id )
            ->with('product')
            ->with('product.typeName')
            ->selectRaw('product_id, sum(count) as sum')
            ->orderBy('sum', 'desc')
            ->groupBy('product_id')
            ->offset($request->input('page')*20)->limit(20)
            ->get();

        return response()->json($orders);
    }

    public function history(Request $request)  {
        $user = JWTAuth::authenticate();
        $user_id = $user->id;
        $orders = Buy::where('user_id', $user_id)
            -> whereDate(
                'data', 
                '>=', 
                date('Y-m-d H:i:s', mktime( 0,0,0, date("m"), date("d")-1 , date("Y") ) )
            )
            ->select('meneger')
            ->groupBy('meneger')
            ->get();
        return response()->json($orders);
    }

    public function toptovar(Request $request)  {
        $user = JWTAuth::authenticate();
         $user_id = $user->id;
         $orders = Order::where('meneger', $request->meneger)
             ->where('user_id', $user->id)
             
             
             ->offset($request->input('page')*20)->limit(20)
             ->get();
             $data = [];
             foreach ( $orders as  $order) {
                array_push($data,  [ 
                    // 'product_tovar'=>$order->tovar, 
                    'product_count'=>$order->count, 
                    // 'product_tovar'=>$order->tovar,
                    'time'=>$order->time,
                    'umumiy_summa'=>$order->all_price, 
                    'product'=> $order->product ] );
             }
         return response()->json( $data );
    }


    public function history_meneger(Request $request) {
         $user = JWTAuth::authenticate();
         $user_id = $user->id;
         $orders = Order::where('meneger', $request->meneger)
             ->where('user_id', $user->id)
             -> whereDate(
                'time', 
                '>=', 
                date('Y-m-d H:i:s', mktime( 0,0,0, date("m"), date("d")-1 , date("Y") ) )
            )
             
             ->offset($request->input('page')*20)->limit(20)
             ->get();
             $data = [];
             foreach ( $orders as  $order) {
                array_push($data,  [ 
                    // 'product_tovar'=>$order->tovar, 
                    'product_count'=>$order->count, 
                    // 'product_tovar'=>$order->tovar,
                    'time'=>$order->time,
                    'umumiy_summa'=>$order->all_price, 
                    'product'=> $order->product ] );
             }
         return response()->json( $data );
    }


    public function all_creat(Request $request) {
        $user = JWTAuth::authenticate();
        $user_id = $user->id;
        $products = ( $request->input('products') );
        $datetimeFormat = 'Y-m-d H:i:s';
        $date = new \DateTime();
        $date->setTimestamp($request->time);
        $time =  $date->format($datetimeFormat);
        $all_price = 0;



        foreach ($products as $product) {
            $product_price  = Product::where('id',$product['product_id'])->first()->price;
            $all_price += $product_price * $product['count'];

        }
        $buy_id = Buy::insertGetId([
            'user_name'=>$user->name,
            'user_id'=>$user->id,
            'number'=>$user->number,
            'data'=>$time,
            'summa'=>$all_price
        ]);
        foreach ($products as $product) {
            $orders = new Order();
            $orders->buy_id = $buy_id;
            $orders->user_id = $user_id;
            $orders->time = $time;
            $orders->meneger = $request->input('meneger');
            $orders->product_id = $product['product_id'];
            $orders->count = $product['count'];
            $orders->tovar = Product::where('id',$product['product_id'])->first()->tovar;
            $orders->product_price  = Product::where('id',$product['product_id'])->first()->price;
            $orders->all_price = $orders->product_price * $product['count'];
            $orders->save();
            $buy = Buy::find($buy_id);
            $buy->meneger = $request->input('meneger');
            $buy->save();
        }
        $response = [
                'msg'      => 'list',
                           ];
            return response()->json($response,200);

    }



}

