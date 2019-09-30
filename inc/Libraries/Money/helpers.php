<?php

if (! function_exists('moneyFormat')) {
/**
     * Format number to a particular currency.
     *
     * @param float Amount to format
     * @param string Currency
     * @return string
     */
    function moneyFormat( $amount, $currency )
    {
        $money = new Opal_Job\Libraries\Money\Money( $amount, $currency );

        return $money->format();
    }
}
