define([
    'jquery',
    'mage/validation'
], function ($, validation) {
    "use strict";

    $.widget('mage.recentListing', {
        options: {
            url: '',
            product_id: 0
        },
        /**
         * Initialize recentListing widget
         *
         * @private
         */
        _init: function () {
            this._initializeListing();
        },
        /**
         * Initialize listing after load
         *
         * @private
         */
        _initializeListing: function () {
            this._requestListing();
        },
        /**
         * Request listing html using ajax to bypass caching
         *
         * @private
         */
        _requestListing: function () {
            var url = this.options.url;
            var productId = this.options.product_id;
            var destinationElement = this.element;

            $.ajax({
                url: url,
                type: 'GET',
                showLoader: false,
                data: {product_id: productId},
                success: function (response) {
                    destinationElement.html(response);
                }
            });
        }
    });

    return $.mage.recentListing;
});