jQuery(document).ready(function($) {
    function convertFeetToInches(feet) {
        return feet * 12;
    }

    function updatePriceAndConvertSize() {
        var basePrice = 0;
        var materialType = $('#curtain_material').val();
        var sizeOption = $('#curtain_size').val();
        var totalPrice = basePrice + getOptionPrice(sizeOption, materialType);

        if ($('#second_hem').is(':checked')) {
            totalPrice += getSecondHemPrice(materialType);
        }

        if ($('#pipe_pocket').is(':checked')) {
            totalPrice += getPipePocketPrice(materialType);
        }

        if ($('#webbing_reinforcement').is(':checked')) {
            totalPrice += getWebbingReinforcementPrice();
        }

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

    $('#curtain_material, #curtain_size, #curtain_length, #custom_width, #custom_height, #second_hem, #pipe_pocket, #webbing_reinforcement').on('input change', updatePriceAndConvertSize);

    $('#curtain_size, #_curtain_size').change(toggleCustomSizeFields).change();

    updatePriceAndConvertSize();

    function getOptionPrice(sizeOption, materialType) {
        var prices = {
            'size_1': {'15_oz': 4.05, '18_oz': 5.04},
            'size_2': {'15_oz': 4.86, '18_oz': 6.05},
            'size_3': {'15_oz': 7.28, '18_oz': 9.07},
            'size_4': {'15_oz': 9.71, '18_oz': 12.10},
            'size_5': {'15_oz': 50, '18_oz': 60},
            'size_6': {'15_oz': 70, '18_oz': 80},
            'size_7': {'15_oz': 90, '18_oz': 100},
            'custom': {'15_oz': 150, '18_oz': 180}
        };

        if (prices[sizeOption] && prices[sizeOption][materialType]) {
            return prices[sizeOption][materialType];
        }
        return 0;
    }

    function getSecondHemPrice(materialType) {
        var secondHemPrices = {
            '15_oz': 0.54,
            '18_oz': 0.61
        };

        return secondHemPrices[materialType] || 0;
    }

    function getPipePocketPrice(materialType) {
        var pipePocketPrices = {
            '15_oz': 1.92,
            '18_oz': 2.16
        };

        return pipePocketPrices[materialType] || 0;
    }

    function getWebbingReinforcementPrice() {
        return 0.40;
    }
});
