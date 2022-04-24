@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('banners.banners')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">@lang('banners.banners')</a></li>
        <li class="breadcrumb-item">@lang('site.edit')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.banners.update', $banner->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('banners.name')<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $banner->name) }}"
                               required autofocus>
                    </div>

                    {{--image--}}
                    <div class="form-group" enctype="multipart/form-data">
                        <label>@lang('users.image') <span class="text-danger">*</span></label>
                        <input type="file" name="image" value="{{$banner->image}}" class="form-control load-image">
                        <img src="{{$banner->image_path }}" class="loaded-image" alt=""
                             style="display: block; width: 200px; margin: 10px 0;">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.update')
                        </button>
                    </div>
                </form><!-- end of form -->
            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

