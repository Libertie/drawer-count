<?php

require 'partials/header.view.php';

$labels = [
    'notes' => 'Banknotes',
    'coins' => 'Coins',
    'rolls' => 'Coin Rolls',
    'rares' => 'Uncommon Currencies'
];

?>
<div class="container">
    <h1 class="mt-5">Drawer Count</h1>
    <p class="lead">Calculate your drawer value by specifying a count for each denomination.</p>

    <hr>

    <form>


        <div class="form-group row mb-1">

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

        <hr>

        <?php foreach ($currency->denominations as $type => $variants) : ?>

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
            class="btn btn-secondary"
            data-toggle="collapse"
            href="#fieldset-rares"
            role="button"
            aria-expanded="false"
            aria-controls="type-rares">
            Show more
        </a>
    </form>

</div>
<?php

require 'partials/currency_form_script.view.php';
require 'partials/footer.view.php';

?>