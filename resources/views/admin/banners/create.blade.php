@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('banners.banners')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">@lang('banners.banners')</a></li>
        <li class="breadcrumb-item">@lang('site.create')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.banners.store') }}  " enctype="multipart/form-data" >
                    @csrf
                    @method('post')

                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('banners.name')<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    </div>
                    {{--image--}}
                    <div class="form-group">
                        <label>@lang('users.image') <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control load-image">
                        <img src="" class="loaded-image" alt="" style="display: block; width: 200px; margin: 10px 0;">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection


