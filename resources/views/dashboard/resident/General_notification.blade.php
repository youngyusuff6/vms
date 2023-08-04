@extends('layouts.resident')
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
                            @if ($DATA_AVAILABILITY > 0)
                                <ul>
                                    @foreach ($NOTIFICATION_DESCRIPTIONS as $data)
                                        <li>
                                            <div>
                                                <div class="media-body">
                                                    <a class="link-effect" href="{{ NOTIFICATION_PIPELINE_TO_ROUTE_CONVERTER($data->notification_controller_pipeline) }}">
                                                        <h6>{{ $data->notification_description }}</h6>
                                                    </a>
                                                    <small>{{ MSQL_Timestamp_toHuman_Readable_Format($data->created_at) }}</small>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="d-flex justify-content-center mt-4 mb-3 h2"> No Notification Available. </div>
                            @endif
                            {{-- Pagination --}}
                            @if (($DATA_AVAILABILITY > 0) && ($EXTRA_DATAS['total_number_Of_Rows'] > 10))
                                <div class="d-flex justify-content-end dataTables_paginate mt-4" id="example_paginate">
                                    <nav>
                                        <ul class="pagination pagination-circle">
                                            {{-- Previous page --}}
                                            @if ($EXTRA_DATAS['PAGINATION_ACTING_INDEX'] > 1)
                                                <li class="page-item page-indicator">
                                                    <a class="page-link" href="{{ $EXTRA_DATAS['previous_page_link'] }}">
                                                        <i class="la la-angle-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Next page --}}
                                            @if ($EXTRA_DATAS['PAGINATION_SECTIONS_COUNT'] != $EXTRA_DATAS['PAGINATION_ACTING_INDEX'])
                                                <li class="page-item page-indicator">
                                                    <a class="page-link" href="{{ $EXTRA_DATAS['next_page_link'] }}">
                                                        <i class="la la-angle-right"></i>
                                                    </a>
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
