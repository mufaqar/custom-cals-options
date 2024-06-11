jQuery(document).ready(function($) {
    const priceMap = {
        '15_clear': {
            '5_3_58_4_57': 4.05,
            '6_3_69_4_68': 4.86,
            '9_3_105_4_104': 7.28,
            '12_3_141_4_140': 9.71,
            'ft_price': 0.54,
            'pipe_pocket_price': 1.92,
            'webbing_price': 0.40
        },
        '18_white': {
            '5_3_58_4_57': 5.04,
            '6_3_69_4_68': 6.05,
            '9_3_105_4_104': 9.07,
            '12_3_141_4_140': 12.10,
            'ft_price': 0.61,
            'pipe_pocket_price': 2.16,
            'webbing_price': 0.40
        }
    };

    function updatePrice() {
        const material = $('#curtain_material').val();
        const size = $('#curtain_size').val();
        const secondHem = $('#second_hem').val();
        const pipePocket = parseInt($('#pipe_pocket').val());
        const webbingReinforcement = $('#webbing_reinforcement').is(':checked');

        let price = 0;

        if (size === 'custom') {
            const length = parseFloat($('#custom_length').val());
            const width = parseFloat($('#custom_width').val());

            if (!isNaN(length) && !isNaN(width)) {
                const area = length * width;
                price = (material === '15_clear') ? area * 0.81 : area * 1.01;
            }
        } else {
            price = priceMap[material][size] || 0;
        }

        const length = size === 'custom' ? parseFloat($('#custom_length').val()) : parseFloat(size.split('_')[0]);

        // Calculate additional cost for the second hem
        if (secondHem !== 'none') {
            price += length * priceMap[material]['ft_price'];
        }

        // Calculate additional cost for the pipe pocket
        if (!isNaN(pipePocket) && pipePocket > 0) {
            price += length * priceMap[material]['pipe_pocket_price'] * pipePocket;
        }

        // Calculate additional cost for webbing reinforcement if checked
        if (webbingReinforcement) {
            price += length * priceMap[material]['webbing_price'];
        }

        $('#curtain_price').text('$' + price.toFixed(2));
        console.log('Price:', price); // Log price
        console.log('Webbing Reinforcement:', webbingReinforcement); // Log webbing reinforcement
    }

    $('#curtain_material, #curtain_size, #custom_length, #custom_width, #second_hem, #pipe_pocket, #webbing_reinforcement').on('change keyup', updatePrice);

    $('#curtain_size').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#curtain_size_custom').show();
        } else {
            $('#curtain_size_custom').hide();
        }
        updatePrice();
    });

    // Initial price update
    updatePrice();
});
