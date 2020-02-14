
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

        // Treat ENTER as TAB to navigate form
        $('.currency-count').keypress(
            function (event) {
                if (event.which == '13') {
                    event.preventDefault();
                    $('input, select, textarea')[$('input,select,textarea').index(this) + 1].focus();
                }
            }
        );

        // Prevent submit of 0 count
        $('#drawer-submit').prop('disabled', true)

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

        // Update the hidden total field
        $("#drawer-total").val(this.total / 100);
        // Calculate and display the discrepancy
        this.display();

        // Toggle submit, disable when form is empty
        if (this.total > 0) {
            $('#drawer-submit').prop('disabled', false)
        } else {
            $('#drawer-submit').prop('disabled', true)
        }

    }

    display() {

        var expected = Math.round($('#expected').val() * 100);
        var discrepancy = (expected - this.total) / 100;

        // Update the total in the footer
        $('#calculator-sum').text(this.pretty(this.total / 100));

        // No expected specified
        if (!expected) {
            $('#calculator-discrepancy').text('');
            $("#drawer-discrepancy").val('');
            // Expected specified, no discrepancy
        } else if (expected && discrepancy == 0) {
            $('#calculator-discrepancy').text('No discrepancy');
            $("#drawer-discrepancy").val(0);
            // Expected specified, short
        } else if (expected && discrepancy > 0) {
            $('#calculator-discrepancy').text('Short: ' + this.pretty(discrepancy));
            $("#drawer-discrepancy").val(discrepancy);
            // Expected specified, over
        } else if (expected && discrepancy < 0) {
            $('#calculator-discrepancy').text('Over: ' + this.pretty(Math.abs(discrepancy)));
            $("#drawer-discrepancy").val(discrepancy);
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
