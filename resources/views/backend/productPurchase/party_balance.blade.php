@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i>Party Balance</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Party Balance</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('party_balance.show') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Party</label>
                            <div class="col-md-3">
                                <select class="form-control select2" name="party_id" id="party_id">
                                    <option value="">Select One</option>
                                    @foreach($productPurchases as $productPurchase)
                                        <option value="{{ $productPurchase->party_id }}">{{$productPurchase->party->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('general_ledger'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('general_ledger') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">From</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_from" required>
                                @if ($errors->has('date_from'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_from') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">To</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_to" required>
                                @if ($errors->has('date_to'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_to') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>View
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
    <!-- select2-->
    <script src="{!! asset('backend/js/plugins/select2.min.js') !!}"></script>
{{--    <script>--}}
{{--        $('.select2').select2();--}}

{{--        $(document).ready(function(){--}}
{{--            $('#general_ledger').change(function(){--}}
{{--                var general_ledger = $('#general_ledger').val();--}}
{{--                /*console.log(general_ledger);*/--}}

{{--                $.ajax({--}}
{{--                    url : "{{ URL('/get-transaction-head') }}/"+general_ledger,--}}
{{--                    method : 'get',--}}
{{--                    success : function(data){--}}
{{--                        /*console.log(data);*/--}}
{{--                        $('#transaction_head').html(data.response);--}}
{{--                        $('#transaction_head').show();--}}
{{--                    }--}}
{{--                });--}}
{{--            })--}}
{{--        });--}}
{{--    </script>--}}
@endsection


