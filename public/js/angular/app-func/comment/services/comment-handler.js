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
            console.log(response.data);
        }, function errorCallback(response) {
            console.log('error');
        })
    }
}]);