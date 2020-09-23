<?php

namespace App\Http\Controllers;
use App\Product;
use App\Buy;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    public function show(Request $request){

    	$products = Product::with('typeName')->offset($request->input('page')*20 )->limit(20)->get();

    	return response()->json($products);
    }

    public function showAction(Request $request){

        $products = Product::where('action', 1 )
        ->orderBy('created_at', 'asc')
        ->offset($request->input('page')*20)->limit(20)->get();

        return response()->json($products);
    }

    public function showapi(Request $request){
        $user = JWTAuth::authenticate();
        
        $products = Product::with('typeName')->where('type', $request->type)->offset($request->input('page')*20)->limit(20)->get();
        return response()->json($products);
    }
    public function new_old(Request $request){
        $products = Product::with('typeName')->where('new_old', $request->new_old)->offset( $request->input('page')*20)->limit(20)->get();
        return response()->json($products);
    }
    public function all_search(Request $request){
        $products = Product::with('typeName')->where('name', 'like','%'.$request->input('name').'%')->offset( $request->input('page')*20)->limit(20)->get();
        return response()->json($products);
    }

    public function export_products(){
        $products = DB::table('products')->get();
        //return $products;

        $proData = "";

        if (count($products) >0 ) {
            $proData .= '<table>
            <tr>
                <th style="border:1px solid #000">Name</th>
                <th style="border:1px solid #000">img</th>
                <th style="border:1px solid #000">type</th>
                <th style="border:1px solid #000">price</th>
            </tr>';

            foreach ($products as $product) {
                $proData .= '
                <tr>
                    <td style="border:1px solid #000">'.$product->name.'</td>
                    <td style="border:1px solid #000">'.$product->img.'</td>
                    <td style="border:1px solid #000">'.$product->type.'</td>
                    <td style="border:1px solid #000">'.$product->price.'</td>
                </tr>';
            }
            $proData .='</table>'; 
        }
        header('Content-Type: aplication/xls');
        header('Content-Disposition: atttachment; filename=products.xls');
        echo $proData;
    }

}
