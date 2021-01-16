define([
    'jquery',
    'underscore',
    'mage/translate'
], function ($, _, $t) {
    "use strict";

    /**
     * Get customer product special price on catalog page
     */
    $.widget('steven.productSpecialPrice', {
        options: {
            getPriceAction: 'special_price/price/getList',
            priceLabel: $t('Your price: ')
        },

        /**
         * @private
         */
        _create: function () {
            this._getProductSpecialPrice();
        },

        /**
         * Ajax call for getting products special price
         *
         * @private
         */
        _getProductSpecialPrice: function () {
            let self = this;
            $(document.body).trigger('processStart');

            $.ajax({
                type: 'GET',
                url: self.options.getPriceAction,

                /**
                 * @inheritDoc
                 */
                error: function () {
                    location.reload();
                },

                /**
                 * @inheritDoc
                 */
                success: function (response) {
                    if (response.result) {
                        _.each(response.result, function (data) {
                            let specialPriceElement = $('<br><span class="product-special-price">' + self.options.priceLabel + '</span>').append(data.price);
                            $('[data-product-id=' + data.product_id + ']').append(specialPriceElement);
                        });
                    }
                },
            }).always(function () {
                $(document.body).trigger('processStop');
            });
        }
    });

    return $.steven.productSpecialPrice;
});
