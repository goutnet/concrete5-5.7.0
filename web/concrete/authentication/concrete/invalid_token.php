<?php defined('C5_EXECUTE') or die('Access denied.');
$form = Loader::helper('form');
?>
<div class='forgotPassword'>
    <h2><?= t('Unable to validate email') ?></h2>

    <div class='help-block'>
        <?= t(
            'The token you provided doesn\'t appear to be valid, please paste the url exactly as it appears in the email.') ?>
    </div>
    <a href="<?= \URL::to('/login/callback/concrete') ?>" class="btn btn-block btn-primary">
        <?= t('Continue') ?>
    </a>
</div>
