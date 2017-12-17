
@extends('admin')
@section('content')
<h2>Dodaj projekt</h2>
<a href="admin/scrapler/projects">wróć</a>

<?= Form::open(['url' => 'admin/scrapler/project/new-xml', 'method' => 'post','files' => true]) ?>
<div class="row">

    <div class="col-sm-6 col-12">
        <pre>
        xml->project(
                'name',
                'domain',
                links(
                    'url',
                    'strona docelowa',
                    'anchor')
                )</pre>
        <div class="form-group">
            <?= Form::file('xml') ?>
        </div>
        <input type="submit" class="btn btn-success" value="Dodaj">
    </div>

</div>
<?= Form::close() ?>

@endsection