@extends('admin')

@section('content')
<div class="row align-items-center" style="height:100%;">
    <div class="col">
        <?= Form::open(['url' => 'admin/auth', 'method' => 'post']) ?>
        <div class="row justify-content-center align-items-center">

            <div class="col-sm-3 col-12">
                <div class="form-group">
                    <?= Form::text('login', old('login'), ['class' => 'form-control', 'placeholder' => 'login']) ?>
                </div>
                <div class="form-group">
                    <?= Form::password('password', ['class' => 'form-control', 'placeholder' => 'haslo']) ?>
                </div>
                <input type="submit" class="btn btn-success">
            </div>

        </div>
        <?= Form::close() ?>
    </div>
</div>
@endsection