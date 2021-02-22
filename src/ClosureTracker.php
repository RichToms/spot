<?php

namespace RichToms\Spot;

use Closure;

class ClosureTracker
{
    /**
     * The subject of the tracker.
     *
     * @var \Closure
     */
    protected $subject;

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
        $this->subject = $subject;

        $start = microtime(true);
        $memBefore = memory_get_usage();

        $this->result = $this->subject(...$params);

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
}
