@extends('layouts/templateAdmin')
@section('title','Sistem / Sistem Achievement')
@section('content-title','Achievement Scoring')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')

<div class="panel">
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">

    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Pemberian Nilai Penghargaan Karyawan</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                @if (session('status'))
                <div class="alert alert-info alert-dismissable">
                    <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                    {{session('status')}}
                </div>
                @endif
                <div class="row">
                    
                    <div class="col-sm-7"></div>
                    {{-- <div class="col-sm-3 hidden">
                        <div class="form-group float-right">
                            <input type="text" name="cari-divisi" id="cari-divisi" class="form-control"
                                placeholder="Cari Divisi" />
                        </div>
                    </div> --}}
                </div>
                
                <form action="/admin/achievement/scoring" method="post">
                    @csrf
                    <select class="selectpicker" data-style="btn-success" style="width: 100%" name="month" >
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="juli">juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                    <input type="text" name="year" >
                <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                   
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                No</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Karyawan</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Penilaian Karyawan </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Value </th>
                                
                            </tr>
                    </thead>
                    <tbody>
                            <input type="hidden" name="count" value="{{count($data)}}" >
                        @foreach ($data as $item)
                        
                        <tr>
                            <input type="hidden" name="user_id_{{$loop->iteration}}" value="{{$item->id}}">
                            <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                            {{-- <td tabindex="0" class="sorting_1 text-center">{{$row->id}}</td> --}}
                            <td class="text-center">{{$item->name}}</td>
                            

                            <td class="text-center">
                                <input type="range" class="form-range" min="0" max="100" id="customRange_{{$loop->iteration}}" name="score_{{$loop->iteration}}" value="0" oninput="slidervalfunc()">     
                                <input type="hidden" name="id-{{$item->id}}" value="{{$item->id}}">
                            </td>
                            <td>
                               <span id="val_{{$loop->iteration}}"></span>
                            </td>
                        </tr>
                        @endforeach
                    
                        
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit">Tambah</button>
    </div>
</form>
</div>
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>

   <script>   
   
   function slidervalfunc(){
        var tr = document.getElementsByTagName('tr');
        for (i = 1; i<tr.length;i++){
    
            var output = document.getElementById('val_'+i)
            var slider= document.getElementById('customRange_' + i)
                console.log(slider.value)
                output.innerHTML = slider.value + '/100'
            
            }
            
        
    }
//    </script>
@endsection