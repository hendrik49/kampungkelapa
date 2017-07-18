@extends('layout')
@section('header')
<div class="page-header">
        <h1>MasterDatas / Show #{{$master_datum->id}}</h1>
        <form action="{{ route('master_datas.destroy', $master_datum->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-warning btn-group" role="group" href="{{ route('master_datas.edit', $master_datum->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
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
                     <label for="id">ID</label>
                     <p class="form-control-static">{{$master_datum->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="imei">IMEI</label>
                     <p class="form-control-static">{{$master_datum->imei}}</p>
                </div>
                    <div class="form-group">
                     <label for="created_at">CREATED_AT</label>
                     <p class="form-control-static">{{$master_datum->created_at}}</p>
                </div>
                    <div class="form-group">
                     <label for="updated_at">UPDATED_AT</label>
                     <p class="form-control-static">{{$master_datum->updated_at}}</p>
                </div>
                    <div class="form-group">
                     <label for="click">CLICK</label>
                     <p class="form-control-static">{{$master_datum->click}}</p>
                </div>
                    <div class="form-group">
                     <label for="view">VIEW</label>
                     <p class="form-control-static">{{$master_datum->view}}</p>
                </div>
                    <div class="form-group">
                     <label for="type_device">TYPE_DEVICE</label>
                     <p class="form-control-static">{{$master_datum->type_device}}</p>
                </div>
                    <div class="form-group">
                     <label for="language">LANGUAGE</label>
                     <p class="form-control-static">{{$master_datum->language}}</p>
                </div>
                    <div class="form-group">
                     <label for="state">STATE</label>
                     <p class="form-control-static">{{$master_datum->state}}</p>
                </div>
                    <div class="form-group">
                     <label for="regional">REGIONAL</label>
                     <p class="form-control-static">{{$master_datum->regional}}</p>
                </div>
            </form>

            <a class="btn btn-link" href="{{ route('master_datas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

        </div>
    </div>

@endsection