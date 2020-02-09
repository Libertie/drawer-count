<?php
use \App\Core\App;

$numberFormatter = new NumberFormatter(App::get('config')['localization']['number_format'], NumberFormatter::CURRENCY);
$currency_symbol = $numberFormatter->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
?>

<script type="text/javascript" src="public/js/calculator.js"></script>
<script>
$(document).ready(function(e) {
    var calculator = new Calculator({
        locale: '<?= App::get('config')['localization']['number_format'] ?>',
        currency: '<?= $currency_symbol ?>'
    });

    $('#fieldset-rares').on('shown.bs.collapse', function () {
        $('#more-toggle').remove();
    })
});
</script>