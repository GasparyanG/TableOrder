<?php

namespace App\Service\BaseLayout\ComposingProducts;

use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;

// DEV
use App\Service\NotificationCenter\Preparing\NotificationPreparingInterface;
use App\Service\User\Data\Composed\UserDataComposerInterface;
use Psr\Log\LoggerInterface;

/*
 * Template pattern: composeData will call some methods, which can be overridden in derived classes!
 * Because of that fact properties and methods are protected and not private.
*/
class ClientDataComposer implements ClientDataComposerInterface
{
    protected $templatingConfigFetcher;
    protected $baseLayoutSupplier;
    protected $clientRequiredData;
    protected $userDataComposer;
    protected $notificationPreparing;

    public function __construct(BaseLayoutSupplierInterface $baseLayoutSupplier,
                                TemplatingConfigFetcherInterface $templatingConfigFetcher,
                                LoggerInterface $logger,
                                UserDataComposerInterface $userDataComposer,
                                NotificationPreparingInterface $notificationPreparing)
    {
        // hero of this class
        $this->clientRequiredData = [];

        $this->templatingConfigFetcher = $templatingConfigFetcher;
        $this->baseLayoutSupplier = $baseLayoutSupplier;
        $this->userDataComposer = $userDataComposer;
        $this->notificationPreparing = $notificationPreparing;

        // DEV
        $this->logger = $logger;
    }

    public function composeData(): array
    {
        $this->addPersonAmount();
        $this->addCities();
        $this->addUser();
        $this->addNotificationsData();
        $this->addSearchState();
        // some methods can be abstractly defined and called here: successors of this class will override them.

        return $this->clientRequiredData;
    }

    protected function addPersonAmount(): void
    {
        $personAmountKey = $this->templatingConfigFetcher->getPersonAmount();

        $this->clientRequiredData[$personAmountKey] = $this->baseLayoutSupplier->getPersonAmount();
    }

    protected function addCities(): void
    {
        $citiesKey = $this->templatingConfigFetcher->getCities();

        $this->clientRequiredData[$citiesKey] = $this->baseLayoutSupplier->getLocation();
    }

    protected function addUser(): void
    {
        $userKey = $this->templatingConfigFetcher->getUser();

        $this->clientRequiredData[$userKey] = $this->userDataComposer->composeData();
    }

    protected function addNotificationsData(): void
    {
        $notificationDataKey = $this->templatingConfigFetcher->getNotificationData();

        $notificationsData = $this->notificationPreparing->getNotifications();
        $this->clientRequiredData[$notificationDataKey] = $notificationsData;
    }

    protected function addSearchState(): void
    {
        $searchStateKey = $this->templatingConfigFetcher->getSearchState();

        $this->clientRequiredData[$searchStateKey] = true;
    }
}