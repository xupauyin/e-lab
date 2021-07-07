@extends('administrator.layouts.main')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">@yield('page')</h1>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
        @include ('administrator.layouts.alert')
            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">EDIT USER</h6>
                </div>
                <div class="card-body">
                
                    <form method="POST" action="{{ route('administrator.update_user', $user->id) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama User</label>
                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name" autofocus>
                                
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipe_user" class="col-sm-2 col-form-label">Tipe User</label>

                            <div class="col-md-10">
                                <select class="form-control @error('role') is-invalid @enderror" name="role" id="tipe_user">
                                    <option value="koordinator"  @if($user->role == 'koordinator') selected @endif>Koordinator</option>
                                    <option value="laboran"  @if($user->role == 'laboran') selected @endif>Laboran</option>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="laboratorium" class="col-sm-2 col-form-label">Laboratorium</label>

                            <div class="col-md-10">
                                <select class="form-control @error('laboratorium') is-invalid @enderror" name="laboratorium" id="laboratorium">
                                    @foreach ($laboratorium as $l)
                                    <option value="{{ $l->laboratorium_id }}"  @if($user->laboratorium_id == $l->laboratorium_id) selected @endif>{{ $l->nama_laboratorium }}</option>
                                    @endforeach
                                </select>

                                @error('laboratorium')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">E-mail</label>
                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}"  autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                            <div class="col-md-10">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection