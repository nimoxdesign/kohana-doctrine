<?php

namespace Kohana\Doctrine;

use Doctrine\Common\EventManager as DoctrineEventManager;
use Kohana;

class EventManager
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var DoctrineEventManager
     */
    private $eventManager;

    public function __construct()
    {
        $this->configuration = new Configuration;
        $this->eventManager = new DoctrineEventManager;
    }

    /**
     * @return DoctrineEventManager
     */
    public function configureEventManager()
    {
        $eventConfiguration = $this->configuration->get('event');

        foreach($eventConfiguration['listeners'] AS $listener => $events) {
            $this->eventManager->addEventListener((array) $events, new $listener());
        }

        foreach($eventConfiguration['subscribers'] AS $subscriber) {
            $this->eventManager->addEventSubscriber(new $subscriber());
        }

        return $this->eventManager;
    }
} 