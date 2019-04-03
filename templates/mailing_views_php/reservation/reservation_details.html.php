<html>
    <body>
        <h3>Dear <?= $user->getFirstName() . " " . $user->getLastName() ?> here is your reservation details</h3>
        <div class="restaurant">
            <h4>Restaurant</h4>
            <span>Restaurant Name: </span><?= $reservation->getRestauran()->getName() ?>

            <br>
            <span>Restaurant Location: </span> <?= $reservation->getRestauran()->getLocation() ?>
        </div>

        <div class="Reservation">
            <h4>Reservation</h4>
            <span>Time And Date: </span> <?= $reservation->getReservationTime()->format("H:i:s") . " " . $reservation->getReservationDate()->format("Y-m-d") ?>

            <br>
            <span>Amount of Time: </span> <?= $reservation->getAmountOfTime() . " minutes"?>

            <br>
            <span>Table Number: </span> <?= $reservation->getTableNumber() ?>
        </div>

        <div>
            <p>For more details visit <a href="https://www.gasparyan.com/me">your page in TableOrder</a></p>
        </div>
    </body>
</html>