<?php
namespace Page;

/**
 * Elements on sign up page
 */
class SignUp
{
    /**
     * Main url
     *
     * @var string
     */
    public static $url = '/signup';

    /**
     * Sign-up form
     *
     * @var string
     */
    public static $mainForm = 'table.insly-form';

    /**
     * Company name field
     *
     * @var string
     */
    public static $companyName = '#broker_name';

    /**
     * Country field
     *
     * @var string
     */
    public static $country = '#broker_address_country';

    /**
     * Insly address field
     *
     * @var string
     */
    public static $inslyAdress = '#broker_tag';

    /**
     * Work email field
     *
     * @var string
     */
    public static $email = '#broker_admin_email';

    /**
     * Account manager name field
     *
     * @var string
     */
    public static $managerName = '#broker_admin_name';

    /**
     * Phone field
     *
     * @var string
     */
    public static $phone = '#broker_admin_phone';

    /**
     * Password suggestion link
     *
     * @var string
     */
    public static $passwSuggest = '//*[text()="suggest a secure password"]';

    /**
     * OK button in password suggestion form
     *
     * @var string
     */
    public static $okButton = '.ui-dialog-buttons .primary';

    /**
     * Password field
     *
     * @var string
     */
    public static $passw = '#broker_person_password';

    /**
     * Repeate password field
     *
     * @var string
     */
    public static $repeatePassw = '#broker_person_password_repeat';

    /**
     * Status OK icon
     *
     * @var string
     */
    public static $statusOk = ' .icon-ok';

    /**
     * Terms and conditions row
     *
     * @var string
     */
    public static $termsAndConditions = '#agree_termsandconditions';

    /**
     * Terms and conditions link
     *
     * @var string
     */
    public static $termsAndConditionsLink = '//*[text()="terms and conditions"]';

    /**
     * I agree button
     *
     * @var string
     */
    public static $agreeButton = '.ui-dialog-buttonset .primary';

    /**
     * Privacy policy row
     *
     * @var string
     */
    public static $privacyPolicy = '#agree_privacypolicy';

    /**
     * Privacy policy link
     *
     * @var string
     */
    public static $privacyPolicyLink = '//*[text()="privacy policy"]';

    /**
     * Privacy policy form
     *
     * @var string
     */
    public static $privacyPolicyForm = '#document-content';

    /**
     * Privacy policy close icon
     *
     * @var string
     */
    public static $privacyPolicyCloseIcon = '//*[@role="dialog"][2]//*[@class="icon-close"]';

    /**
     * Data processing row
     *
     * @var string
     */
    public static $dataProcessing = '#agree_data_processing';

    /**
     * Empty checkbox
     *
     * @var string
     */
    public static $emptyCheckBox = '.icon-check-empty';

    /**
     * Checked checkbox
     *
     * @var string
     */
    public static $checkedCheckBox = '.icon-check';

    /**
     * Submit button
     *
     * @var string
     */
    public static $submit = '#submit_save';

    /**
     * Value from list
     *
     * @param  string $field
     * @param  string $value
     * @return string
     */
    public static function getValueFromList($field, $value)
    {
        return sprintf($field . ' option[value="%s"]', $value);
    }

    /**
     * Get link to element depending on $field
     *
     * @param  string $field
     * @return string
     */
    public static function getCompanyField($field)
    {
        $link = '#prop_company_';

        switch ($field) {
            case 'profile':
                $link .= 'profile';
                break;
            case 'employees':
                $link .= 'no_employees';
                break;
            case 'description':
                $link .= 'person_description';
                break;
        }

        return $link;
    }

    /**
     * Get status for element depending on $field
     *
     * @param  string $field
     * @return string
     */
    public static function getStatusField($field)
    {
        $link = '#status_broker_';

        switch ($field) {
            case 'name':
                $link .= 'name';
                break;
            case 'country':
                $link .= 'address_country';
                break;
            case 'address':
                $link .= 'tag';
                break;
            case 'email':
                $link .= 'admin_email';
                break;
            case 'manager':
                $link .= 'admin_name';
                break;
            case 'phone':
                $link .= 'admin_phone';
                break;
        }

        return $link;
    }

    /**
     * Get empty checkbox depending on $field
     *
     * @param  string $field
     * @return string
     */
    public static function getEmptyCheck($field)
    {
        return $field . ' + ' . self::$emptyCheckBox;
    }

    /**
     * Get checked depending on $field
     *
     * @param  string $field
     * @return string
     */
    public static function getCheckedField($field)
    {
        return $field . ' + ' . self::$checkedCheckBox;
    }

    /**
     * Get ok status depending on $field
     *
     * @param  string $field
     * @return string
     */
    public static function getStatusOk($field)
    {
        return self::getStatusField($field) . self::$statusOk;
    }

    /**
     * Get value in field
     *
     * @param  \AcceptanceTester $I
     * @param  string            $field
     * @return                  string
     */
    public static function getValue($I, $field)
    {
        return $I->executeJS(sprintf('return $("%s").val()', $field));
    }
}
