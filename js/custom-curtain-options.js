jQuery(document).ready(function($) {
    const priceMap = {
        '15_clear': {
            '5_3_58_4_57': 4.05,
            '6_3_69_4_68': 4.86,
            '9_3_105_4_104': 7.28,
            '12_3_141_4_140': 9.71
        },
        '18_white': {
            '5_3_58_4_57': 5.04,
            '6_3_69_4_68': 6.05,
            '9_3_105_4_104': 9.07,
            '12_3_141_4_140': 12.10
        }
    };

    function updatePrice() {
        const material = $('#curtain_material').val();
        const size = $('#curtain_size').val();
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

        $('#curtain_price').text('$' + price.toFixed(2));
    }

    $('#curtain_material, #curtain_size, #custom_length, #custom_width').on('change keyup', updatePrice);

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
