TableOrder.service("UrlMaker", ["QueryStringMaker", function(QueryStringMaker) {
    this.getRestaurantScopeReservationUrl = function(scope){
        var url = "";
        var path = "/search/concrete-restaurant";
        var queryString = this.getQueryString(scope);
        queryString += "&behavior=restaurant";

        url += path + queryString;

        return url;
    }

    this.getRestaurantGroupReservationUrl = function(scope) {
        var url = "";
        var path = "/search/restaurant-group";
        var queryString = this.getQueryString(scope);
        queryString += "&behavior=restaurantGroup";

        url += path + queryString;

        return url;
    }

    this.getQueryString = function(scope) {
        var queryString = "?reservationTime=" + QueryStringMaker.getTime(scope);
        queryString += "&reservationDate=" + QueryStringMaker.getDate(scope);
        queryString += "&restaurantName=" + scope.restaurantName;
        queryString += "&restaurantId=" + scope.restaurantId;
        queryString += "&personAmount=" + scope.personAmount;
        queryString += "&location=" + scope.location;

        return queryString;
    }
}]);
