@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('apartments.apartments')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apartments.index') }}">@lang('apartments.apartments')</a>
        </li>
        <li class="breadcrumb-item">@lang('site.edit')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">
                <form method="post" action="{{ route('admin.apartments.update',$apartment->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.partials._errors')
                    <div class="row">
                        <div class="col-md-6">
                            {{--states--}}
                            <div class="row">
                                {{--approve status--}}
                                <div class="col-md-6">
                                    @php
                                        $approveStates = [1,2,3];
                                    @endphp

                                    <div class="form-group">
                                        <label>@lang('apartments.upload_state')<span
                                                class="text-danger">*</span></label>
                                        <select name="upload_state" class="form-control" required>
                                            <option
                                                value="{{$apartment->upload_state}}">{{$apartment->upload_state==1?'Approved':($apartment->upload_state==2?'Unapproved':'Waiting')}}</option>
                                            @foreach($approveStates as $state)
                                                @if($apartment->upload_state==$state)
                                                @else
                                                    <option value="{{$state}}">{{$state==1?'Approved':($state==2?'Unapproved':'Waiting')}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                </div><!-- end of col -->
                                {{--availability status--}}
                                <div class="col-md-6">
                                    @php
                                        $availabilityStates = [1,2];
                                    @endphp

                                    <div class="form-group">
                                        <label>@lang('apartments.state')<span class="text-danger">*</span></label>
                                        <select name="state" class="form-control" required>
                                            <option value="{{$apartment->state}}">{{$apartment->state==1?'Available':'Unavailable'}}</option>
                                            @foreach($availabilityStates as $state)
                                                @if($apartment->state==$state)
                                                @else
                                                    <option value="{{$state}}">{{$state==1?'Available':'Unavailable'}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                </div><!-- end of col -->
                            </div><!-- end of row -->
                            <div class="row">
                                {{--type--}}
                                <div class="col-md-6">
                                    @php
                                        $types = [1,2,3];
                                    @endphp
                                    <div class="form-group">
                                        <label>@lang('apartments.type')<span class="text-danger">*</span></label>
                                        <select name="type" class="form-control" required>
                                            <option value="{{$apartment->type}}">{{$apartment->type==1?'Apartment':($apartment->type==2?'Studio':'Roof')}}</option>
                                            @foreach($types as $type)
                                                @if($apartment->type==$type)
                                                @else
                                                    <option value="{{$type}}">{{$type==1?'Apartment':($type==2?'Studio':'Roof')}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- end of col -->
                                {{--gender--}}
                                <div class="col-md-6">
                                    @php
                                        $genders = [1,2,3];
                                    @endphp
                                    <div class="form-group">
                                        <label>@lang('apartments.gender')<span class="text-danger">*</span></label>
                                        <select name="gender" class="form-control" required>
                                            <option value="{{$apartment->gender}}">{{$apartment->gender==1?'Male':($apartment->gender==2?'Female':'For everyone')}}</option>
                                            @foreach($genders as $gender)
                                                @if($apartment->gender==$gender)
                                                @else
                                                    <option value="{{$gender}}">{{$gender==1?'Male':($gender==2?'Female':'For everyone')}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- end of col -->
                            </div><!-- end of row -->
                            {{--place--}}
                            <div class="form-group">
                                <label>@lang('apartments.place')<span class="text-danger">*</span></label>
                                <select name="place_id" class="form-control" required autofocus>
                                    <option value="{{$apartment->place->id}}">{{$apartment->place->name}}</option>
                                    --}}
                                    @foreach($places as $place)
                                        @if($apartment->place->id==$place->id)
                                        @else
                                            <option value="{{$place->id}}">{{$place->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            {{--location--}}
                            <div class="form-group">
                                <label>@lang('apartments.location')<span class="text-danger">*</span></label>
                                <textarea type="text" name="location" class="form-control"
                                          aria-label="With textarea">{{$apartment->location}}</textarea>
                            </div>
                            {{--des--}}
                            <div class="form-group">
                                <label>@lang('apartments.des')<span class="text-danger">*</span></label>
                                <textarea type="text" name="des" class="form-control"
                                          aria-label="With textarea">{{$apartment->des}}</textarea>
                            </div>
                        </div><!-- end of column -->
                        <div class="col-md-6">
                            <div class="row">
                                {{--internet--}}
                                <div class="col-md-6">
                                    @php
                                        $internetStatus = [1,2];
                                    @endphp
                                    <div class="form-group">
                                        <label>@lang('apartments.internet')<span class="text-danger">*</span></label>
                                        <select name="internet" class="form-control" required>
                                        <option value="{{$apartment->internet}}">{{$apartment->internet==1?'Available':'Unavailable'}}</option>
                                        @foreach($internetStatus as $state)
                                            @if($apartment->internet==$state)
                                            @else
                                                <option value="{{$state}}">{{$state==1?'Available':'Unavailable'}}</option>
                                            @endif
                                        @endforeach
                                            </select>
                                    </div>
                                </div><!-- end of col -->
                                {{--floor--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.floor')<span class="text-danger">*</span></label>
                                        <input type="number" name="floor" class="form-control" min="1"
                                               value="{{$apartment->floor}}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--n_rooms--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.n_rooms')<span class="text-danger">*</span></label>
                                        <input type="number" name="n_rooms" class="form-control" min="1"
                                               value="{{$apartment->n_rooms}}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--n_beds--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.n_beds')<span class="text-danger">*</span></label>
                                        <input type="number" name="n_beds" class="form-control" min="1"
                                               value="{{$apartment->n_beds}}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--n_bathroom--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.n_bathroom')<span class="text-danger">*</span></label>
                                        <input type="number" name="n_bathroom" class="form-control" min="1"
                                               value="{{$apartment->n_bathroom}}" required>
                                    </div>
                                </div><!-- end of col -->
                                {{--price--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('apartments.price')<span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control" min="1"
                                               value="{{$apartment->price}}" required>
                                    </div>
                                </div><!-- end of col -->
                            </div><!-- end of row -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-pencil"></i>@lang('site.update')</button>
                            </div>
                        </div><!-- end of column -->
                    </div><!-- end of row -->
                </form
                ><!-- end of form -->
            </div><!--end of shadow> -->
        </div><!-- end of column -->
    </div><!-- end of row -->

@endsection

