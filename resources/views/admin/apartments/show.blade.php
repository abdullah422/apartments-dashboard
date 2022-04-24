@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('apartments.apartments')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apartments.index') }}">@lang('apartments.apartments')</a></li>
        <li class="breadcrumb-item">@lang('site.show')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">
            <div class="tile shadow">
            </div><!--end of shadow> -->
        </div><!-- end of column -->
    </div><!-- end of row -->

@endsection


