TableOrder.service("BookmarkView", [function() {
    this.bookmarkId = "bookmark";
    this.highlightingClass = "text-warning";

    this.addBookmark = function(){
        var bookmark = document.getElementById(this.bookmarkId);

        bookmark.classList.add(this.highlightingClass);
    };

    this.removeBookmark = function() {
        var bookmark = document.getElementById(this.bookmarkId);

        bookmark.classList.remove(this.highlightingClass);
    }
}]);