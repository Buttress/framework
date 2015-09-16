<?php
namespace Buttress\Test\Logger\Driver;

use Buttress\Logger\Driver\MonoLogDriver;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonoLogDriverTest extends \PHPUnit_Framework_TestCase
{

    /** @type MonoLogDriver */
    protected $driver;

    protected function setUp()
    {
        $driver = new MonoLogDriver();
        $logger = new Logger('Buttress Test');
        $driver->setLogger($logger);

        $this->driver = $driver;
    }

    public function testLoggingLevels()
    {
        $test_handler = new TestHandler();
        $this->driver->getLogger()->setHandlers(array($test_handler));

        $levels = array_map('strtoupper', (new \Buttress\Logger\Logger())->getLevels());

        foreach ($levels as $level) {
            $this->driver->log($real_level = constant(\Monolog\Logger::class . "::{$level}"), $message = 'INFO');

            $result = $test_handler->hasRecordThatPasses(function($record) use ($message) {
                return $record['message'] = $message;
            }, $real_level);

            $this->assertTrue($result, "Logger didn't output for {$level}.");
        }
    }

}
