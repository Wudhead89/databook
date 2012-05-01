/*
 * Document     : corefunctions.js
 * Created on   : 28-04-2012
 * Author       : Richard Williamson
 * 
 * Description  : A set of standard javascript snipets that are used on most pages
 */
$(document).ready(function(){
    init();
    
    if ($("#selectdataset").length > 0){
        $('#selectdataset').load("ajax/getdsselect.php")
    }
    
    /*
     * Visualize an HTML table using Highcharts. The top (horizontal) header
     * is used for series names, and the left (vertical) header is used
     * for category names. This function is based on jQuery.
     * @param {Object} table The reference to the HTML table to visualize
     * @param {Object} options Highcharts options
     */
    Highcharts.visualize = function(table, options) {
        // the categories
        options.xAxis.categories = [];
        $('tbody th', table).each( function(i) {
            options.xAxis.categories.push(this.innerHTML);
        });

        // the data series
        options.series = [];
        $('tr', table).each( function(i) {
            var tr = this;
            $('th, td', tr).each( function(j) {
                if (j > 0) { // skip first column
                    if (i == 0) { // get the name and init the series
                        options.series[j - 1] = {
                            name: this.innerHTML,
                            data: []
                        };
                    } else { // add values
                        options.series[j - 1].data.push(parseFloat(this.innerHTML));
                    }
                }
            });
        });

        var chart = new Highcharts.Chart(options);
    }

});

$(document).resize(function(){
    movepopup()
});

$(document).click(function(){
    clearTable();
});