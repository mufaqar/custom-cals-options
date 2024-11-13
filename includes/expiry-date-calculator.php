<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Shortcode to display expiry date calculator
function custom_expiry_date_calculator() {
    ob_start();
    ?>
    <div class="expiry-date-calculator">
        <h3>Calculate Your Exp Dates!</h3>
        <p>Select the exp date printed on your boxes:</p>
        
        <form id="expiry-date-form">
            <label for="expiry-month">Month:</label>
            <select id="expiry-month">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?php echo $m; ?>"><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
                <?php endfor; ?>
            </select>

            <label for="expiry-year">Year:</label>
            <select id="expiry-year">
                <?php for ($y = date('Y'); $y <= date('Y') + 10; $y++): ?>
                    <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                <?php endfor; ?>
            </select>
            
            <button type="button" id="calculate-expiry">Calculate</button>
        </form>

        <p id="expiry-result"></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('expiry_date_calculator', 'custom_expiry_date_calculator');
