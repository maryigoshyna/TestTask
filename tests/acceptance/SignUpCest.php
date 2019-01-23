<?php
use Page\SignUp;

/**
 * Sign up form testing
 */
class SignUpCest
{
    /**
     * Insly address field
     *
     * @var string
     */
    protected $inslyAdress;

    /**
     * Check that blocks looks like adminBlock.png
     *
     * @param  AcceptanceTester $I
     * @throws Exception
     */
    public function checkAdminAccountBlockScreen(AcceptanceTester $I)
    {
        $I->amOnPage(SignUp::$url);
        $I->dontSeeVisualChanges('adminBlock', SignUp::$mainForm);
    }

    /**
     * Check sign up
     *
     * @param  AcceptanceTester $I
     * @throws Exception
     */
    public function checkSignUpForm(AcceptanceTester $I)
    {
        $companyName = $I->getFaker()->company;

        $I->amOnPage(SignUp::$url);
        $I->see('Sign up and start using', 'h1');
        $this->fillCompanyBlock($I, $companyName);
        $this->fillAdminAccountBlock($I);
        $this->fillTermsAndConditionsBlock($I);
        $this->checkStatusValidation($I);
        $I->click(SignUp::$submit);
        $I->waitForText('Saving data');
        $I->waitForText('Wait a little bit');
        $I->waitPageLoad();

        $currentUrl = $I->getCurrentUrl();

        $I->assertEquals('https://' . $this->inslyAdress . '.insly.com/dashboard', $currentUrl);
    }

    /**
     * Fill company block
     *
     * @param  AcceptanceTester $I
     * @param  string           $companyName
     * @throws Exception
     */
    protected function fillCompanyBlock(AcceptanceTester $I, $companyName)
    {
        // fill country name
        $I->fillField(SignUp::$companyName, $companyName);
        $I->assertEquals($companyName, SignUp::getValue($I, SignUp::$companyName));
        // choose country
        $this->getSelectedValue($I, SignUp::$country);

        // check filled Insly address
        $this->inslyAdress = SignUp::getValue($I, SignUp::$inslyAdress);

        $I->assertNotNull($this->inslyAdress, "Address is empty");
        // choose company profile
        $this->getSelectedValue($I, SignUp::getCompanyField('profile'));
        // choose number of employees
        $this->getSelectedValue($I, SignUp::getCompanyField('employees'));
        // choose description of yourself
        $this->getSelectedValue($I, SignUp::getCompanyField('description'));
    }

    /**
     * Fill Administrator account details block
     *
     * @param  AcceptanceTester $I
     * @throws Exception
     */
    protected function fillAdminAccountBlock(AcceptanceTester $I)
    {
        $email       = $I->getFaker()->email;
        $managerName = $I->getFaker()->name;
        $phone       = $I->getFaker()->phoneNumber;

        // fill work email
        $I->fillField(SignUp::$email, $email);
        // fill account manager name
        $I->fillField(SignUp::$managerName, $managerName);
        // fill phone
        $I->fillField(SignUp::$phone, $phone);
        // click secure password
        $I->click(SignUp::$passwSuggest);
        $I->click(SignUp::$okButton);

        // check filled password
        $password        = SignUp::getValue($I, SignUp::$passw);
        $repeatePassword = SignUp::getValue($I, SignUp::$repeatePassw);

        $I->assertNotNull($password);
        $I->assertNotNull($repeatePassword);
        $I->assertEquals($password, $repeatePassword);
    }

    /**
     * Agreement with all Terms and conditions
     *
     * @param  AcceptanceTester $I
     * @throws Exception
     */
    protected function fillTermsAndConditionsBlock(AcceptanceTester $I)
    {
        $allConditions = [
            SignUp::$termsAndConditions,
            SignUp::$privacyPolicy,
            SignUp::$dataProcessing
        ];

        for ($i = 0; $i < count($allConditions); $i ++)
        {
            $I->click(SignUp::getEmptyCheck($allConditions[$i]));
            $I->seeElement(SignUp::getCheckedField($allConditions[$i]));
        }

        $I->click(SignUp::$termsAndConditionsLink);
        $I->click(SignUp::$agreeButton);
        $I->click(SignUp::$privacyPolicyLink);
        $I->waitForElementVisible(SignUp::$privacyPolicyForm);

        $scrollObj = sprintf(
            '
            obj = document.querySelector("%s");
            obj.scrollTop = obj.scrollHeight;
        ',
        SignUp::$privacyPolicyForm
        );

        $I->executeJS($scrollObj);
        $I->click(SignUp::$privacyPolicyCloseIcon);
        $I->waitForElementNotVisible(SignUp::$submit . '[disabled]');
    }

    /**
     * Check all status of field validation
     *
     * @param  AcceptanceTester $I
     * @throws Exception
     */
    protected function checkStatusValidation(AcceptanceTester $I)
    {
        $allStatus = [
            'name',
            'country',
            'address',
            'email',
            'manager',
            'phone'
        ];

        for ($i = 0; $i < count($allStatus); $i ++)
        {
            $I->waitForElementVisible(SignUp::getStatusOk($allStatus[$i]));
        }
    }

    /**
     * Choose value from list depending on field
     *
     * @param  AcceptanceTester $I
     * @param  string           $selectField
     * @throws Exception
     */
    protected function getSelectedValue(AcceptanceTester $I, $selectField)
    {
        $I->click($selectField);

        $allValues = $I->grabMultiple($selectField . ' option', 'value');
        $allValues = array_diff($allValues, array('', NULL, false));
        $value     = $allValues[array_rand($allValues)];
        $valueName = $I->grabTextFrom(SignUp::getValueFromList($selectField, $value));

        $I->click(SignUp::getValueFromList($selectField, $value));
        $I->click($selectField);

        $selectedField = SignUp::getValue($I, $selectField);

        $I->assertEquals($value, $selectedField);
        $I->see($valueName);
    }
}
