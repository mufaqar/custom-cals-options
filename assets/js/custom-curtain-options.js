jQuery(document).ready(function($) {
    function convertFeetToInches(feet) {
        return feet * 12;
    }

    function updatePriceAndConvertSize() {
        var basePrice = 0;
        var materialPrice = getOptionPrice($('#curtain_material').val());
        var sizePrice = getOptionPrice($('#curtain_size').val());
        var lengthPrice = getOptionPrice($('#curtain_length').val());
        var totalPrice = basePrice + materialPrice + sizePrice + lengthPrice;

        $('#curtain_price').text('$' + totalPrice.toFixed(2));

        if ($('#curtain_size option:selected').val() === 'custom' || $('#_curtain_size option:selected').val() === 'custom') {
            var customWidthFeet = parseFloat($('#custom_width').val()) || 0;
            var customHeightFeet = parseFloat($('#custom_height').val()) || 0;

            var customWidthInches = convertFeetToInches(customWidthFeet);
            var customHeightInches = convertFeetToInches(customHeightFeet);

            $('#custom_width_inches').text(customWidthInches.toFixed(2) + ' inches').show();
            $('#custom_height_inches').text(customHeightInches.toFixed(2) + ' inches').show();
        } else {
            $('#custom_width_inches').hide();
            $('#custom_height_inches').hide();
        }
    }

    function toggleCustomSizeFields() {
        if ($('#curtain_size option:selected').val() === 'custom' || $('#_curtain_size option:selected').val() === 'custom') {
            $('.curtain-custom-size-fields').show();
            updatePriceAndConvertSize();
        } else {
            $('.curtain-custom-size-fields').hide();
        }
    }

    $('#curtain_material, #curtain_size, #curtain_length, #custom_width, #custom_height').on('input change', updatePriceAndConvertSize);

    $('#curtain_size, #_curtain_size').change(toggleCustomSizeFields).change();

      updatePriceAndConvertSize();

    function getOptionPrice(optionValue) {
        var prices = {
            '15_clear': 15,
            '18_white': 18,
            'size_1': 50,
            'size_2': 60,
            'size_3': 90,
            'size_4': 120,
            'custom': 150,
            '11': 11,
            '12': 12,
            '13': 13,
            '14': 14,
            '15': 15,
            '16': 16,
            '17': 17,
            '18': 18,
            '19': 19,
            '20': 20,
            '21': 21,
            '22': 22,
            '23': 23,
            '24': 24,
            '25': 25,
            '26': 26,
            '27': 27,
            '28': 28,
            '29': 29,
            '30': 30,
            '31': 31,
            '32': 32,
            '33': 33,
            '34': 34,
            '35': 35,
            '36': 36,
            '37': 37,
            '38': 38,
            '39': 39,
            '40': 40,
            '41': 41,
            '42': 42,
            '43': 43,
            '44': 44,
            '45': 45,
            '46': 46,
            '47': 47,
            '48': 48,
            '49': 49,
            '50': 50
        };

        return prices[optionValue] || 0;
    }
});
