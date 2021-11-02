<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductPurchaseDetail;
use App\Stock;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request){

        $barcode = $request->barcode;
        //$product_type = $request->product_type;
        $data = array();
        if($barcode){
//            if($product_type == 'Dress'){
//                $product_check_exists = Product::where('barcode',$barcode)->where('product_type','=','Dress')->pluck('id')->first();
//            }else{
//                $product_check_exists = Product::where('barcode',$barcode)->where('product_type','=','Gauze Cloth')->pluck('id')->first();
//            }

            $product_check_exists = Product::where('barcode',$barcode)->pluck('id')->first();
            if($product_check_exists){
                $product_current_stock_check_exists = Stock::where('product_id',$product_check_exists)->latest()->pluck('current_stock')->first();
                if($product_current_stock_check_exists > 0){
                    $data['product_check_exists'] = 'Product Found!';
                    $product = DB::table('products')
                        ->leftJoin('product_units','product_units.id','=','products.product_unit_id')
                        ->where('barcode',$barcode)
                        ->select('products.*','product_units.name as unit_name')
                        ->first();

                    if(!empty($product)){
                        $price = ProductPurchaseDetail::where('product_id',$product->id)->latest()->pluck('mrp_price')->first();
                        $data['id'] = $product->id;
                        $data['name'] = $product->name;
                        $data['qty'] = 1;
                        $data['price'] = $price;
                        $data['options']['barcode'] = $barcode;
                        $data['options']['unit_name'] = $product->unit_name;
                        Cart::add($data);
                    }
                    $data['countCart'] = Cart::count();
                }else{
                    $data['product_check_exists'] = 'No Product Stock Found!';
                }
            }else{
                $data['product_check_exists'] = 'No Product Found!';
            }

        }
        return response()->json(['success'=> true, 'response'=>$data]);
    }

    public function updateCartProduct($rowId, $qty){
        if($rowId){
            //$qty = 2;
            Cart::update($rowId, $qty);
        }
        $info['success'] = true;
        echo json_encode($info);
    }

    public function deleteCartProduct($rowId){
        if($rowId){
            Cart::remove($rowId);
        }
        $info['success'] = true;
        echo json_encode($info);
    }

    public function deleteAllCartProduct(){

        Cart::destroy();
        $info['success'] = true;
        echo json_encode($info);
    }
}
