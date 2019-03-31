TableOrder.service("CommentHandler", ["$http", function($http){
    this.addComment = function(scope, url){
        $http({
            method: "POST",
            url: url,

            data: {
                "comment": scope.comment
            },

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }

        }).then(function successCallback(response) {

            if (response.data["status"]) {
                $('#commentSubmitted').show();
            }

            else {
                $('#submitError').show();
            }

        }, function errorCallback(response) {
            console.log('error');
        })
    }
}]);