@extends('layouts.admin.app')

@section('content')

    <div>
        <h2> {{request()->approved_state== 1?'Approved':(request()->approved_state== 2? 'Unapproved':(request()->approved_state== 3?'Waiting':''))}}{{ request()->state==1?'Available':(request()->state==2?'Unavailable':'')}} {{ ' ' }}@lang('apartments.apartments')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"> {{request()->approved_state== 1?'Approved':(request()->approved_state== 2? 'Unapproved':(request()->approved_state== 3?'Waiting':''))}}{{ request()->state==1?'Available':(request()->state==2?'Unavailable':'')}}  {{ ' ' }}@lang('apartments.apartments')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <div class="row mb-2">

                    <div class="col-md-12">

                        @if (auth()->user()->hasPermission('read_apartments'))
                            <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary"><i
                                    class="fa fa-plus"></i> @lang('site.create')</a>
                        @endif

                        @if (auth()->user()->hasPermission('delete_apartments'))
                            <form method="post" action="{{ route('admin.apartments.bulk_delete') }}"
                                  style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="record_ids" id="record-ids">
                                <button type="submit" class="btn btn-danger" id="bulk-delete" disabled="true"><i
                                        class="fa fa-trash"></i> @lang('site.bulk_delete')</button>
                            </form><!-- end of form -->
                        @endif

                    </div>

                </div><!-- end of row -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="data-table-search" class="form-control" autofocus
                                   placeholder="@lang('site.search')">
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="place" class="form-control select2" required>
                                <option value="">@lang('site.all') @lang('places.places')</option>
                                @foreach ($places as $place)
                                    <option
                                        value="{{ $place->id }}" {{ $place->id == request()->place_id ? 'selected' : '' }}>{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $approveStatus = [1,2,3];
                    @endphp
                    {{--select approve states--}}
                    @if(request()->has('approved_state'))
                    @else
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="approve" class="form-control select2" required>
                                    <option value="">@lang('site.all'){{' '}}@lang('apartments.upload_status')</option>

                                    @foreach ($approveStatus as $state)
                                        <option
                                            value="{{$state}}" {{$state == request()->approved_state ? 'selected' : '' }}>{{$state==1?'Approved':($state==2?'Unapproved':'Waiting')}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    @endif
                    {{--select state--}}
                    @php
                        $availabilityStatus = [1,2];
                    @endphp
                    @if(request()->has('state'))
                    @else
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="states" class="form-control select2" required>
                                    <option value=""> @lang('site.all'){{' '}}@lang('apartments.status')</option>
                                    @foreach ($availabilityStatus as $state)
                                        <option
                                            value="{{$state}}" {{$state == request()->state ? 'selected' : '' }}>{{$state==1?'Available':'Unavailable'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                </div><!-- end of row -->
                <div class="row">

                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table datatable" id="apartments-table" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="animated-checkbox">
                                            <label class="m-0">
                                                <input type="checkbox" id="record__select-all">
                                                <span class="label-text"></span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>index</th>
                                    <th>@lang('apartments.owner')</th>
                                    <th>@lang('apartments.place')</th>
                                    <th>@lang('apartments.type')</th>
                                    <th>@lang('apartments.upload_state')</th>
                                    <th>@lang('apartments.state')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                            </table>

                        </div><!-- end of table responsive -->

                    </div><!-- end of col -->

                </div><!-- end of row -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

@push('scripts')

    <script>

        let place = '{{request()->place_id}}';
        let state = '{{request()->state}}';
        let approveState = '{{request()->approved_state}}';


        let apartmentsTable = $('#apartments-table').DataTable({
            dom: "tiplr",
            serverSide: true,
            processing: true,
            /* "language": {
                 "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },*/
            ajax: {
                url: '{{ route('admin.apartments.data') }}',
                data: function (d) {
                    d.place_id = place;
                    d.state = state;
                    d.approveState = approveState;
                }
            },
            columns: [
                {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                {data: 'DT_RowIndex', name: 'DT_RowIndex',sortable: false,},
                {data: 'owner', name: 'owner', searchable: false, sortable: false},
                {data: 'place', name: 'place', searchable: false, sortable: false},
                {data: 'type', name: 'type', width: '8%', searchable: false, sortable: false},
                {data: 'upload_state', name: 'upload_state', searchable: false, width: '11%'},
                {data: 'state', name: 'state', searchable: false, sortable: false, width: '11%'},
                {data: 'actions', name: 'actions', searchable: false, sortable: false, width: '25%'},
            ],
            order: [[3, 'desc']],
            drawCallback: function (settings) {
                $('.record__select').prop('checked', false);
                $('#record__select-all').prop('checked', false);
                $('#record-ids').val();
                $('#bulk-delete').attr('disabled', true);
            }
        });

        $('#data-table-search').keyup(function () {
            apartmentsTable.search(this.value).draw();
        })

        $('#place').on('change', function () {
            place = this.value;
            apartmentsTable.ajax.reload();
        })
        $('#approve').on('change', function () {
            approveState = this.value;
            apartmentsTable.ajax.reload();
        })
        $('#states').on('change', function () {
            state = this.value;
            apartmentsTable.ajax.reload();
        })

    </script>

@endpush
