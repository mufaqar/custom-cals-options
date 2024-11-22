<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Shortcode to display expiry date calculator
function custom_expiry_date_calculator() {
    ?>
<div class="expiry-date-calculator">
    <div class="outer">
        <div class="calc">
            <p><strong>Calculate Your Exp Dates!</strong></p>
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
                <p><button type="button" id="calculate-expiry">Calculate</button></p>
            </form>

            <p id="expiry-result"></p>
        </div>

        <!-- Additional Options -->
        <div class="additional-options">
            <p><strong>Expiration Date:</strong></p>
            <label>
                <input type="radio" name="expiration-date" value="10+ months">
                10+ months
            </label><br>
            <label>
                <input type="radio" name="expiration-date" value="7-9 months">
                7-9 months
            </label><br>
            <label>
                <input type="radio" name="expiration-date" value="6-8 months">
                6-8 months
            </label><br>
            <label>
                <input type="radio" name="expiration-date" value="1-5 months">
                1-5 months
            </label>
        </div>

        <div class="condition-options">
            <p><strong>Condition:</strong></p>
            <label>
                <input type="radio" name="condition" value="Mint">
                Mint (Perfect No Damage)
            </label><br>
            <label>
                <input type="radio" name="condition" value="Good">
                Good (Label Residue)
            </label>

            <label>
                <input type="radio" name="condition" value="Damaged/Stained">
                Damaged/Stained
            </label>


        </div>
        <!-- Dynamic Price Display -->
        <div id="dynamic-price" style="margin-top: 15px; font-weight: bold;"></div>


    </div>
</div>
<?php
}