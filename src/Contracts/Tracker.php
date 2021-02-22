<?php

namespace RichToms\Spot\Contracts;

interface Tracker
{
    /**
     * Retrieve a list of all events.
     *
     * @return array
     */
    public function getEvents();

    /**
     * Retrieve the known result of the tracker.
     *
     * @return mixed
     */
    public function getResult();
}
