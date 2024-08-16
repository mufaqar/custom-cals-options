jQuery(document).ready(function ($) {
  function convertFeetToInches(feet) {
    return feet * 12;
  }

  function updateSizeOptions() {
    var materialType = $('#curtain_material').val();
    var curtainSizeSelect = $('#curtain_size');

    // Clear current options
    curtainSizeSelect.empty();

    // Add new size options based on the selected material
    if (prices[materialType] && prices[materialType].lin_pr) {
      var sizeOptions = prices[materialType].lin_pr;
      $.each(sizeOptions, function (key, value) {
        curtainSizeSelect.append(new Option(value.label, key));
      });
    }

    // Trigger price update after updating options
    updatePriceAndConvertSize();
  }

  function updatePriceAndConvertSize() {
    var basePrice = 0;
    var materialType = $('#curtain_material').val();
    var sizeValue = $('#curtain_size').val();
     var cusom_height = parseFloat($('#cusom_height').val()) || 0;
     console.log("🚀 ~ updatePriceAndConvertSize ~ cusom_height:", cusom_height)
 
   

   

    // Get other price components
    var lengthPrice = getLengthPrice($('#curtain_length').val());
    var hemPrice = $('#curtain_hem').val() !== 'none' ? getHemPrice(materialType) : 0;

    // Calculate the secondHemPrice and log it to the console
    var secondHemPrice = $('#second_hem').val() !== 'none' ? getSecondHemPrice(materialType) : 0;
    console.log('Second Hem Price:', secondHemPrice);

    var pipePocketPrice = $('#pipe_pocket').val() !== 'none' ? getPipePocketPrice(materialType) : 0;
    console.log('pipePocketPrice:', pipePocketPrice);

    // Calculate the webbing reinforcement price
    var webbingReinforcementPrice = $('#webbing_reinforcement').is(':checked') ? getWebbingReinforcementPrice(materialType) : 0;
    console.log('Webbing Reinforcement Price:', webbingReinforcementPrice);

    var customSizePrice = 0;

    if (sizeValue === 'size_custom') { // Check if custom size is selected
      var customWidthFeet = parseFloat($('#custom_width').val()) || 0;
      console.log("🚀 ~ updatePriceAndConvertSize ~ customWidthFeet:", customWidthFeet)
      var customHeightFeet = parseFloat($('#custom_height').val()) || 0;
      console.log("🚀 ~ updatePriceAndConvertSize ~ customHeightFeet:", customHeightFeet)

      customSizePrice = getCustomSizePrice(customWidthFeet, customHeightFeet, materialType);
      

      var customWidthInches = convertFeetToInches(customWidthFeet);
      var customHeightInches = convertFeetToInches(customHeightFeet);

      $('#custom_width_inches')
        .text(customWidthInches.toFixed(2) + ' inches')
        .show();
      $('#custom_height_inches')
        .text(customHeightInches.toFixed(2) + ' inches')
        .show();

      // Show custom size fields if size_custom is selected
      $('.curtain_custom_width').show();
      $('.curtain_custom_height').show();
    } else {

      var customHeightFeet = parseFloat($('#custom_height').val()) || 0;
      materialPrice = prices[materialType].lin_pr[sizeValue].price || 0;
      materialPrice = customHeightFeet * materialPrice;


      $('.curtain_custom_width').hide();
      $('.curtain_custom_height').show();
    }

    // Calculate total price
    var totalPrice =
      basePrice +
      materialPrice +
      lengthPrice +
      hemPrice +
      secondHemPrice +
      pipePocketPrice +
      webbingReinforcementPrice +
      customSizePrice;

    // Update the displayed price
    $('#curtain_price').text('$' + totalPrice.toFixed(2));
  }

  function toggleCustomSizeFields() {
    // Trigger the price update and field toggle logic when the size is changed
    updatePriceAndConvertSize();
  }

  // Attach event listeners to form fields
  $('#curtain_material').on('change', updateSizeOptions);
  $('#curtain_size, #curtain_length, #curtain_hem, #custom_width, #custom_height, #second_hem, #pipe_pocket, #webbing_reinforcement, #cusom_height').on('input change', updatePriceAndConvertSize);

  // Initial trigger for material and size options
  updateSizeOptions();
  toggleCustomSizeFields();

  // Functions to retrieve prices
  function getLengthPrice(lengthValue) {
    var lengthPrices = {};
    for (var i = 11; i <= 50; i++) {
      lengthPrices[i.toString()] = i;
    }
    return lengthPrices[lengthValue] || 0;
  }

  function getHemPrice(materialType) {
    return prices[materialType] ? prices[materialType].him || 0 : 0;
  }

  function getSecondHemPrice(materialType) {
    var customHeightFeet = parseFloat($('#custom_height').val()) || 0;
    var materialPricePerUnit = prices[materialType] ? prices[materialType].him || 0 : 0;
    return customHeightFeet * materialPricePerUnit;
  }

  function getPipePocketPrice(materialType) {
    var pipePocketQuantity = parseInt($('#pipe_pocket').val()) || 0;
    if (pipePocketQuantity === 0) return 0;
    var customHeightFeet = parseFloat($('#custom_height').val()) || 0;
    var materialPricePerUnit = prices[materialType] ? prices[materialType].pocket || 0 : 0;
    // Calculate the price: custom height * price per unit * quantity selected
    return (customHeightFeet * materialPricePerUnit) * pipePocketQuantity;
  }

  function getWebbingReinforcementPrice(materialType) {
    var customHeightFeet = parseFloat($('#custom_height').val()) || 0;
    var materialPricePerUnit = prices[materialType] ? prices[materialType].web || 0 : 0;
    return customHeightFeet * materialPricePerUnit;
  }

  function getCustomSizePrice(widthFeet, heightFeet, materialType) {
    var squareFeet = widthFeet * heightFeet;
    console.log("🚀 ~ getCustomSizePrice ~ squareFeet:", squareFeet)
    var pricePerSquareFoot = prices[materialType] ? prices[materialType].lin_pr.size_custom.price || 0 : 0;
    console.log("🚀 ~ getCustomSizePrice ~ pricePerSquareFoot:", pricePerSquareFoot)
    return squareFeet * pricePerSquareFoot;
  }
});

