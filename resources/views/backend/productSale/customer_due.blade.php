@extends('backend._partial.dashboard')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Due Sale</h1>
            </div>
{{--            <ul class="app-breadcrumb breadcrumb">--}}
{{--                <li class="breadcrumb-item"> <a href="{!! route('productSales.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Sales</a></li>--}}
{{--            </ul>--}}
        </div>
        <div class="col-md-12">
            <div class="tile">

                <h3 class="tile-title">Customer Due</h3>
                <table id="example" class="table table-bordered table-striped">

                    <thead>
                    <tr>
                        <th width="5%">#Id</th>
                        <th>Invoice NO</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productSales as $key => $productSale)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $productSale->invoice_no}}</td>
                        <td>{{ $productSale->party->name}}</td>
                        <td>{{ $productSale->party->phone}}</td>
                        <td>{{ $productSale->total_amount}}</td>
                        <td>{{ $productSale->paid_amount}}</td>
                        <td>
                            {{ $productSale->due_amount}}
                            @if($productSale->total_amount != $productSale->paid_amount)
                                <a href="" class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#exampleModal-<?= $productSale->id;?>"> Pay Due</a>
                            @endif
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal-{{$productSale->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pay Due</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('pay.due')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="due">Enter Due Amount</label>
                                            <input type="hidden" class="form-control" name="product_sale_id" value="{{$productSale->id}}">
                                            <input type="number" class="form-control" id="due" aria-describedby="emailHelp" name="new_paid" min="" max="{{$productSale->due_amount}}" placeholder="Enter Amount">
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_type">Payment Type</label>
                                            <select name="payment_type" id="payment_type" class="form-control" required>
                                                <option value="">Select One</option>
                                                <option value="cash">cash</option>
                                                <option value="check">check</option>
                                            </select>
                                            <span>&nbsp;</span>
                                            <input type="text" name="check_number" id="check_number" class="form-control" placeholder="Check Number">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @push('js')
                                <script>
                                    $(function() {
                                        $('#check_number').hide();
                                        $('#payment_type').change(function(){
                                            if($('#payment_type').val() == 'check') {
                                                $('#check_number').show();
                                            } else {
                                                $('#check_number').val('');
                                                $('#check_number').hide();
                                            }
                                        });
                                    });
                                </script>
                            @endpush
                        </div>
                    </div>
                        @endforeach
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><b>Total Due-</b>{{$total_due}}</th>
                    </tr>
                    </tbody>


                </table>
                <div class="tile-footer">
                </div>
{{--                {{ $parties->links() }}--}}
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
