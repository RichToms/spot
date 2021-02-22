<?php

namespace RichToms\Spot;

class Tracker
{
    /**
     * The subject of the tracker.
     *
     * @var mixed
     */
    protected $subject;

    /**
     * List of all events in this tracking session.
     *
     * @var array
     */
    protected $events = [];

    /**
     * The current result of the latest call.
     *
     * @var mixed
     */
    public $result;

    /**
     * Create a new instance of the tracker.
     *
     * @param  mixed  $subject
     * @return void
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Forward any calls to the tracker to the subject.
     *
     * @param  string  $method
     * @param  array  $params
     * @return $this
     */
    public function __call($method, $params)
    {
        $start = microtime(true);
        $memBefore = memory_get_usage();

        $this->result = $this->subject->{$method}(... $params);
        $this->events[] = [
            'method' => $method,
            'params' => $params,
            'timing' => [
                'start' => $start,
                'end' => microtime(true),
            ],
            'memory' => [
                'start' => $memBefore,
                'end' => memory_get_usage(),
            ],
        ];

        return $this;
    }
}
