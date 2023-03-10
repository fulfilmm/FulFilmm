@extends('layout.mainlayout')
@section('title', 'Company')
@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col">
                    @include('layout.partials.breadcrumb',['header'=> 'Company'])
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('companies.create')}}" class="btn add-btn"><i class="fa fa-plus"></i>
                        Add Company</a>
                    <div class="view-icons">
                        <a href="{{route('companies.cards')}}" class="grid-view btn btn-white"><i class="fa fa-th"></i></a>
                        <a href="{{route('companies.index')}}" class="list-view btn btn-white active"><i class="fa fa-bars"></i></a>
                        <a href="{{route('companies.import')}}" data-toggle="modal" data-target="#import" class="btn btn-white"><i class="fa fa-upload mr-1 ml-1"></i><span class="mr-1">Import</span></a>
                        <a  data-toggle="modal" data-target="#export" class="btn btn-outline-info rounded"><i class="fa fa-download mr-1"></i>Export</a>

                    </div>
                </div>
            </div>
        </div>
        @yield('data')
    </div>
    <div id="export" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div>
                            {{--@dd($route)--}}
                            <form action="{{url('companies/export/data')}}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <label for="start">Start Date</label>
                                    <input type="text" class="form-control" id="start" name="start_date"  value="" title="Start Date" required>
                                </div>
                                <div class="form-group">
                                    <label for="end">End Date</label>
                                    <input type="text" class="form-control" id="end" name="end_date"  value="" title="End Date" required>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Export</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="import" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div>
                            {{--@dd($route)--}}
                            <form action="{{url('companies/import/data')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="start">Import File</label>
                                    <input type="file" class="form-control" id="file" name="import"  value="" required>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#start').datetimepicker();
            jQuery('#end').datetimepicker();
        });
    </script>
@endsection


