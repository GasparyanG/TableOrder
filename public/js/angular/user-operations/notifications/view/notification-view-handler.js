TableOrder.service("NotificationViewHandler", [function() {
    this.notificationBadgeId = "notification-badge";
    this.notificationsElId = "displayed-notifications";

    this.removeBadgesAndNotifications = function() {
        this.removeBadge();
        this.removeNotifications();
    };

    this.removeBadge = function() {
        var badgeEl = document.getElementById(this.notificationBadgeId);

        // removing from DOM
        badgeEl.parentNode.removeChild(badgeEl);
    };

    this.removeNotifications = function() {
        var notificationsEl = document.getElementById(this.notificationsElId);

        // removing from DOM
        notificationsEl.parentNode.removeChild(notificationsEl);
    };
}]);