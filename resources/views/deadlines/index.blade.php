@include('layouts.header')

<div class="content-wrapper">

    <section class="content-header">
        <div class="page-header clearfix">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Tenggat Waktu Pengisian
                <a class="btn btn-success pull-right" href="{{ route('deadlines.create') }}"><i class="glyphicon glyphicon-plus"></i> Tambahkan</a>
            </h1>

        </div>
    </section>

    <section class="content">
        
        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif        
        
        <div class="row">
            <div class="col-md-12">
                @if($deadlines->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle">TAHUN ANGGARAN</th>
                            <th colspan="4" style="text-align: center">TENGGAT WAKTU</th>
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                            <th>TRIWULAN I</th>
                            <th>TRIWULAN II</th>
                            <th>TRIWULAN III</th>
                            <th>TRIWULAN IV</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($deadlines as $deadline)
                        <tr>
                            <td>{{$deadline->tahun_anggaran}}</td>
                            <td>{{Carbon\Carbon::parse($deadline->triwulan_1)->format('d-m-Y')}}</td>
                            <td>{{Carbon\Carbon::parse($deadline->triwulan_2)->format('d-m-Y')}}</td>
                            <td>{{Carbon\Carbon::parse($deadline->triwulan_3)->format('d-m-Y')}}</td>
                            <td>{{Carbon\Carbon::parse($deadline->triwulan_4)->format('d-m-Y')}}</td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-warning" href="{{ route('deadlines.edit', $deadline->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                <form action="{{ route('deadlines.destroy', $deadline->id) }}" method="POST" style="display: inline;" onsubmit="if (confirm('Hapus data ini secara permanen?')) {
                                            return true
                                        } else {
                                            return false
                                        }
                                        ;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $deadlines->render() !!}
                @else
                <h3 class="text-center alert alert-info">Tidak ada data</h3>
                @endif

            </div>
        </div>

    </section>

</div>    

@include('layouts.footer') 

</body>
</html>