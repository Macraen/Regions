define([], function () {
    let address = null;

    return {
        setAddress: function (addressString) {
            address = addressString;
        },

        getAddress: function () {
            return address;
        }
    }
});

