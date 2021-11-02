@extends('backend._partial.dashboard')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <main class="app-content">
        <div class="col-md-12">

            @if(session('response'))
                <div class="alert alert-success">
                    {{ session('response') }}
                </div>
            @endif


            <div class="tile">
                {{--<h3 class="tile-title">Accounts</h3>--}}
                <div class="col-sm-4" style="width: 33.33333333%;height:180px; float: left;">
                    <h2>Hasan Fashion</h2>
                    <p style="margin: 0px"> Hasan Fashion, Jahan Mansion (1st Floor)</p>
                    <p style="margin: 0px">  29 Mirpur Road,(opposite of Teachers Training College)</p>
                    <p style="margin: 0px"> Dhaka-1205Bangladesh</p>
                </div>

                <div class="col-sm-4" style="text-align: center; width: 33.33333333%; float: left;">
                    <h2>Party Balance</h2>
                </div>
                <div class="col-sm-4" style="text-align: right; width: 33.33333333%; float: left;">
                    From Date : {{ $date_from }}
                    <br/>
                    To Date : {{ $date_to }}
                    <br>
{{--                    Account Name : {{ \App\Account::where('HeadCode', $general_ledger)->pluck('HeadName')->first() }}--}}
                </div>
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="10%">Date</th>
                        <th width="10%">party name</th>
                        <th width="12%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $sum_debit = 0;
                        $sum_credit = 0;
                        $final_debit_credit = 0;
                        $flag = 0;
                        $first_day = date('Y-m-01',strtotime($date_to));
                        $last_day = date('Y-m-t',strtotime($date_from));
                    @endphp
{{--                    @if($PreBalance > 0)--}}
{{--                        @php--}}
{{--                            if( ($PreBalance > 0) && ($preDebCre == 'De') )--}}
{{--                            {--}}
{{--                                $pre_particulars = "To balance b/d (Previous Balance)";--}}
{{--                                $sum_debit += $PreBalance;--}}
{{--                            }else{--}}
{{--                                $pre_particulars = "By balance b/d (Previous Balance)";--}}
{{--                                $sum_credit += $PreBalance;--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        <tr style="background-color: red">--}}
{{--                            <td>{{ $first_day }}</td>--}}
{{--                            <td>{{ $pre_particulars }}</td>--}}
{{--                            <td>{{ $preDebCre == 'De' ? number_format($PreBalance,2,'.',',') : '' }}</td>--}}
{{--                            <td>{{ $preDebCre == 'Cr' ? number_format($PreBalance,2,'.',',') : '' }}</td>--}}
{{--                            <td>{{ number_format($PreBalance,2,'.',',') }} {{ $preDebCre }}</td>--}}
{{--                        </tr>--}}
{{--                    @endif--}}
                    @foreach($total_amounts as $key => $total_amount)
{{--                        @php--}}
{{--                            $debit = $general_ledger_info->debit;--}}
{{--                            $credit = $general_ledger_info->credit;--}}

{{--                            $sum_debit  += $debit;--}}
{{--                            $sum_credit += $credit;--}}

{{--                            if($debit > $credit)--}}
{{--                                $curRowDebCre = 'De';--}}
{{--                            else--}}
{{--                                $curRowDebCre = 'Cr';--}}

{{--                            //dd($preDebCre);--}}

{{--                            if($preDebCre == 'De/Cr' && $flag == 0)--}}
{{--                            {--}}
{{--                                $preDebCre = $curRowDebCre;--}}
{{--                                $flag = 1;--}}
{{--                            }--}}

{{--                            if($preDebCre == 'De' && $curRowDebCre == 'De')--}}
{{--                            {--}}
{{--                                /*if($PreBalance > $debit)--}}
{{--                                {--}}
{{--                                    $PreBalance = $PreBalance - $debit;--}}
{{--                                }else{--}}
{{--                                    $PreBalance = $debit - $PreBalance;--}}
{{--                                }*/--}}
{{--                                $PreBalance += $debit;--}}
{{--                                $preDebCre = 'De';--}}
{{--                            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){--}}
{{--                                if($PreBalance > $credit)--}}
{{--                                {--}}
{{--                                    $PreBalance = $PreBalance - $credit;--}}
{{--                                    $preDebCre = 'De';--}}
{{--                                }else{--}}
{{--                                    $PreBalance = $credit - $PreBalance;--}}
{{--                                    $preDebCre = 'Cr';--}}
{{--                                }--}}
{{--                            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){--}}
{{--                                if($PreBalance > $debit)--}}
{{--                                {--}}
{{--                                    $PreBalance = $PreBalance - $debit;--}}
{{--                                    $preDebCre = 'Cr';--}}
{{--                                }else{--}}
{{--                                    $PreBalance = $debit - $PreBalance;--}}
{{--                                    $preDebCre = 'De';--}}
{{--                                }--}}
{{--                            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){--}}
{{--                                /*if($PreBalance > $credit)--}}
{{--                                {--}}
{{--                                    $PreBalance = $PreBalance - $credit;--}}
{{--                                }else{--}}
{{--                                    $PreBalance = $credit - $PreBalance;--}}
{{--                                }*/--}}
{{--                                $PreBalance += $credit;--}}
{{--                                $preDebCre = 'Cr';--}}
{{--                            }else{--}}

{{--                            }--}}

{{--                        @endphp--}}
                        <tr>
                            <td>{{ $total_amount->date }}</td>
                            <td> @php
                               echo $party = \Illuminate\Support\Facades\DB::table('parties')
                                                                ->join('product_purchases','parties.id','=','product_purchases.party_id')
                                                                ->where('product_purchases.party_id',$total_amount->party_id)
                                                                 ->pluck('parties.name')
                                                                ->first();
                            @endphp
                            </td>
                            <td>{{ $total_amount->total_amount }}</td>

                        </tr>
                    @endforeach
{{--                    @if($sum_debit !=$sum_credit)--}}
{{--                        @php--}}
{{--                            if($sum_debit > $sum_credit)--}}
{{--                            {--}}
{{--                                $final_debit_credit = $sum_debit;--}}
{{--                                $particulars = "By balance c/d (Final Balance)";--}}
{{--                            }else{--}}
{{--                                $final_debit_credit = $sum_credit;--}}
{{--                                $particulars = "To balance c/d (Final Balance)";--}}
{{--                            }--}}

{{--                        @endphp--}}
{{--                        <tr style="background-color: red">--}}
{{--                            <td>{{ $last_day }}</td>--}}
{{--                            <td>{{ $particulars }}</td>--}}
{{--                            <td>&nbsp;</td>--}}
{{--                            <td>&nbsp;</td>--}}
{{--                            <td>{{ $sum_credit > $sum_debit ? number_format($PreBalance,2,'.',',') : '' }}</td>--}}
{{--                            <td>{{ $sum_debit > $sum_credit ? number_format($PreBalance,2,'.',',') : '' }}</td>--}}
{{--                            <td>&nbsp;</td>--}}
{{--                        </tr>--}}
{{--                    @endif--}}
{{--                    <tr>--}}
{{--                        <td></td>--}}
{{--                        <td></td>--}}
{{--                        <td></td>--}}
{{--                        <td align="right">Total</td>--}}
{{--                        <td>{{ number_format($final_debit_credit,2,'.',',') }}</td>--}}
{{--                        <td>{{ number_format($final_debit_credit,2,'.',',') }}</td>--}}
{{--                        <td>{{ number_format($sum_debit,2,'.',',') }}</td>--}}
{{--                        <td>{{ number_format($sum_credit,2,'.',',') }}</td>--}}
{{--                        <td>&nbsp;</td>--}}
{{--                    </tr>--}}
                    </tbody>
                </table>
                </div>
            </div>
{{--                <div class="text-center">--}}
{{--                    <a href="{{ url('account/general-ledger-print/'.$general_ledger.'/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
{{--                </div>--}}
        </div>
    </main>

@endsection

@section('footer')

    <script src="{{asset('js/form.js')}}"></script>

    {{--<script>--}}
    {{--$('#create-form').function({--}}
    {{--formReset: false,--}}
    {{--redirectPath: location.href,--}}
    {{--});--}}
    {{--</script>--}}
@section('other')
    <script>
        // $('button').load(function(){
        //     $('submit').modal('show');
        //  });

        $("form").on('submit', function(){
            $('.modal').show();
        })
    </script>
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
