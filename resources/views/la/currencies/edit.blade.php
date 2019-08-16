@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/currencies') }}">@lang('messages.Currency')</a> :
@endsection
@section("contentheader_description", $currency->$view_col)
@section("section", trans("messages.Currencies"))
@section("section_url", url(config('laraadmin.adminRoute') . '/currencies'))
@section("sub_section", trans("messages.Edit"))

@section("htmlheader_title", "Currencies Edit : ".$currency->$view_col)

@section("main-content")

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-success">
        <div class="box-header">

        </div>
        <div class="box-body">
            <div class="row">

                {!! Form::model($currency, ['route' => [config('laraadmin.adminRoute') . '.currencies.update', $currency->id ], 'method'=>'PUT', 'id' => 'currency-edit-form']) !!}
                {{--@ la_form($module) --}}


                @la_edit_input($module, 'currency_name')
                @la_edit_input($module, 'currency_code')
                @la_edit_input($module, 'tk_convert_amount')
                @la_edit_input($module, 'min_donate_amount')
                @la_edit_input($module, 'max_donate_amount')
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="paypal">Paypal</label>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2" name="paypal" id="paypal">
                            <option @if($currency->paypal == 0) selected @endif value="0">Not used in paypal</option>
                            <option @if($currency->paypal == 1) selected @endif value="1">Used in paypal</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::submit( Lang::get('messages.Update'), ['class'=>'btn btn-success']) !!} <a
                                class="btn btn-default"
                                href="{{ url(config('laraadmin.adminRoute') . '/currencies') }}">@lang('messages.Cancel')</a>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(function () {
        $("#currency-edit-form").validate({});
    });
</script>
@endpush
