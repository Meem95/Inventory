@extends('backend._partial.dashboard')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i>Loss/Profit</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    @if($start_date != '' && $end_date != '')
                        <a class="btn btn-warning" href="{{ url('loss-profit-filter-export/'.$start_date."/".$end_date) }}">Export Data</a>
                    @else
                        <a class="btn btn-warning" href="{{ route('loss.profit.export') }}">Export Data</a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Loss Profit Table</h3>
                <form class="form-inline" action="{{ route('transaction.lossProfit') }}">
                    <div class="form-group col-md-4">
                        <label for="start_date">Start Date:</label>
                        <input type="text" name="start_date" class="datepicker form-control" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="end_date">End Date:</label>
                        <input type="text" name="end_date" class="datepicker form-control" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{!! route('transaction.lossProfit') !!}" class="btn btn-primary" type="button">Reset</a>
                    </div>
                </form>
                <div>&nbsp;</div>
                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>

                            @php
                                $custom_start_date = $start_date.' 00:00:00';
                                $custom_end_date = $end_date.' 23:59:59';

                                /*if($start_date != '' && $end_date != ''){
                                    $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->where('product_purchases.created_at','>=',$custom_start_date)
                                    ->where('product_purchases.created_at','<=',$custom_end_date)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();
                                }else{
                                    $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();
                                }


                                $sum_loss_or_profit = 0;

                                foreach($productPurchaseDetails as $key => $productPurchaseDetail){

                                    $loss_or_profit = 0;
                                    $current_loss_or_profit = 0;
                                    $sale_total_qty = 0;
                                    $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;

                                    // sale
                                    $sale_total_qty = 0;
                                    $sale_total_amount = 0;
                                    $sale_average_price = 0;

                                    $productSaleDetails = DB::table('product_sale_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productSaleDetails))
                                    {
                                        $sale_total_qty = $productSaleDetails->qty;
                                        $sale_total_amount = $productSaleDetails->sub_total;
                                        $sale_average_price = $productSaleDetails->sub_total/$productSaleDetails->qty;

                                        if($sale_total_qty > 0){
                                            $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                            $current_loss_or_profit += $loss_or_profit;
                                            $sum_loss_or_profit += $loss_or_profit;
                                        }
                                    }

                                    // sale return
                                    $sale_return_total_qty = 0;
                                    $sale_return_total_amount = 0;
                                    $sale_return_average_price = 0;

                                    $productSaleReturnDetails = DB::table('product_sale_return_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productSaleReturnDetails))
                                    {
                                        $sale_return_total_qty = $productSaleReturnDetails->qty;
                                        $sale_return_total_amount = $productSaleReturnDetails->price;
                                        $sale_return_average_price = $sale_return_total_amount/$productSaleReturnDetails->qty;

                                        if($sale_return_total_qty > 0){
                                            $loss_or_profit = $sale_return_average_price - ($purchase_average_price*$sale_return_total_qty);
                                            $current_loss_or_profit -= $loss_or_profit;
                                            $sum_loss_or_profit -= $loss_or_profit;
                                        }
                                    }

                                }*/

                                $sum_purchase_price = 0;
                                $sum_sale_price = 0;
                                $sum_sale_return_price = 0;
                                $sum_loss_or_profit = 0;
                                $current_loss_or_profit = 0;

                                $productPurchaseDetails = DB::table('product_purchase_details')
                                    ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_purchases.store_id',$store->id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->get();

                                if(!empty($productPurchaseDetails)){
                                    foreach($productPurchaseDetails as $key => $productPurchaseDetail){
                                        $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                        $sum_purchase_price += $productPurchaseDetail->sub_total;

                                        // sale
                                        if($start_date != '' && $end_date != ''){
                                            $productSaleDetails = DB::table('product_sale_details')
                                                ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                                ->where('product_id',$productPurchaseDetail->product_id)
                                                ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->where('product_sale_details.created_at','>=',$custom_start_date)
                                                ->where('product_sale_details.created_at','<=',$custom_end_date)
                                                ->groupBy('product_id')
                                                ->groupBy('product_category_id')
                                                ->groupBy('product_sub_category_id')
                                                ->groupBy('product_brand_id')
                                                ->first();
                                        }else{
                                            $productSaleDetails = DB::table('product_sale_details')
                                                ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                                ->where('product_id',$productPurchaseDetail->product_id)
                                                ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                                ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                                ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                                ->groupBy('product_id')
                                                ->groupBy('product_category_id')
                                                ->groupBy('product_sub_category_id')
                                                ->groupBy('product_brand_id')
                                                ->first();
                                        }

                                        if(!empty($productSaleDetails))
                                        {
                                            $sale_total_qty = $productSaleDetails->qty;
                                            $sum_sale_price = $productSaleDetails->sub_total;
                                            $sale_average_price = $productSaleDetails->sub_total/$productSaleDetails->qty;

                                            if($sale_total_qty > 0){
                                                $loss_or_profit = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                                $current_loss_or_profit += $loss_or_profit;
                                                $sum_loss_or_profit += $loss_or_profit;
                                                //dd($sum_loss_or_profit);

                                            }
                                        }


                                    }

                                    if($start_date != '' && $end_date != ''){
                                        $discount= DB::table('product_sales')
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->where('product_sales.created_at','>=',$custom_start_date)
                                            ->where('product_sales.created_at','<=',$custom_end_date)
                                            ->first();
                                    }else{
                                        $discount= DB::table('product_sales')
                                            ->select( DB::raw('SUM(discount_amount) as total_discount_amount'))
                                            ->first();
                                    }
                                    if($discount){
                                        $sum_loss_or_profit -=$discount->total_discount_amount ;
                                        //$discount_amount = $discount->total_discount_amount;
                                        //$sum_sale_price_discount = $sum_sale_price-$discount_amount;
                                    }
                                }
                            @endphp


                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th ></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <th colspan="0">Sum Product Based Loss/Profit: </th>
                                        <th>
                                            @if($sum_loss_or_profit > 0)
                                                Profit: {{number_format($sum_loss_or_profit, 2, '.', '')}}
                                            @else
                                                Loss: {{number_format($sum_loss_or_profit, 2, '.', '')}}
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="0">Expense:</th>
                                        <th>
                                            @php
                                                if($start_date != '' && $end_date != ''){
                                                    $total_expense = \App\Expense::where('date','>=',$start_date)->where('date','<=',$end_date)->where('store_id',$store->id)->sum('amount');
                                                }else{
                                                    $total_expense = \App\Expense::where('store_id',$store->id)->sum('amount');
                                                }
                                            @endphp
                                            {{number_format($total_expense, 2, '.', '')}}
                                        </th>
                                    </tr>
                                        <th colspan="0">Final Loss/Profit:</th>
                                        <th>
                                            @if($sum_loss_or_profit > 0)
                                                Profit: {{number_format($sum_loss_or_profit - $total_expense, 2, '.', '')}}
                                            @else
                                                Loss: {{number_format($sum_loss_or_profit + $total_expense, 2, '.', '')}}
                                            @endif
                                        </th>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="tile-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>
@endsection



@push('js')

    <script src=" https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true">PDF</i>' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv fa-1x">CSV</i>' },
                    { extend: 'excel', text: '<i class="fas fa-file-excel" aria-hidden="true">EXCEL</i>' },
                    'pageLength'
                ],
            } );
        } );
    </script>
@endpush
