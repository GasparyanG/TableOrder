TableOrder.controller("RestaurantGroupCtrl", ["$scope", "$http", "QueryStringMaker", "UrlMaker", function($scope, $http, QueryStringMaker, UrlMaker){
    $('#noTableLeft').hide();
    $('#errorWhileSearching').hide();

    $scope.findTableGroup = function(){
        // this portion defined here will ensure that every time when this button is pressed
        // alerts will be hidden
        $('#noTableLeft').hide();
        $('#errorWhileSearching').hide();

        $http({
            method:"GET",
            url: QueryStringMaker.getQueryStringForAjaxRequest($scope, "/search/ajax/restaurant-group")
        }).then(function successCallback(response) {
            var tableState = response.data.tableState;
            // some error occurred
            if (tableState === null) {
                $('#errorWhileSearching').show();
            }
            // no table found
            else if (!tableState) {
                $('#noTableLeft').show();
            }

            // tables are found: redirect
            else if (tableState) {
                window.location.href = UrlMaker.getRestaurantGroupReservationUrl($scope);
            }
        }, function errorCallback(response) {
            console.log("error");
        })
    }
}]);