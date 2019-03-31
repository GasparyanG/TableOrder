TableOrder.service("RatingResponseHandler", [function() {
    // see review/ratings.html.twig
    this.ratingSectionElementId = "rating-section";
    // see review/ratings.html.twig
    this.successElementId = "success";

    this.success = function() {
        var ratingSectionElement = document.getElementById(this.ratingSectionElementId);

        ratingSectionElement.parentNode.removeChild(ratingSectionElement);

        // creating new element, which already has css styling
        var successElement = document.getElementById(this.successElementId);

        var successElementContent = this.createSuccessElementContent();
        successElement.appendChild(successElementContent);
    };

    this.error = function() {
        // TODO: add error case behavior
    };

    this.createSuccessElementContent = function() {
        var divEl = document.createElement('div');

        // bootstrap class addition
        divEl.classList.add("text-center");
        divEl.classList.add("alert");
        divEl.classList.add("alert-success");

        // div element text content
        var headerEl = document.createElement('h4');
        var textNode = document.createTextNode("Rating is Submitted!");

        headerEl.appendChild(textNode);

        divEl.appendChild(headerEl);

        return divEl;
    }
}]);