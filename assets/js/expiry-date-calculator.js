jQuery(document).ready(function ($) {
    $('#calculate-expiry').on('click', function () {
        let selectedMonth = parseInt($('#expiry-month').val());
        let selectedYear = parseInt($('#expiry-year').val());

        if (!isNaN(selectedMonth) && !isNaN(selectedYear)) {
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth() + 1;
            let currentYear = currentDate.getFullYear();
            let monthsUntilExp = (selectedYear - currentYear) * 12 + (selectedMonth - currentMonth);

            if (monthsUntilExp < 0) {
                $('#expiry-result').text('The selected expiration date is in the past.');
            } else {
                $('#expiry-result').html(
                    `Months until exp: ${monthsUntilExp}<br>` +
                    `Please Note: This is accurate if we receive your boxes BEFORE the end of this month. Thank you!`
                );
            }
        } else {
            $('#expiry-result').text('Please select a valid month and year.');
        }
    });

    function updatePrice() {
        const expirationDate = $('input[name="expiration-date"]:checked').val();
        const condition = $('input[name="condition"]:checked').val();

        let price = 0;

        // Calculate price based on conditions
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

        // Update the dynamic price display
        if (price > 0) {
            $('#dynamic-price').text(`Price: $${price}`);
        } else {
            $('#dynamic-price').text('');
        }

        // Check if the hidden input already exists
        let hiddenInput = $('#dynamic-price-input');
        if (hiddenInput.length === 0) {
            // Create the hidden input field if it doesn't exist
            $('<input>', {
                type: 'hidden',
                id: 'dynamic-price-input',
                name: 'dynamic_price',
                value: price
            }).appendTo('form.cart'); // Ensure it is added to the WooCommerce Add to Cart form
        } else {
            // Update the hidden input field's value
            hiddenInput.val(price);
        }
    }

    // Attach event listener to update the price when values change
    $('input[name="expiration-date"], input[name="condition"]').on('change', updatePrice);

    // On Add to Cart: Include custom fields
    $(document.body).on('submit', 'form.cart', function (event) {
      
        // Collect selected values
        let expiryMonth = $('#expiry-month').val();
        let expiryYear = $('#expiry-year').val();
        let expirationDate = $('input[name="expiration-date"]:checked').val();
        let condition = $('input[name="condition"]:checked').val();
        let dynamicPrice = $('#dynamic-price-input').val();
        if (!expiryMonth || !expiryYear || !expirationDate || !condition || !dynamicPrice) {
            alert('Please select all required options (Month, Year, Expiration Date, Condition, and Price) before adding to cart.');
            event.preventDefault(); // Prevent form submission
            return false;
        }

      

        // Append selected values to the form
        if (expiryMonth && expiryYear && expirationDate && condition && dynamicPrice) {
            $('<input>')
                .attr({ type: 'hidden', name: 'expiry_month', value: expiryMonth })
                .appendTo($(this));
            $('<input>')
                .attr({ type: 'hidden', name: 'expiry_year', value: expiryYear })
                .appendTo($(this));
            $('<input>')
                .attr({ type: 'hidden', name: 'expiration_date', value: expirationDate })
                .appendTo($(this));
            $('<input>')
                .attr({ type: 'hidden', name: 'condition', value: condition })
                .appendTo($(this));
        }
    });
});
