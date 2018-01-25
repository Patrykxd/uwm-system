<?php if (!empty($errors->all())): ?>
    <?php foreach ($errors->all() as $key => $error): ?>
        <div class="alerts alerts-danger" style="top:<?=10+$key*45?>px" onclick="this.remove()">
            <i class="fa fa-exclamation" aria-hidden="true"></i><strong><?= $error; ?></strong>&nbsp;<b>&times;</b>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (session()->has('success')): ?>
    <?php foreach (session('success') as $success): ?>
        <div class="alerts alerts-success" role="alert"  onclick="this.remove()">
            <i class="fa fa-check" aria-hidden="true"></i><strong><?= $success; ?></strong>&nbsp;<b>&times;</b>       
        </div>
    <?php endforeach; ?>
<?php endif; ?>
