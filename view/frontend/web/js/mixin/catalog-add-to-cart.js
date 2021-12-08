define([
    "jquery",
    "Magento_Ui/js/modal/modal",
    "addressModel"
], function ($, modal, addressModel) {
    'use strict';

    return function (targetWidget) {
        $.widget('mage.catalogAddToCart', targetWidget, {
            options: {
                modalContent: '[data-search="container"]'
            },

            ajaxSubmit: function (form) {
                debugger;
                if (!addressModel.getAddress()) {
                    this.openModal();
                    return;
                }

                this._super(form);
            },

            openModal: function () {
                let modalElem = $(this.options.modalContent);

                modal({
                    type: 'popup',
                    responsive: true,
                    title: '',
                    buttons: []
                }, modalElem);

                modalElem.modal('openModal');
            }
        });

        return $.mage.catalogAddToCart;
    };
});
