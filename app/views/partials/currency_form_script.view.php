<?php
use \App\Models\App;

?>

<script type="text/javascript" src="public/js/calculator.js"></script>
<script>
$(document).ready(function(e) {
    var calculator = new Calculator({
        locale: '<?= App::get('localization')['number_format'] ?>',
        currency: '<?= $currency->getSymbol() ?>'
    });

    $('#fieldset-rares').on('shown.bs.collapse', function () {
        $('#more-toggle').remove();
    })
});
</script>