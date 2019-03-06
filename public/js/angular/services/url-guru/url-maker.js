TableOrder.service("UrlMaker", ["QueryStringMaker", function(QueryStringMaker) {
    this.getRestaurantScopeReservationUrl = function(scope){
        var url = "";
        var path = "/search/concrete-restaurant";
        var queryString = "?reservationTime=" + QueryStringMaker.getTime(scope);
        queryString += "&reservationDate=" + QueryStringMaker.getDate(scope);
        queryString += "&restaurantName=" + scope.restaurantName;
        queryString += "&restaurantId=" + scope.restaurantId;
        queryString += "&personAmount=" + scope.personAmount;
        queryString += "&behavior=restaurant";

        url += path + queryString;

        return url;
    }
}]);