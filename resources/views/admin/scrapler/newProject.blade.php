
@extends('admin')
@section('content')
<h2>Dodaj projekt</h2>
<a href="admin/scrapler/projects">wróć</a>

<?= Form::open(['url' => 'admin/scrapler/project/add', 'method' => 'post']) ?>
<div class="row">

    <div class="col-sm-6 col-12">
        <div class="form-group">
            <?= Form::text('project_name', old('project_name'), ['class' => 'form-control', 'placeholder' => 'Nazwa']) ?>
        </div>
        <div class="form-group">
            <?= Form::text('project_domain', old('project_domain'), ['class' => 'form-control', 'placeholder' => 'https://domena.pl']) ?>
        </div>
        <div class="form-group">
            <?= Form::select('groups_id', $groups,null,['class'=>'form-control']);?>
        </div>
        <input type="submit" class="btn btn-success" value="Dodaj">
    </div>

</div>
<?= Form::close() ?>

@endsection