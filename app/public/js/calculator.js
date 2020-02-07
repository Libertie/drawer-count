class Person {
    constructor(name) {
        this.name = name;
        this.greeting = function () {
            alert('Hi! I\'m ' + this.name + '.');
        };
    }
}
;

/*
function Calculator() {
 
    var vars = {
        total  : 0
    };
 
    var root = this;
 
    this.construct = function() {
        $('legend').click(function () {
            reorder(this);
        });
        $('.currency-count').on('input propertychange paste', function () {
            updateRow($(this).closest('.row'));
        });        
    };
 
    this.myPublicMethod = function() {
        console.log(vars.myVar);
 
        myPrivateMethod();
    };
 
    var reorder = function(legend) {
        $(legend).siblings('.form-group')
        .sort(function(a, b) {
            if ($(legend).hasClass('desc'))
                return $(b).data('val') < $(a).data('val') ? 1 : -1; 
            else
                return $(b).data('val') > $(a).data('val') ? 1 : -1; 
        })
        .appendTo($(legend).parent());
        $(legend).toggleClass("asc desc");
    };

    var updateRow = function(row) {
        $(row).css('background', 'red');
    }; 
 
    this.construct(); 
}
*/

/*
function reorder(legend) {
    $(legend).siblings('.form-group')
        .sort(function(a, b) {
            if ($(legend).hasClass('desc'))
                return $(b).data('val') < $(a).data('val') ? 1 : -1; 
            else
                return $(b).data('val') > $(a).data('val') ? 1 : -1; 
        })
        .appendTo($(legend).parent());
    $(legend).toggleClass("asc desc");
}

function updateRow(row) {
    
}



$('.currency-count').on('input propertychange paste', function () {
    updateRow($(this).closest('.row'));
});
*/