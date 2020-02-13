<?php

require 'partials/header.view.php';

$labels = [
    'notes' => 'Banknotes',
    'coins' => 'Coins',
    'rolls' => 'Coin Rolls',
    'rares' => 'Uncommon Currencies'
];

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
    echo '<div class="alert alert-info text-center">' . $_SESSION['msg'] . '</div>';
    unset($_SESSION['msg']);
}

?> 
<div class="container">

    <h1 class="mt-5">Drawer Count</h1>
    <p class="lead">Calculate your drawer value by specifying a count for each denomination.</p>

    <form id="drawer-form" method="post">

        <div class="jumbotron form-group row my-4 px-3 py-3">

            <label for="expected" class="col-sm-4 col-form-label">
                Expected count
            </label>

            <div class="col-8 col-sm-4">
                <input
                    type="number"
                    name="expected"
                    id="expected"
                    class="form-control currency-count"
                    min=0
                    step=.01
                    dir="rtl">
            </div>

            <div class="col-4 col-sm-4 text-right">
                <span class="form-text text-muted">Optional</span>
            </div>

        </div>

        <?php foreach ($currency->getDenominations() as $type => $variants) : ?>

        <fieldset id="fieldset-<?= $type ?>" class="mb-3 denomination-wrapper<?= $type == 'rares' ? ' collapse' : '' ?>">
            <legend class="d-block <?= $sorts[$type] ?>">
                <?= $labels[$type] ?> 
            </legend>

            <?php foreach ($variants as $label => $value) : ?>
            <?php require 'partials/currency_form_group.view.php'; ?> 
            <?php endforeach; ?>

        </fieldset>

        <?php endforeach; ?>

        <a id="more-toggle"
            class="btn btn-link d-block mx-auto"
            data-toggle="collapse"
            href="#fieldset-rares"
            role="button"
            aria-expanded="false"
            aria-controls="type-rares">
            Show more
        </a>

        <input id="drawer-total" name="total" type="hidden" value="0">
        <input id="drawer-discrepancy" name="discrepancy" type="hidden" value="">

    </form>

</div>
<?php

require 'partials/currency_form_script.view.php';
require 'partials/modal.view.php';
require 'partials/footer.view.php';

?>