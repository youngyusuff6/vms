@if (Auth::user()->role !== "resident")
    {{-- IMPORT THE DASHBOARD MAIN HEADER VIEW FOR STUDENT HERE --}}
    @extends('layouts.student')
@else
    {{-- IMPORT THE DASHBOARD MAIN HEADER VIEW FOR RESIDENTS HERE --}}
    @extends('layouts.resident')
@endif

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-lg-12">
                <div class="widget-stat mb-3 rounded-0">
                    <div class="card-header pb-3 pt-3 mt-0 mb-0">
                        <h4 class="card-title">All Notifications</h4>
                    </div>
                    <div class="card-body">
                        <style>
                            .link-effect:hover {
                                text-decoration: underline;
                            }
                        </style>
                        <div id="DZ_W_Notification1" class="widget-media dlab-scroll p-3">
                            @php
                                $DATA_AVAILABILITY = count($NOTIFICATION_DESCRIPTIONS);
                            @endphp
                            <ul class="timeline">
                                @if ($DATA_AVAILABILITY > 0)
                                    {{-- LAUNCH A FOREACH LOOP TO BE USED TO LOOP THROUGH ALL EXPERIENCE OF USER.  --}}
                                    @foreach ($NOTIFICATION_DESCRIPTIONS as $data)
                                        <li>
                                            <div class="timeline-panel">
                                                @if ($data->action_initiator_id)
                                                    <div class="media me-2 rounded-circle">
                                                        <img alt="image" width="50" class="rounded-circle img-thumbnail">
                                                    </div>
                                                @endif
                                                <div class="media-body">
                                                    <a class="link-effect" href="{{ NOTIFICATION_PIPELINE_TO_ROUTE_CONVERTER($data->notification_controller_pipeline) }}">
                                                        <h6 class="mb-1">{{ $data->notification_description }}</h6>
                                                    </a>
                                                    <small class="d-block">{{ MSQL_Timestamp_toHuman_Readable_Format($data->created_at) }}</small>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center mt-4 mb-3 h2"> No Notification Available. </div>
                                @endif
                            </ul>
                            {{-- HERE WE SET UP THIS CONSTRUCT TO ENSURE THAT OUR PAGINATION ONLY APPEARS WHEN AND ONLY WHEN WE ARE SURE THE DATABASE RETURNED
                                DATA AND THAT THE NUMBER OF DATA RETURNED BY THE DATABASE IS NOT GREATER THAN THE ALLOWABLE-NUMBER OF ENTRIES THAT THIS APP
                                HAS BEEN CONFIGURED TO SHOW PER PAGE (E.G DATABASE RETURNED 12 ROWS AND APP CONFIGURED TO SHOW 15 ENTRIES ON THIS TABLE PER PAGE
                                THIS PAGINATION WILL NOT SHOW IN THIS CONDITIONS ) --}}
                            @if (($DATA_AVAILABILITY > 0) && ($EXTRA_DATAS['total_number_Of_Rows'] > 10))
                                <div class="d-flex justify-content-end dataTables_paginate mt-4" id="example_paginate">
                                    <nav>
                                        <ul class="pagination pagination-circle">
                                            {{-- WE SET UP THIS CLAUSE TO DETECT WHEN USER IS ON THE FIRST PAGE AND HENCE CONTROL THE NEXT BUTTON NOT TOSHOW
                                                UNDER THIS CONDITIONS --}}
                                            @if ($EXTRA_DATAS['PAGINATION_ACTING_INDEX'] > 1)
                                                <li class="page-item page-indicator"><a class="page-link" href="{{ $EXTRA_DATAS['previous_page_link'] }}">
                                                    <i class="la la-angle-left"></i></a>
                                                </li>
                                            @endif

                                            {{-- WE SET UP THIS CLAUSE TO DETECT WHEN USER IS ON THE LAST PAGE AND HENCE CONTROL THE NEXT BUTTON NOT TOSHOW
                                                UNDER THIS CONDITIONS --}}
                                            @if ($EXTRA_DATAS['PAGINATION_SECTIONS_COUNT'] != $EXTRA_DATAS['PAGINATION_ACTING_INDEX'])
                                                <li class="page-item page-indicator"><a class="page-link" href="{{ $EXTRA_DATAS['next_page_link'] }}">
                                                    <i class="la la-angle-right"></i></a>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
