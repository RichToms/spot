<?php

namespace RichToms\Spot;

use Closure;
use RichToms\Spot\Contracts\Tracker as TrackerContract;

class ClosureTracker implements TrackerContract
{
    /**
     * List of all events in this tracking session.
     *
     * @var array
     */
    protected $events = [];

    /**
     * The result of the latest call.
     *
     * @var mixed
     */
    public $result;

    /**
     * Create a new instance of the tracker.
     *
     * @param  \Closure  $subject
     * @param  array  $params
     * @return void
     */
    public function __construct(Closure $subject, $params = [])
    {
        $start = microtime(true);
        $memBefore = memory_get_usage();

        $this->result = $subject(...$params);

        $this->events[] = [
            'method' => 'Closure',
            'params' => $params,
            'timing' => [
                'start' => $start,
                'end' => microtime(true),
            ],
            'memory' => [
                'start' => $memBefore,
                'end' => memory_get_usage(),
            ]
        ];
    }

    /**
     * Retrieve a list of all events.
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Retrieve the known result of the tracker.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
