define([], function () {
    let address = '';

    return {
        setAddress: function (addressString) {
            address = addressString;
        },

        getAddress: function () {
            return address;
        }
    }
});

