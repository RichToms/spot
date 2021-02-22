<?php

namespace RichToms\Spot\Tests;

use PHPUnit\Framework\TestCase;
use RichToms\Spot\ClassTracker;
use RichToms\Spot\Tests\Helpers\ExampleClass;
use RichToms\Spot\Tests\Helpers\ExampleFluentClass;

class ClassTrackerTest extends TestCase
{
    /** @test */
    public function itCanBeInitialised()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $this->assertNotNull($tracker);
    }

    /** @test */
    public function itTracksMethodsCalledOnTheSubject()
    {
        $tracker = new ClassTracker(new ExampleClass());

        $this->assertCount(0, $tracker->getEvents());
        $tracker->run();
        $this->assertCount(1, $tracker->getEvents());
    }

    /** @test */
    public function itTracksMultipleCallsToTheSameMethodOnTheSubject()
    {
        $tracker = new ClassTracker(new ExampleClass());

        $this->assertCount(0, $tracker->getEvents());
        $tracker->run();
        $this->assertCount(1, $tracker->getEvents());
        $tracker->run();
        $this->assertCount(2, $tracker->getEvents());
    }

    /** @test */
    public function itReturnsAnArrayOfEvents()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $this->assertEquals('array', gettype($tracker->getEvents()));

        $tracker->run();
        $this->assertEquals('array', gettype($tracker->getEvents()));
    }

    /** @test */
    public function itTracksTheLatestResult()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $result1 = 123;

        $tracker->return($result1);
        $this->assertEquals($result1, $tracker->getResult());

        $result2 = 321;
        $tracker->return($result2);
        $this->assertEquals($result2, $tracker->getResult());
    }

    /** @test */
    public function itCanTrackBothFluentAndSequentialCalls()
    {
        $tracker = new ClassTracker(new ExampleFluentClass());

        $tracker->fluent()->another();
        $this->assertCount(2, $tracker->getEvents());
    }

    /** @test */
    public function itTracksTheMethodNamesCalled()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $tracker->run();
        $tracker->return(null);

        $events = $tracker->getEvents();
        $this->assertEquals('run', $events[0]['method']);
        $this->assertEquals('return', $events[1]['method']);
    }

    /** @test */
    public function itTracksTheParametersPassedToCalledMethods()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $someVariable = 321;
        $tracker->return($someVariable);

        $events = $tracker->getEvents();
        $this->assertEquals([$someVariable], $events[0]['params']);
    }

    /** @test */
    public function itTracksTheTimeTheProcessStartedAndEnded()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $tracker->run();

        $event = $tracker->getEvents()[0];
        $this->assertTrue(array_key_exists('timing', $event));

        $timing = $event['timing'];
        $this->assertTrue(array_key_exists('start', $timing));
        $this->assertTrue(array_key_exists('end', $timing));

        $this->assertEquals('double', gettype($timing['start']));
        $this->assertEquals('double', gettype($timing['end']));
    }

    /** @test */
    public function itTracksTheMemoryInUseWhenTheProcessStartedAndEnded()
    {
        $tracker = new ClassTracker(new ExampleClass());
        $tracker->run();

        $event = $tracker->getEvents()[0];
        $this->assertTrue(array_key_exists('memory', $event));

        $memory = $event['memory'];
        $this->assertTrue(array_key_exists('start', $memory));
        $this->assertTrue(array_key_exists('end', $memory));

        $this->assertEquals('integer', gettype($memory['start']));
        $this->assertEquals('integer', gettype($memory['end']));
    }
}
