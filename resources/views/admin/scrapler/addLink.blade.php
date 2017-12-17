
@extends('admin')
@section('content')
<h2>Dodaj link</h2>
<a href="admin/scrapler/projects">wróć</a>

<?= Form::open(['url' => 'admin/scrapler/link/add-link/'.$id, 'method' => 'post']) ?>
<div class="row">
    <div class="col-sm-6 col-12">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon3"><?=$project_domain;?></span>
                <?= Form::text('url', old('url'), ['class' => 'form-control', 'placeholder' => 'link', 'aria-describedby' => 'basic-addon3']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Form::text('refersto', old('refersto'), ['class' => 'form-control', 'placeholder' => 'strona docelowa']) ?>
        </div>
        <div class="form-group">
            <?= Form::text('anchor', old('anchor'), ['class' => 'form-control', 'placeholder' => 'anchor']) ?>
        </div>
        <input type="submit" class="btn btn-success" value="Dodaj">
    </div>

</div>
<?= Form::close() ?>

@endsection