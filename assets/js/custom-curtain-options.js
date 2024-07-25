jQuery(document).ready(function($) {
    // Convert feet to inches
    function convertFeetToInches(feet) {
        return feet * 12;
    }

    // Function to update the price display and handle custom size conversion
    function updatePriceAndConvertSize() {
        var basePrice = 0; // Base price of the product, you may get it dynamically if needed

        var materialPrice = getOptionPrice($('#curtain_material').val());
        var sizePrice = getOptionPrice($('#curtain_size').val());
        var hemPrice = getOptionPrice($('#curtain_hem').val());
        var secondHemPrice = getOptionPrice($('#second_hem').val());
        var pipePocketPrice = getOptionPrice($('#pipe_pocket').val());
        var webbingPrice = $('#webbing_reinforcement').is(':checked') ? 10 : 0; // Example price for webbing reinforcement

        var totalPrice = basePrice + materialPrice + sizePrice + hemPrice + secondHemPrice + pipePocketPrice + webbingPrice;

        // Update the price display
        $('#curtain_price').text('$' + totalPrice.toFixed(2));

        // Convert custom size fields from feet to inches if custom size is selected
        if ($('#curtain_size option:selected').val() === 'custom' || $('#_curtain_size option:selected').val() === 'custom') {
            var customWidthFeet = parseFloat($('#custom_width').val()) || 0;
            var customHeightFeet = parseFloat($('#custom_height').val()) || 0;

            var customWidthInches = convertFeetToInches(customWidthFeet);
            var customHeightInches = convertFeetToInches(customHeightFeet);

            // Display the converted values
            $('#custom_width_inches').text(customWidthInches.toFixed(2) + ' inches').show();
            $('#custom_height_inches').text(customHeightInches.toFixed(2) + ' inches').show();
        } else {
            $('#custom_width_inches').hide();
            $('#custom_height_inches').hide();
        }
    }

    // Show or hide custom size fields based on the selected size option
    function toggleCustomSizeFields() {
        if ($('#curtain_size option:selected').val() === 'custom' || $('#_curtain_size option:selected').val() === 'custom') {
            $('.curtain-custom-size-fields').show();
            updatePriceAndConvertSize(); // Update inches display when fields are shown
        } else {
            $('.curtain-custom-size-fields').hide();
        }
    }

    // Event handlers for price and size conversion updates
    $('#curtain_material, #curtain_size, #curtain_hem, #second_hem, #pipe_pocket, #webbing_reinforcement, #custom_width, #custom_height').on('input change', updatePriceAndConvertSize);

    // Toggle custom size fields
    $('#curtain_size, #_curtain_size').change(toggleCustomSizeFields).change(); // Initial check

    // Toggle electric system options
    $('#electric_system').change(function() {
        if ($(this).val() === 'yes') {
            $('#curtain_options').show();
        } else {
            $('#curtain_options').hide();
        }
    }).change(); // Trigger change to set initial state

    // Initial call to update the display with any pre-set values
    updatePriceAndConvertSize();

    // Example function to get the price of an option, replace with your logic
    function getOptionPrice(optionValue) {
        var prices = {
            '15_clear': 15,
            '18_white': 18,
            'size_1': 50,
            'size_2': 60,
            'size_3': 90,
            'size_4': 120,
            'custom': 150,
            '3_hem': 10,
            '4_hem': 12,
            'none': 0,
            '1': 5,
            '2': 10,
            '3': 15
        };

        return prices[optionValue] || 0;
    }
});
