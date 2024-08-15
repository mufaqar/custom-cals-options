jQuery(document).ready(function ($) {
  function convertFeetToInches(feet) {
    return feet * 12;
  }

  function updatePriceAndConvertSize() {
    var basePrice = 0;
    var materialType = $('#curtain_material').val();
    var materialPrice = getMaterialPrice(materialType);
    var sizePrice = getSizePrice($('#curtain_size').val(), materialType);
    var lengthPrice = getLengthPrice($('#curtain_length').val());
    var secondHemPrice = $('#second_hem').is(':checked')
      ? getSecondHemPrice(materialType)
      : 0;
    var pipePocketPrice = $('#pipe_pocket').is(':checked')
      ? getPipePocketPrice(materialType)
      : 0;
    var webbingReinforcementPrice = $('#webbing_reinforcement').is(':checked')
      ? getWebbingReinforcementPrice(materialType)
      : 0;
    var customSizePrice = 0;

    if ($('#curtain_size option:selected').val() === 'custom') {
      var customWidthFeet = parseFloat($('#custom_width').val()) || 0;
      var customHeightFeet = parseFloat($('#custom_height').val()) || 0;

      customSizePrice = getCustomSizePrice(
        customWidthFeet,
        customHeightFeet,
        materialType
      );

      var customWidthInches = convertFeetToInches(customWidthFeet);
      var customHeightInches = convertFeetToInches(customHeightFeet);

      $('#custom_width_inches')
        .text(customWidthInches.toFixed(2) + ' inches')
        .show();
      $('#custom_height_inches')
        .text(customHeightInches.toFixed(2) + ' inches')
        .show();
    } else {
      $('#custom_width_inches').hide();
      $('#custom_height_inches').hide();
    }

    var totalPrice =
      basePrice +
      materialPrice +
      sizePrice +
      lengthPrice +
      secondHemPrice +
      pipePocketPrice +
      webbingReinforcementPrice +
      customSizePrice;

    $('#curtain_price').text('$' + totalPrice.toFixed(2));
  }

  function toggleCustomSizeFields() {
    if ($('#curtain_size option:selected').val() === 'custom') {
      $('.curtain-custom-size-fields').show();
    } else {
      $('.curtain-custom-size-fields').hide();
    }
    updatePriceAndConvertSize();
  }

  $(
    '#curtain_material, #curtain_size, #curtain_length, #custom_width, #custom_height, #second_hem, #pipe_pocket, #webbing_reinforcement'
  ).on('input change', updatePriceAndConvertSize);

  $('#curtain_size').change(toggleCustomSizeFields).change();

  updatePriceAndConvertSize();

  function getMaterialPrice(materialType) {
    var prices = {
      '15_oz': 15,
      '18_oz': 18,
      '22_oz': 22,
    };

    return prices[materialType] || 0;
  }

  function getSizePrice(sizeValue, materialType) {
    var prices = {
      size_1: { '15_oz': 4.05, '18_oz': 5.04, '22_oz': 5.04 },
      size_2: { '15_oz': 4.86, '18_oz': 6.05, '22_oz': 6.05 },
      size_3: { '15_oz': 7.28, '18_oz': 9.07, '22_oz': 9.07 },
      size_4: { '15_oz': 9.71, '18_oz': 12.1, '22_oz': 12.1 },
      size_5: { '15_oz': 50, '18_oz': 60, '22_oz': 60 },
      size_6: { '15_oz': 70, '18_oz': 80, '22_oz': 80 },
      size_7: { '15_oz': 90, '18_oz': 100, '22_oz': 100 },
      custom: { '15_oz': 0.81, '18_oz': 1.01, '22_oz': 1.01 },
    };

    var pr = {
      livestock: {
        '15_oz': {
          lin_pr: {
            size_5: 4.05,
            size_6: 4.86,
            size_9: 7.28,
            size_12: 9.71,
          },
          him: 0.54,
          pocket: 1.92,
          web: 0.4,
        },
        '18_oz': {
          lin_pr: {
            size_5: 5.04,
            size_6: 6.05,
            size_9: 9.07,
            size_12: 12.1,
          },
          him: 0.61,
          pocket: 2.16,
          web: 0.4,
        },
      },
      rollover: {
        '15_oz': {
          lin_pr: {
            size_5: 4.05,
            size_6: 4.86,
            size_9: 7.28,
            size_12: 9.71,
          },
          him: 0.54,
          pocket: 1.92,
          web: 0.4,
        },
        '18_oz': {
          lin_pr: {
            size_5: 5.04,
            size_6: 6.05,
            size_9: 9.07,
            size_12: 12.1,
          },
          him: 0.54,
          pocket: 1.92,
          web: 0.4,
        },
      },
    };

    return prices[sizeValue] ? prices[sizeValue][materialType] : 0;
  }

  function getLengthPrice(lengthValue) {
    var prices = {};
    for (var i = 11; i <= 50; i++) {
      prices[i.toString()] = i;
    }

    return prices[lengthValue] || 0;
  }

  function getSecondHemPrice(materialType) {
    var prices = {
      '15_oz': 0.54,
      '18_oz': 0.61,
      '22_oz': 0.61,
    };

    return prices[materialType] || 0;
  }

  function getPipePocketPrice(materialType) {
    var prices = {
      '15_oz': 1.92,
      '18_oz': 2.16,
      '22_oz': 2.16,
    };

    return prices[materialType] || 0;
  }

  function getWebbingReinforcementPrice() {
    return 0.4;
  }

  function getCustomSizePrice(widthFeet, heightFeet, materialType) {
    var squareFeet = widthFeet * heightFeet;
    var pricePerSquareFoot = {
      '15_oz': 0.81,
      '18_oz': 1.01,
      '22_oz': 1.01,
    };

    return squareFeet * (pricePerSquareFoot[materialType] || 0);
  }
});
