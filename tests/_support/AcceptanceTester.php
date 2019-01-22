<?php
use Faker\Factory;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions {
        click as protected doClick;
        fillField as protected doFillField;
    }

    /**
     * @const Max time for waiting
     */
    const MAX_TIMEOUT = 20;

    /**
     * Return object of Faker
     *
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        $faker = Factory::create('en_GB');

        return $faker;
    }

    /**
     * Click button
     *
     * @param string $link
     * @param string $context
     * @param int $timeout
     * @throws Exception
     */
    public function click($link, $context = null, $timeout = self::MAX_TIMEOUT)
    {
        $this->waitForElementVisible($link, $timeout);
        $this->doClick($link, $context);

    }

    /**
     * Fill field
     *
     * @param string $field
     * @param string $value
     * @param int    $timeout
     * @throws Exception
     */
    public function fillField($field, $value, $timeout = self::MAX_TIMEOUT)
    {
        $this->waitForElementVisible($field, $timeout);
        $this->doFillField($field, $value);
    }

    /**
     * Waiting for page loading
     *
     * @param int $timeout
     */
    public function waitPageLoad($timeout = self::MAX_TIMEOUT)
    {
        $this->waitForJS('return document.readyState == "complete"', $timeout);
        $this->waitForJS('return !!window.jQuery && window.jQuery.active == 0;', $timeout);
    }
}