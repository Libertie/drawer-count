
class Calculator {

    constructor(options = {}) {

        this.total = 0;
        this.locale = options.locale || 'en-US';
        this.currency = options.currency || 'USD';

        this.init();

    }

    init() {

        var self = this;

        // Set listeners for reordering
        $('legend').click(function () {
            self.reorder(this);
        });

        // Set listeners for updating row values
        $('.currency-count').on('input propertychange paste', function () {
            self.calculate()
        });

        // Run an initial calculation
        this.calculate(true);

    }

    pretty(number) {

        return new Intl.NumberFormat(this.locale, {
            style: 'currency',
            currency: this.currency
        }).format(number)

    }

    calculate(init = false) {

        var self = this;
        this.total = 0;

        // Loop through the rows and add them up
        $('.denomination-wrapper .row').each(function (index, row) {
            self.total += self.updateRow(row);
        });

        // Update the footer
        this.display();
    }

    display() {

        var expected = Math.round($('#expected').val() * 100);
        var discrepancy = expected - this.total;

        $('#calculator-sum').text(this.pretty(this.total / 100));

        // No expected specified
        if (! expected) {
            $('#calculator-discrepancy').text('');
        // Expected specified, no discrepancy
        } else if (expected && discrepancy == 0) {
            $('#calculator-discrepancy').text('No discrepancy');
        // Expected specified, short
        } else if (expected && discrepancy > 0) {
            $('#calculator-discrepancy').text('Short: ' + this.pretty(discrepancy / 100));
        // Expected specified, over
        } else if (expected && discrepancy < 0) {
            $('#calculator-discrepancy').text('Over: ' + this.pretty(Math.abs(discrepancy / 100)));
        }
    }

    updateRow(row) {

        // Calculate row value
        var rowValue = $(row).data('val') * $(row).find('.currency-count').val();

        // Update the row
        $(row).find('.currency-ext').text(this.pretty(rowValue / 100));

        return rowValue;
    }

    reorder(legend) {

        // Sort the fieldset according to the assigned class ("asc" or "desc")
        $(legend).siblings('.form-group')
            .sort(function (a, b) {
                if ($(legend).hasClass('desc'))
                    return $(b).data('val') < $(a).data('val') ? 1 : -1;
                else
                    return $(b).data('val') > $(a).data('val') ? 1 : -1;
            })
            .appendTo($(legend).parent());

        $(legend).toggleClass("asc desc");

    }

}
