@extends('layouts/templateAdmin')
@section('title','Sistem')
@section('content-title','Sistem / Ticketing')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Ticketing</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <form action="/admin/ticketing/on-progress" method="POST" id="form-mul-onprog"
                            style="display: inline">
                            @csrf
                            @method('put')
                            <button id="btn-onprog" class="btn btn-primary  btn-labeled add-tooltip"
                                data-toggle="tooltip" data-container="body" data-placement="top"
                                data-original-title="Jadikan On Progress" onclick="submit_on_progress()">
                                <i class="btn-label fa fa-spinner"></i>
                                Jadikan On Progress
                            </button>
                            <div class="radio mar-hor" style="display: inline">
                                <label for="">Lihat Ticket Selesai: </label>
                                <input id="lihat_selesai_radio-1" class="magic-radio" type="radio" name="lihat_selesai"
                                    value="On" onclick="toogle_selesai()">
                                <label for="lihat_selesai_radio-1">On</label>
                                <input id="lihat_selesai_radio-2" class="magic-radio" type="radio" name="lihat_selesai"
                                    value="Off" checked onclick="toogle_selesai()">
                                <label for="lihat_selesai_radio-2">Off</label>
                            </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <div class="input-group mar-btm float-right">
                            <input type="text" id="cari-ticket" class="form-control"
                                placeholder="Cari Ticket Pada Posisi ON" onkeyup="search_ticket()">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <table id="masterdata-ticketing-full"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                style="width: 5%">No
                            </th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%">
                                Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Pengirim</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Kategori</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Status</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Diajukan pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketing as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">
                                {{$loop->iteration}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                            </td>
                            <td class="text-center">
                                <span id="detail_ticket" data-toggle="modal" data-target="#modal-detail-ticket"
                                    style="display: inline; margin: auto 5px" data-id="{{$row->id}}"
                                    data-name="{{$row->name}}" data-category="{{$row->category}}"
                                    data-message="{{$row->message}}" data-response="{{$row->response}}"
                                    data-status="{{$row->status}}" data-diajukan="{{indonesian_date($row->created_at,true)}}"
                                    @if ($row->created_at == $row->updated_at)
                                    data-direspon="-"
                                    @else
                                    data-direspon="{{indonesian_date($row->updated_at,true)}}"
                                    @endif
                                    >
                                    <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Detail Ticket"
                                        type="button">
                                        <i class="fa fa-info"></i>
                                    </a>
                                </span>
                            </td>
                            <td class="text-center">{{$row->name}}</td>
                            <td class="text-center">
                                @if ($row->category == 'Keluhan')
                                <span class="label label-primary">Keluhan</span>
                                @elseif ($row->category == 'Masukan')
                                <span class="label label-warning">Masukan</span>
                                @elseif ($row->category == 'Bug Aplikasi')
                                <span class="label label-danger">Bug Aplikasi</span>
                                @elseif ($row->category == 'Kesalahan Informasi')
                                <span class="label label-info">Kesalahan Informasi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($row->status == 'Dikirimkan')
                                <span class="label label-primary">Dikirimkan</span>
                                @elseif ($row->status == 'On Progress')
                                <span class="label label-warning">On Progress</span>
                                @elseif ($row->status == 'Selesai')
                                <span class="label label-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">{{indonesian_date($row->created_at,true)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table id="masterdata-ticketing"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                style="width: 5%">No
                            </th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending" style="width: 5%">
                                Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Pengirim</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Kategori</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Status</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Diajukan pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketing as $row)
                        @if($row->status == "Dikirimkan" || $row->status == "On Progress")
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">
                                {{$loop->iteration}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                            </td>
                            <td class="text-center">
                                <span id="detail_ticket" data-toggle="modal" data-target="#modal-detail-ticket"
                                    style="display: inline; margin: auto 5px" data-id="{{$row->id}}"
                                    data-name="{{$row->name}}" data-category="{{$row->category}}"
                                    data-message="{{$row->message}}" data-response="{{$row->response}}"
                                    data-status="{{$row->status}}" data-diajukan="{{indonesian_date($row->created_at,true)}}"
                                    @if ($row->created_at == $row->updated_at)
                                    data-direspon="-"
                                    @else
                                    data-direspon="{{indonesian_date($row->updated_at,true)}}"
                                    @endif
                                    >
                                    <a class="btn btn-info btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Detail Ticket"
                                        type="button">
                                        <i class="fa fa-info"></i>
                                    </a>
                                </span>
                            </td>
                            <td class="text-center">{{$row->name}}</td>
                            <td class="text-center">
                                @if ($row->category == 'Keluhan')
                                <span class="label label-primary">Keluhan</span>
                                @elseif ($row->category == 'Masukan')
                                <span class="label label-warning">Masukan</span>
                                @elseif ($row->category == 'Bug Aplikasi')
                                <span class="label label-danger">Bug Aplikasi</span>
                                @elseif ($row->category == 'Kesalahan Informasi')
                                <span class="label label-info">Kesalahan Informasi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($row->status == 'Dikirimkan')
                                <span class="label label-primary">Dikirimkan</span>
                                @elseif ($row->status == 'On Progress')
                                <span class="label label-warning">On Progress</span>
                                @elseif ($row->status == 'Selesai')
                                <span class="label label-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">{{indonesian_date($row->created_at,true)}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>
@include('masterdata/transactionticketing/detail')
@endsection
