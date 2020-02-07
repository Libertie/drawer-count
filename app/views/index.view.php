<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Drawer Count</title>
    <link
        rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
        crossorigin="anonymous">

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>

    <style>
    main {
        margin-bottom: 6em;
    }
    legend {
        cursor: pointer;
    }
    input[type=number] {
        text-align: right;
    }
    legend:hover {
        color: darkred;
    }
    .container {
        max-width: 680px;
    }
    .asc:after {
        content: "\21E1";
        margin-left: .25em;
    }
    .desc:after {
        content: "\21E3";
        margin-left: .25em;
    }
    </style>
</head>

<body class="h-100">

    <main role="main">
        <div class="container">
            <h1 class="mt-5">Drawer Count</h1>
            <p class="lead">Calculate your drawer value by specifying a count for each denomination.</p>

            <hr>

            <form>
                <?php foreach ($app['currency'] AS $type => $denominations) : ?>

                <fieldset class="mb-3 denomination-wrapper">
                    <legend class="d-block <?= $app['config']['display'][$type] ?>">
                        <?php
                        switch ($type) {
                            case 'notes':
                                echo "Banknotes";
                                break;
                            case 'coins':
                                echo "Coins";
                                break;
                            case 'rolls':
                                echo "Coin Rolls";
                                break;
                            case 'rares':
                                echo "Uncommon Currencies";
                                break;
                        }
                        ?>
                    </legend>

                    <?php foreach ($denominations AS $label => $value) : ?>
                    <?php require 'partials/currency_form_group.view.php' ?> 
                    <?php endforeach; ?>

                </fieldset>

                <?php endforeach; ?>
            </form>

        </div>
    </main>

    <footer class="footer py-3 fixed-bottom bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-4 text-right lead">
                    Total: 
                    <span id="calculator-sum">$0.00</span>
                </div>
            </div>
        </div>
    </footer>

<?php
$numberFormatter = new NumberFormatter($app['config']['localization']['number_format'], NumberFormatter::CURRENCY);
$currency_symbol = $numberFormatter->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
?>

    <script type="text/javascript" src="public/js/calculator.js"></script>
    <script>
    $(document).ready(function(e) {
        var calculator = new Calculator({
            locale: '<?= $app['config']['localization']['number_format'] ?>',
            currency: '<?= $currency_symbol ?>'
        });
    });
    </script>

</body>

</html>