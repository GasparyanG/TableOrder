// -[] request directory need to be dynamic

TableOrder.service("QueryStringMaker", [function() {
    this.getQueryStringForAjaxRequest = function(scope, path) {
        var date = this.getDate(scope);
        var time = this.getTime(scope);

        var url = path + "?" ;
        url += "restaurantId=" + scope.restaurantId;
        url += "&restaurantName=" + scope.restaurantName;
        url += "&behavior=" + scope.behavior;
        url += "&reservationTime=" + time;
        url += "&reservationDate=" + date;
        url += "&location=" + scope.location;

        console.log(url);

        return url;
    };

    this.getDate = function(scope) {
        var date = "";
        var dateFromForm = new Date(scope.reservationDate);

        if (!dateFromForm) {
            return null;
        }

        return dateFromForm.toLocaleDateString();
    };

    this.getTime = function(scope) {
        var time = "";
        var timeFromForm = new Date(scope.reservationTime);

        if (!timeFromForm) {
            return null;
        }

        return timeFromForm.toLocaleTimeString();
    }
}]);