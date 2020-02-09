<?php

require 'partials/header.view.php';

?>
<div class="container">
    <h1 class="mt-5">Drawer Count</h1>
    <p class="lead">Calculate your drawer value by specifying a count for each denomination.</p>

    <hr>

    <form>
        <?php foreach ($currency->denominations as $type => $variants) : ?>

        <fieldset class="mb-3 denomination-wrapper">
            <legend class="d-block <?= $sorts[$type] ?>">
                <?php
                switch ($type) {
                    case 'notes':
                        echo 'Banknotes';
                        break;
                    case 'coins':
                        echo 'Coins';
                        break;
                    case 'rolls':
                        echo 'Coin Rolls';
                        break;
                    case 'rares':
                        echo 'Uncommon Currencies';
                        break;
                }
                ?>
            </legend>

            <?php foreach ($variants as $label => $value) : ?>
            <?php require 'partials/currency_form_group.view.php'; ?> 
            <?php endforeach; ?>

        </fieldset>

        <?php endforeach; ?>
    </form>

</div>
<?php

require 'partials/currency_form_script.view.php';
require 'partials/footer.view.php';

?>