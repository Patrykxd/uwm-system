
@extends('admin')
@section('content')
<h2>Lista linków</h2>
<a href="admin/scrapler/projects">wróć</a>

<?php if (!empty($links->all())): ?>
    <table class="table table-striped" style="background:#fff;">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%">Url</th>
                <th width="15%">Strona docelowa</th>
                <th width="15%">Anchor</th>
                <th width="10%">Status</th>
                <th width="5%">rel</th>
                <th width="15%">Sprawdzony</th>
                <th width="10%">Opcje</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($links as $link): ?>
                <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><input type="text" class="form-control pointer" value="<?= $link->url ?>" onclick="copyClip(this)" readonly></td>
                    <td><input type="text" class="form-control pointer" value="<?= $link->refersto ?>" onclick="copyClip(this)" readonly></td>
                    <td><input type="text" class="form-control pointer" value="<?= $link->anchor ?>" onclick="copyClip(this)" readonly></td>
                    <td><?= $link->server_response ?></td>
                    <td><?= $link->nofollow ?></td>
                    <td><?= $link->updated_at ?></td>
                    <td>
                        <a href="admin/scrapler/link/edit-link/<?= $link->links_id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="admin/scrapler/link/delete/<?= $link->links_id ?>" onclick="confirm('Napewno usunąć?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $links->links(); ?>
<?php else: ?>
    <h5>Brak linków w tym projekcie</h5>
<?php endif; ?>
@endsection