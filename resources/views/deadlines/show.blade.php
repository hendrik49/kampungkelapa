@extends('layout')
@section('header')
<div class="page-header">
        <h1>Deadlines / Show #{{$deadline->id}}</h1>
        <form action="{{ route('deadlines.destroy', $deadline->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-warning btn-group" role="group" href="{{ route('deadlines.edit', $deadline->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <button type="submit" class="btn btn-danger">Delete <i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group">
                    <label for="nome">ID</label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group">
                     <label for="tahun_anggaran">TAHUN_ANGGARAN</label>
                     <p class="form-control-static">{{$deadline->tahun_anggaran}}</p>
                </div>
                    <div class="form-group">
                     <label for="triwulan_1">TRIWULAN_1</label>
                     <p class="form-control-static">{{$deadline->triwulan_1}}</p>
                </div>
                    <div class="form-group">
                     <label for="triwulan_2">TRIWULAN_2</label>
                     <p class="form-control-static">{{$deadline->triwulan_2}}</p>
                </div>
                    <div class="form-group">
                     <label for="triwulan_3">TRIWULAN_3</label>
                     <p class="form-control-static">{{$deadline->triwulan_3}}</p>
                </div>
                    <div class="form-group">
                     <label for="triwulan_4">TRIWULAN_4</label>
                     <p class="form-control-static">{{$deadline->triwulan_4}}</p>
                </div>
            </form>

            <a class="btn btn-link" href="{{ route('deadlines.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

        </div>
    </div>

@endsection