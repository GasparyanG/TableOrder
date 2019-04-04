TableOrder.service("NotificationHandler", ["$http", "NotificationViewHandler", function($http, NotificationViewHandler) {
    this.markAsRead = function() {
        $http({
            method: "POST",
            url: "/me/notifications/delete"
        }).then(function successCallback(response) {
            if (response.data["deleted"]) {
                NotificationViewHandler.removeBadgesAndNotifications();
            }

            else {
                console.log("Checkout notificationHandler.js file to see why badge don't removed!")
            }

        }, function errorCallback(response){
            console.log("error");
        })
    }
}]);