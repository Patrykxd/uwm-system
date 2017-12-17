
@extends('admin')
@section('content')
<h2>Lista projektów</h2>
<a href="admin/scrapler/project/new" class="btn btn-primary btn-sm">Dodaj projekt</a>
<a href="admin/scrapler/project/add-xml" class="btn btn-primary btn-sm">Dodaj XML</a>
<div class="w-100">&nbsp;</div>
<?php if (!empty($projects->all())): ?>
    <table class="table table-striped" style="background:#fff;">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%">Projekt</th>
                <th width="20%">Grupa</th>
                <th width="20%">Domena</th>
                <th width="20%">Dodany</th>
                <th width="15%">Opcje</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><?= $project->project_name ?></td>
                    <td><?= $project->groups()->first()->name_grups; ?></td>
                    <td><?= $project->project_domain ?></td>
                    <td><?= $project->created_at ?></td>
                    <td>
                        <a href="admin/scrapler/project/edit/<?= $project->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="admin/scrapler/project/add-link/<?= $project->id ?>" class="btn btn-sm btn-info"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        <a href="admin/scrapler/project/id/<?= $project->id ?>" class="btn btn-sm btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="admin/scrapler/project/delete/<?= $project->id ?>" onclick="return confirm('Napewno usunąć?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $projects->links(); ?>
<?php else: ?>
    <h5>Brak aktualnych projektów</h5>
<?php endif; ?>
@endsection