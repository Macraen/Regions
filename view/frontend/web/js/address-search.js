define([
    'jquery',
    'mage/translate',
    "Magento_Ui/js/modal/modal"
], function ($, $t, modal) {
    'use strict';

    $.widget('eskulap.addressSearch',{
        options: {
            country: '',
            apiKey: '',
            clearBtn: '[data-search="clear"]',
            errorContainer: '[data-search="error"]',
            hasError: false
        },

        _create: function () {
            let self = this,
                googleapis = 'https://maps.googleapis.com/maps/api/js?key=' + self.options.apiKey + '&libraries=places&language=en-US';

            require([
                googleapis
            ], function () {
                $.proxy(self.initAutocomplete(), self);
            });
        },

        initAutocomplete: function () {
            let self = this,
                options = {
                    types: ["address"]
                },
                autocomplete = null;

            if (self.options.country) {
                options.componentRestrictions = {country: self.options.country};
            }

            autocomplete = new google.maps.places.Autocomplete(
                self.element[0],
                options
            );

            this.initEvents(autocomplete);
        },

        initEvents: function (autocompleteInstance) {
            let self = this;

            self.element.siblings(self.options.clearBtn).on('click', function (e) {
                self.element.val('');
                if (self.options.hasError) {
                    $.proxy(self.removeErrorMessage(), self);
                }
            });

            autocompleteInstance.addListener('place_changed', function() {
                let place = autocompleteInstance.getPlace();

                if (place.address_components[0].types[0] !== "street_number") {
                    $.proxy(self.addErrorMessage($t("The address isn't correct. Please provide full one")), self);
                    return;
                }

                let placeData = {
                    customerDeliveryAddress: {
                            street: place.address_components[1].long_name + ' ' + place.address_components[0].long_name,
                            city: place.address_components[3].long_name,
                            country: place.address_components[6].long_name,
                            latitude: place.geometry.location.lat(),
                            longitude: place.geometry.location.lng()
                        }
                    }

                if (self.options.hasError) {
                    self.removeErrorMessage();
                }

                $.proxy(self.sendAjax(placeData), self);
            });
        },

        openModal: function () {
            console.log('modal');
        },

        sendAjax: function (data) {
            let self = this;

            $.ajax({
                url: 'rest/all/V1/regions/shop',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: 'json'
            }).done(function (response) {
                if (response.url) {
                    window.location.url = response.url;
                } else {
                    $.proxy(self.addErrorMessage(response.error), self);
                    response.error
                }
            }).fail(function (response) {

            });
        },

        addErrorMessage: function (message) {
            this.element.siblings(this.options.errorContainer).text(message);
            this.options.hasError = true;
        },

        removeErrorMessage: function () {
            this.element.siblings(this.options.errorContainer).empty();
            this.options.hasError = false;
        }
    });

    return $.eskulap.addressSearch;
});

