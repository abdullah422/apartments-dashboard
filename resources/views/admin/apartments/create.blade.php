@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('apartments.apartments')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apartments.index') }}">@lang('apartments.apartments')</a>
        </li>
        <li class="breadcrumb-item">@lang('site.create')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">
                <form method="post" action="{{ route('admin.apartments.store') }}  " enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    @include('admin.partials._errors')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                {{--type--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.type')<span class="text-danger">*</span></label>
                                        <select name="type" class="form-control" required>
                                            <option value="">@lang('apartments.select_one')</option>
                                            <option value="1">Apartment</option>
                                            <option value="2">Studio</option>
                                            <option value="3">Roof</option>
                                        </select>
                                    </div></div><!-- end of col -->
                                {{--gender--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.gender')<span class="text-danger">*</span></label>
                                        <select name="gender" class="form-control">
                                            <option value="">@lang('apartments.select_one')</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                            <option value="3">For everyone</option>
                                        </select>
                                    </div>
                                </div><!-- end of col -->
                            </div><!-- end of row -->
                            {{--place--}}
                            <div class="form-group">
                                <label>@lang('apartments.place')<span class="text-danger">*</span></label>
                                <select name="place_id" class="form-control" required autofocus>
                                    <option value="">@lang('apartments.select_one')</option>
                                    @foreach($places as $place)
                                        <option value="{{$place->id}}">{{$place->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{--location--}}
                            <div class="form-group">
                                <label>@lang('apartments.location')<span class="text-danger">*</span></label>
                                <textarea type="text" name="location" class="form-control"
                                          aria-label="With textarea"> {{old('location')}}</textarea>
                            </div>
                            {{--des--}}
                            <div class="form-group">
                                <label>@lang('apartments.des')<span class="text-danger">*</span></label>
                                <textarea type="text" name="des" class="form-control"
                                          aria-label="With textarea"> {{old('des')}}</textarea>
                            </div>

                        </div><!-- end of column -->
                        <div class="col-md-6">
                            <div class="row">
                                {{--internet--}}
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label>@lang('apartments.internet')<span class="text-danger">*</span></label>
                                       <select name="internet" class="form-control" required>
                                           <option value="">@lang('apartments.select_one')</option>
                                           <option value="1">Available</option>
                                           <option value="2">Unavailable</option>
                                       </select>
                                   </div>
                               </div><!-- end of col -->
                                {{--floor--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('apartments.floor')<span class="text-danger">*</span></label>
                                        <input type="number" name="floor" class="form-control" min="1" max="6"
                                               value="{{ old('floor') }}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--n_rooms--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('apartments.n_rooms')<span class="text-danger">*</span></label>
                                        <input type="number" name="n_rooms" class="form-control" min="1"
                                               value="{{ old('n_rooms') }}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--n_beds--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('apartments.n_beds')<span class="text-danger">*</span></label>
                                        <input type="number" name="n_beds" class="form-control" min="1"
                                               value="{{ old('n_beds') }}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--n_bathroom--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('apartments.n_bathroom')<span class="text-danger">*</span></label>
                                        <input type="number" name="n_bathroom" class="form-control" min="1"
                                               value="{{ old('n_bathroom') }}" required>
                                    </div>
                                </div><!-- end of col -->

                                {{--price--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('apartments.price')<span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control" min="1"
                                               value="{{ old('price') }}" required>
                                    </div>

                                </div><!-- end of col -->
                            </div><!-- end of row -->


                            {{--images--}}
                            <div class="form-group">
                                <label for="files" class="form-label">Upload apartment images<span class="text-danger"> *</span></label>
                                <input
                                    type="file"
                                    name="images[]"
                                    class="form-control"
                                    accept="image/*"
                                    multiple
                                >
                            </div>
                            {{--button--}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>@lang('site.create')</button>
                            </div>
                        </div><!-- end of column -->
                    </div><!-- end of row -->
                </form
                ><!-- end of form -->
            </div><!--end of shadow> -->
        </div><!-- end of column -->
    </div><!-- end of row -->


@endsection


