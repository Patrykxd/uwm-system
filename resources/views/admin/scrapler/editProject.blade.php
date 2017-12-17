
@extends('admin')
@section('content')
<h2>Dodaj projekt</h2>
<a href="admin/scrapler/projects">wróć</a>

<?= Form::open(['url' => 'admin/scrapler/project/edit-save/'.$project['id'], 'method' => 'post']) ?>
<div class="row">
    <div class="col-sm-6 col-12">
        <div class="form-group">
            <?= Form::text('project_name', $project['project_name'] ? $project['project_name'] : old('project_name'), ['class' => 'form-control', 'placeholder' => 'Nazwa']) ?>
        </div>
        <div class="form-group">
            <?= Form::text('project_domain', $project['project_domain'] ? $project['project_domain'] : old('project_domain'), ['class' => 'form-control', 'placeholder' => 'https://domena.pl']) ?>
        </div>
        <div class="form-group">
            <?= Form::select('groups_id', $groups, $project['groups_id'], ['class' => 'form-control']); ?>
        </div>
        <input type="submit" class="btn btn-success" value="Dodaj">
    </div>
</div>
<?= Form::close() ?>

@endsection