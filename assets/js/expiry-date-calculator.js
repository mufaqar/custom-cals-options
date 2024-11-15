jQuery(document).ready(function($) {
    $('#calculate-expiry').on('click', function() {
        let selectedMonth = parseInt($('#expiry-month').val());
        let selectedYear = parseInt($('#expiry-year').val());

        if (!isNaN(selectedMonth) && !isNaN(selectedYear)) {
            // Current date
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed in JavaScript
            let currentYear = currentDate.getFullYear();

            // Calculate months until expiration
            let monthsUntilExp = (selectedYear - currentYear) * 12 + (selectedMonth - currentMonth);

            if (monthsUntilExp < 0) {
                $('#expiry-result').text('The selected expiration date is in the past.');
            } else {
                // Display result
                $('#expiry-result').html(
                    `Months until exp: ${monthsUntilExp}<br>` +
                    `Please Note: This is accurate if we receive your boxes BEFORE the end of this month. Thank you!`
                );
            }
        } else {
            $('#expiry-result').text('Please select a valid month and year.');
        }
    });
});

jQuery(document).ready(function($) {
    function updatePrice() {
        const expirationDate = $('input[name="expiration-date"]:checked').val();
        const condition = $('input[name="condition"]:checked').val();

        let price = 0;

        // Determine price based on expiration date and condition
        if (expirationDate === '10+ months') {
            if (condition === 'Mint') {
                price = 30;
            } else if (condition === 'Good') {
                price = 28;
            }
        } else if (expirationDate === '7-9 months') {
            if (condition === 'Mint') {
                price = 25;
            } else if (condition === 'Good') {
                price = 23;
            }
        } else if (expirationDate === '6-8 months') {
            if (condition === 'Mint') {
                price = 10;
            } else if (condition === 'Good') {
                price = 8;
            }
        }

        // Display the price or clear it if conditions are not met
        if (price > 0) {
            $('#dynamic-price').text(`Price: $${price}`);
        } else {
            $('#dynamic-price').text('');
        }
    }

    // Attach event listeners to the radio buttons
    $('input[name="expiration-date"], input[name="condition"]').on('change', updatePrice);
});

