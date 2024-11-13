jQuery(document).ready(function($) {
  $('#calculate-expiry').on('click', function() {
      let month = parseInt($('#expiry-month').val());
      let year = parseInt($('#expiry-year').val());

      if (!isNaN(month) && !isNaN(year)) {
          let expiryDate = new Date(year, month - 1); // Adjust for 0-indexed months
          expiryDate.setMonth(expiryDate.getMonth() + 12); // Calculate 1 year from selected date

          let formattedDate = expiryDate.toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'long'
          });

          $('#expiry-result').text('Expiry Date: ' + formattedDate);
      } else {
          $('#expiry-result').text('Please select a valid month and year.');
      }
  });
});
