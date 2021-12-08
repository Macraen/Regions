var config = {
    map: {
        '*': {
            addressSearch: 'CepdTech_Regions/js/address-search',
            addressModel: 'CepdTech_Regions/js/address-model'
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'CepdTech_Regions/js/mixin/catalog-add-to-cart': true
            }
        }
    }
};
