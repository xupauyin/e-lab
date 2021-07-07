@extends('administrator.layouts.main')

@section('content')
<div class="row">

    <div class="col-lg-12 mb-4">

        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-center">DAFTAR LOG</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">IP</th>
                                <th scope="col">Browser</th>
                                <th scope="col">Method</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Status</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($log as $i => $item)
                            <tr>
                                <th scope="row">{{ $i + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->ip }}</td>
                                <td>{{ $item->browser }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->menu }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $log->links() }}
            </div>
        </div>
    </div>
</div>
@endsection