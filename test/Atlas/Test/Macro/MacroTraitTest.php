<?php
namespace Buttress\Atlas\Test\Macro;

use Buttress\Atlas\Exception\BadMethodCallExceptionMap;

class MacroTraitTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        MacroTestObject::clearMacros();
    }

    public function testMacroExists()
    {
        $this->assertFalse(MacroTestObject::macroExists('someFakeMacro'), 'Macro shouldn\'t exist.');

        MacroTestObject::macro('someFakeMacro', function() {});
        $this->assertTrue(MacroTestObject::macroExists('someFakeMacro'), 'Macro should exist.');
    }

    public function testStaticMacro()
    {
        $hit = false;

        $method = 'testAccess';

        MacroTestObject::macro($method, function() use (&$hit) {
            $hit = true;
        });

        $this->assertFalse($hit, 'Static macro accessed early.');

        call_user_func(['\Buttress\Atlas\Test\Macro\MacroTestObject', $method]);

        $this->assertTrue($hit, 'Static macro accessor failed.');
    }

    public function testInstanceMacro()
    {
        $hit = false;
        $macro = new MacroTestObject();

        $method = 'testAccess';

        $macro::macro($method, function() use (&$hit) {
            /** @type MacroTestObject $this */
            $hit = true;
        });

        $this->assertFalse($hit, 'Instance macro accessed early.');

        call_user_func([$macro, $method]);

        $this->assertTrue($hit, 'Instance macro accessor failed.');
    }

    public function testStaticErrorCase()
    {
        $caught = false;
        try {
            MacroTestObject::someFakeMethod();
        } catch (BadMethodCallExceptionMap $e) {
            $caught = true;
        }

        $this->assertTrue($caught, 'Instance isn\'t erroring properly!');
    }

    public function testInstanceErrorCase()
    {
        $caught = false;
        try {
            $macro = new MacroTestObject();
            $macro->someFakeMethod();
        } catch (BadMethodCallExceptionMap $e) {
            $caught = true;
        }

        $this->assertTrue($caught, 'Instance isn\'t erroring properly!');
    }

}
