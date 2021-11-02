@extends('backend._partial.dashboard')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Expenses</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('expenses.create') !!}" class="btn btn-sm btn-primary" type="button">Add Expenses</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">

                <h3 class="tile-title">Expenses Table</h3>
                <form class="form-inline" action="{{ route('expenses.index') }}">
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
                        <a href="{!! route('expenses.index') !!}" class="btn btn-primary" type="button">Reset</a>
                    </div>
                </form>
                <div>&nbsp;</div>
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">#Id</th>
                        <th>Office Costing Category</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $key => $expense)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $expense->office_costing_category->name}}</td>
                        <td>
                            {{ $expense->payment_type}}
                            @if($expense->payment_type == 'check')
                                ({{ $expense->check_number}})
                            @endif
                        </td>
                        <td>{{ $expense->amount}}</td>
                        <td>{{ $expense->created_at}}</td>
                        <td>
{{--                            <a href="{{ route('expenses.show',$expense->id) }}" class="btn btn-sm btn-info float-left">Show</a>--}}
                            <a href="{{ route('expenses.edit',$expense->id) }}" class="btn btn-sm btn-primary float-left"><i class="fa fa-edit"></i></a>
                            <form method="post" action="{{ route('expenses.destroy',$expense->id) }}" >
                               @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('You Are Sure This Delete !')"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                    <div class="tile-footer">
                    </div>
                </div>
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


