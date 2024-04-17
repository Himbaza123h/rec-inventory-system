<footer class="footer text-right">
    <p class="mb-0">© Copyright <?php echo date('Y'); ?>. All Rights Reserved</p>
</footer>
<script src="{{ asset('js/ajax_call.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
<script>
    //multiselect start

    $('#my_multi_select1').multiSelect();
    $('#my_multi_select2').multiSelect({
        selectableOptgroup: true
    });

    $('#my_multi_select3').multiSelect({
        selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function(ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') +
                ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') +
                ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function() {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function() {
            this.qs1.cache();
            this.qs2.cache();
        }
    });



    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });
</script>