// Define the prices object with example data
var prices = {
  '15_oz': {
    lin_pr: {
      size_5: {
        price: 4.05,
        label: '5\' with 1 3" Hem (58") or 4" Hem'
      },
      size_6: {
        price: 4.86,
        label: '6\' with 1 3" Hem (69") or 4" Hem'
      },
      size_9: {
        price: 7.28,
        label: '9\' with 1 3" Hem (105") or 4" Hem'
      },
      size_12: {
        price: 9.71,
        label: '12\' with 1 3" Hem (141") or 4" Hem (140")'
      },
      size_custom: {
        price: 0.81,
        label: 'Custom Size (price x total sq ft)'
      }
    },
    him: 0.54,
    pocket: 1.92,
    web: 0.4,
  },
  '18_oz': {
    lin_pr: {
      size_5: {
        price: 5.04,
        label: '5\' with 1 3" Hem (58") or 4" Hem'
      },
      size_6: {
        price: 6.05,
        label: '6\' with 1 3" Hem (69") or 4" Hem'
      },
      size_9: {
        price: 9.07,
        label: '9\' with 1 3" Hem (105") or 4" Hem'
      },
      size_12: {
        price: 12.1,
        label: '12\' with 1 3" Hem (141") or 4" Hem (140")'
      },
      size_custom: {
        price: 1.01,
        label: 'Custom Size (price x total sq ft)'
      }
    },
    him: 0.61,
    pocket: 2.16,
    web: 0.4,
  }
};
