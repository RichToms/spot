<?php

namespace RichToms\Spot\Tests;

use PHPUnit\Framework\TestCase;
use RichToms\Spot\ClosureTracker;

class ClosureTrackerTest extends TestCase
{
    /** @test */
    public function itCanBeInitialised()
    {
        $tracker = new ClosureTracker($this->getExampleReturningClosure());
        $this->assertNotNull($tracker);
    }

    /** @test */
    public function itReturnsAnArrayOfEvents()
    {
        $tracker = new ClosureTracker($this->getExampleReturningClosure());
        $this->assertEquals('array', gettype($tracker->getEvents()));
    }

    /** @test */
    public function itTracksTheResult()
    {
        $expectedResult = 5;
        $tracker = new ClosureTracker($this->getExampleReturningClosure($expectedResult));

        $this->assertEquals($expectedResult, $tracker->getResult());
    }

    /** @test */
    public function itTracksTheEventOfRunningTheClosure()
    {
        $tracker = new ClosureTracker($this->getExampleReturningClosure());
        $this->assertCount(1, $tracker->getEvents());
    }

    /** @test */
    public function itTracksTheTimeTheProcessStartedAndEnded()
    {
        $tracker = new ClosureTracker($this->getExampleReturningClosure());
        $event = $tracker->getEvents()[0];

        $this->assertTrue(array_key_exists('timing', $event));

        $timing = $event['timing'];
        $this->assertTrue(array_key_exists('start', $timing));
        $this->assertTrue(array_key_exists('end', $timing));

        $this->assertEquals('double', gettype($timing['start']));
        $this->assertEquals('double', gettype($timing['end']));
    }

    /** @test */
    public function itTracksTheMemoryInUseWhenTheClosureStartedAndEnded()
    {
        $tracker = new ClosureTracker($this->getExampleReturningClosure());
        $event = $tracker->getEvents()[0];

        $this->assertTrue(array_key_exists('memory', $event));

        $memory = $event['memory'];
        $this->assertTrue(array_key_exists('start', $memory));
        $this->assertTrue(array_key_exists('end', $memory));

        $this->assertEquals('integer', gettype($memory['start']));
        $this->assertEquals('integer', gettype($memory['end']));
    }

    /** @test */
    public function itPassesParamsToClosures()
    {
        $parameters = [5];
        $tracker = new ClosureTracker($this->getClosureWithOneParameter(), $parameters);

        $this->assertEquals($parameters[0], $tracker->getResult());

        $event = $tracker->getEvents()[0];
        $this->assertEquals($parameters, $event['params']);

        $parameters = [1, 2, 3, 4];
        $tracker = new ClosureTracker($this->getClosureWithManyParameters(), $parameters);
        $event = $tracker->getEvents()[0];
        $this->assertEquals($parameters, $event['params']);
    }

    /**
     * Get an example Closure that returns a given value.
     *
     * @param  mixed  $return
     * @return \Closure
     */
    private function getExampleReturningClosure($return = null)
    {
        return function () use ($return) {
            return $return;
        };
    }

    /**
     * Get an example Closure that requires one parameter.
     *
     * @return \Closure
     */
    private function getClosureWithOneParameter()
    {
        return function ($parameter) {
            return $parameter;
        };
    }

    /**
     * Get an example Closure that requires many parameters.
     *
     * @return \Closure
     */
    private function getClosureWithManyParameters()
    {
        return function ($a, $b, $c, $d) {
            return;
        };
    }
}
