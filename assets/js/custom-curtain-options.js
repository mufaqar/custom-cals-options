jQuery(document).ready(function($) {
    // Update the price display when an option is selected
    $('#curtain_material, #curtain_size, #curtain_hem, #second_hem, #pipe_pocket, #webbing_reinforcement').change(function() {
        updatePrice();
    });

    // Show or hide custom size inputs based on the selected size option
    $('#curtain_size').change(function() {
        if ($(this).val() === 'custom') {
            $('#curtain_size_custom').show();
        } else {
            $('#curtain_size_custom').hide();
        }
    });

    // Initial check for custom size option
    if ($('#curtain_size').val() === 'custom') {
        $('#curtain_size_custom').show();
    } else {
        $('#curtain_size_custom').hide();
    }

    // Function to update the price display
    function updatePrice() {
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
    }

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


jQuery(document).ready(function($) {
    $('#electric_system').change(function() {
        if ($(this).val() === 'yes') {
            $('#curtain_options').show();
        } else {
            $('#curtain_options').hide();
        }
    }).change(); // Trigger change to set initial state
});
