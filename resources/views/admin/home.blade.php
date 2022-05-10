@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('site.home')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item">@lang('site.home')</li>
    </ul>

    <div class="row">

        <div class="col-md-12 mt-2">

            {{--top statistics--}}
            <div class="row" id="top-statistics">
                {{--<div class="col-md-4">
                    <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                        <div class="info">
                            <h4>Users </h4>
                            <p><b>5</b></p>
                        </div>
                    </div>
                </div>--}}
                {{--users--}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3"><span class="fa fa-users px-1"></span>@lang('users.users')</h5>
                                <a href="{{ route('admin.users.index') }}">@lang('site.show_all')</a>
                            </div>
                            <div class="loader loader-sm"></div>
                            <h2 class="mb-0" id="users-count" style="display: none"></h2>
                        </div>

                    </div>

                </div><!-- end of col -->
                {{--owners--}}
                <div class="col-md-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-male "></span> @lang('owners.owners')</h5>
                                <a href="{{ route('admin.owners.index') }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="owners-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->
                {{--places--}}
                <div class="col-md-4">

                    <div class="card">

                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-map-marker"></span> @lang('places.places')</h5>
                                <a href="{{ route('admin.places.index') }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="places-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->

                {{--approved--}}
                <div class="col-md-4 mt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-check mx-1"></span>@lang('apartments.approved') @lang('apartments.apartments')</h5>
                                <a href="{{ route('admin.apartments.index',['approved_state' =>1]) }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="approved-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->

                {{--waiting--}}
                <div class="col-md-4 mt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-clock-o mx-1"></span>@lang('apartments.waiting') @lang('apartments.apartments')</h5>
                                <a href="{{ route('admin.apartments.index',['approved_state' =>3]) }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="waiting-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->

                {{--unapproved--}}
                <div class="col-md-4 mt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-times mx-1"></span>@lang('apartments.unapproved') @lang('apartments.apartments')</h5>
                                <a href="{{ route('admin.apartments.index',['approved_state' =>2]) }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="unapproved-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->

                {{--available--}}
                <div class="col-md-4 mt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-check mx-1"></span>@lang('apartments.available') @lang('apartments.apartments')</h5>
                                <a href="{{ route('admin.apartments.index',['state' =>1]) }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="available-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->

                {{--unavailable--}}
                <div class="col-md-4 mt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-times mx-1"></span>@lang('apartments.unavailable') @lang('apartments.apartments')</h5>
                                <a href="{{ route('admin.apartments.index',['state' =>2]) }}">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="unavailable-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->

                {{--images--}}
                <div class="col-md-4 mt-4">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="mb-3 "><span class="fa fa-picture-o mx-1"></span>Images</h5>
                                <a href="#">@lang('site.show_all')</a>
                            </div>

                            <div class="loader loader-sm"></div>

                            <h3 class="mb-1" id="images-count" style="display: none;"></h3>
                        </div>

                    </div>

                </div><!-- end of col -->


            </div><!-- end of row -->

        </div><!-- end of col -->

    </div><!-- end of row -->
@endsection

@push('scripts')

    <script>

        $(function () {

            topStatistics();


        });

        function topStatistics() {
            $.ajax({
                url: "{{ route('admin.home.top_statistics') }}",
                cache: false,
                success: function (data) {

                    $('#top-statistics .loader-sm').hide();

                    $('#top-statistics #users-count').show().text(data.users_count);
                    $('#top-statistics #owners-count').show().text(data.owners_count);
                    $('#top-statistics #places-count').show().text(data.places_count);
                    $('#top-statistics #approved-count').show().text(data.approved_count);
                    $('#top-statistics #waiting-count').show().text(data.waiting_count);
                    $('#top-statistics #unapproved-count').show().text(data.unapproved_count);
                    $('#top-statistics #available-count').show().text(data.available_count);
                    $('#top-statistics #unavailable-count').show().text(data.unavailable_count);
                    $('#top-statistics #images-count').show().text(data.images_count);

                },

            });//end of ajax call
        }

    </script>
@endpush
