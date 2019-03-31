TableOrder.service("RatingHandler", ["$http", "RatingResponseHandler", function($http, RatingResponseHandler) {
    this.rate = function(rating, url) {
        $http({
            method: "POST",
            url: url,

            data : {
                "rating": rating
            },

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function successCallback(response) {
            if (response.data["state"]) {
                RatingResponseHandler.success();
            }

            else {
                console.log("false");
            }
        }, function errorCallback(response) {
           console.log("error");
        });
    }
}]);