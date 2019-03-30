TableOrder.service("BookmarkHandler", ["BookmarkView","$http", function(BookmarkView, $http) {
    this.bookmark = function(url) {
        $http({
            method: 'POST',
            url: url
        }).then(function successCallback(response) {
            console.log(response.data);
            if (response.data) {
                BookmarkView.addBookmark();
            }

            else {
                BookmarkView.removeBookmark();
            }
        }, function errorCallback(response) {
            console.log("error");
        })
    }
}]);