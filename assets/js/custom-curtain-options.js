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

    // Calculate total feet from feet and inches inputs
    var custom_height_feet = parseFloat($('#custom_height_feet').val()) || 0;
    var custom_height_inches = parseFloat($('#custom_height_inches').val()) || 0;
    var TFH = custom_height_feet + custom_height_inches / 12; 
    var custom_width_feet = parseFloat($('#custom_width_feet').val()) || 0;
    var custom_width_inches = parseFloat($('#custom_width_inches').val()) || 0;
    var TFW = custom_width_feet + custom_width_inches / 12; 
    

    // Initialize material price
    var materialPrice = 0;

    if (sizeValue !== 'size_custom') {
      // Calculate material price based on the selected size
      materialPrice = prices[materialType]?.lin_pr[sizeValue]?.price || 0;
      
      if (TFH > 0) {
        materialPrice = TFH * materialPrice;
      } else {
        materialPrice = 0;
      }
      // Hide custom size fields if a predefined size is selected
      $('.curtain_custom_width').hide();
      $('.curtain_custom_height').show();
    } else {

   
      materialPrice = prices[materialType]?.lin_pr[sizeValue]?.price || 0;
      console.log("🚀 ~ updatePriceAndConvertSize ~ materialPrice:", materialPrice)
      var customSizePrice = getCustomSizePrice(TFW, TFH, materialType);
    
      // Show custom size fields if size_custom is selected
      $('.curtain_custom_width').show();
      $('.curtain_custom_height').show();

      materialPrice = customSizePrice;
    }

    // Get other price components
    var lengthPrice = getLengthPrice(TFH);
    var hemPrice = getHemPrice(materialType, TFH); // Default hem price
   
 
    var secondHemPrice = $('#second_hem').val() !== 'none' ? getSecondHemPrice(materialType, TFH) : 0;
    var pipePocketPrice = $('#pipe_pocket').val() !== 'none' ? getPipePocketPrice(materialType, TFH) : 0;
    var webbingReinforcementPrice = $('#webbing_reinforcement').is(':checked') ? getWebbingReinforcementPrice(materialType, TFH) : 0;

    // Calculate total price
    var totalPrice = basePrice + materialPrice + lengthPrice + hemPrice + secondHemPrice + pipePocketPrice + webbingReinforcementPrice;

    // Ensure totalPrice is a valid number
    totalPrice = isNaN(totalPrice) ? 0 : totalPrice;

    // Update the displayed price
    $('#curtain_price').text('$' + totalPrice.toFixed(2));
  }

  function toggleCustomSizeFields() {
    // Trigger the price update and field toggle logic when the size is changed
    updatePriceAndConvertSize();
  }

  // Attach event listeners to form fields
  $('#curtain_material').on('change', updateSizeOptions);
  $(
    '#curtain_size, #curtain_length, #curtain_hem, #second_hem, #pipe_pocket, #webbing_reinforcement, #custom_height_feet, #custom_height_inches , #custom_width_feet , #custom_width_inches'
  ).on('input change', updatePriceAndConvertSize);

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

  function getHemPrice(materialType,TFH) {
    var materialPricePerUnit = prices[materialType] ? prices[materialType].him || 0 : 0;
    return TFH * materialPricePerUnit; // Use TFH for second hem price calculation
  }

  function getSecondHemPrice(materialType, TFH) {
    var materialPricePerUnit = prices[materialType] ? prices[materialType].him || 0 : 0;
    return TFH * materialPricePerUnit; // Use TFH for second hem price calculation
  }

  function getPipePocketPrice(materialType, TFH) {
    var pipePocketQuantity = parseInt($('#pipe_pocket').val()) || 0;
    if (pipePocketQuantity === 0) return 0;
    var materialPricePerUnit = prices[materialType] ? prices[materialType].pocket || 0 : 0;
    return TFH * materialPricePerUnit * pipePocketQuantity; // Use TFH for pipe pocket price calculation
  }

  function getWebbingReinforcementPrice(materialType, TFH) {
    var materialPricePerUnit = prices[materialType] ? prices[materialType].web || 0 : 0;
    return TFH * materialPricePerUnit; // Use TFH for webbing reinforcement price calculation
  }

  function getCustomSizePrice(TFW, TFH, materialType) {
    var squareFeet = TFW * TFH;  
    var pricePerSquareFoot = prices[materialType] ? prices[materialType].lin_pr.size_custom.price || 0 : 0;   
    return squareFeet * pricePerSquareFoot;
  }
});

// Define the prices object with example data
var prices = {
  '15_oz': {
    lin_pr: {
      size_5: {
        price: 4.05,
        label: '5\' with 1 3" Hem (58") or 4" Hem',
      },
      size_6: {
        price: 4.86,
        label: '6\' with 1 3" Hem (69") or 4" Hem',
      },
      size_9: {
        price: 7.28,
        label: '9\' with 1 3" Hem (105") or 4" Hem',
      },
      size_12: {
        price: 9.71,
        label: '12\' with 1 3" Hem (141") or 4" Hem (140")',
      },
      size_custom: {
        price: 0.81,
        label: 'Custom Size (price x total sq ft)',
      },
    },
    him: 0.54,
    pocket: 1.92,
    web: 0.55,
  },
  '18_oz': {
    lin_pr: {
      size_5: {
        price: 5.04,
        label: '5\' with 1 3" Hem (58") or 4" Hem',
      },
      size_6: {
        price: 6.05,
        label: '6\' with 1 3" Hem (69") or 4" Hem',
      },
      size_9: {
        price: 9.07,
        label: '9\' with 1 3" Hem (105") or 4" Hem',
      },
      size_12: {
        price: 12.1,
        label: '12\' with 1 3" Hem (141") or 4" Hem (140")',
      },
      size_custom: {
        price: 1.01,
        label: 'Custom Size (price x total sq ft)',
      },
      
    },
    him: 0.61,
    pocket: 2.16,
    web: 0.55,
  },
};

var prices_roll = {
  '18_oz': {    
    roll_pr: {
      size_96: {
        price: 4.05,
        label: '10\'3" width (96" trailer width)',
      },
      size_99: {
        price: 4.86,
        label: '10\'6" width (99" trailer width)',
      },
      size_102: {
        price: 7.28,
        label: '10\'9" width (102" trailer width)',
      }      
    },
    ele: 0.54
  },
  '22_oz': {    
    roll_pr: {
      size_96: {
        price: 4.05,
        label: '10\'3" width (96" trailer width)',
      },
      size_99: {
        price: 4.86,
        label: '10\'6" width (99" trailer width)',
      },
      size_102: {
        price: 7.28,
        label: '10\'9" width (102" trailer width)',
      }      
    },
    ele: 0.54
  },
  
};
