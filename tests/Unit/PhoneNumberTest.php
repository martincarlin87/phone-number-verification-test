<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\PhoneNumber;

class PhoneNumberTest extends TestCase
{

    /**
     * Test the number attribute is set correctly.
     *
     * @return void
     */
    public function testNumber()
    {

        $phoneNumber = new PhoneNumber;
        $phoneNumber->number = '07805171823';

        $this->assertEquals('07805171823', $phoneNumber->number);
    }

    /**
     * Test the setValid method sets the valid attribute correctly.
     *
     * @return void
     */
    public function testSetValid()
    {

        $phoneNumber = new PhoneNumber;
        $phoneNumber->number = '07805171823';

        $phoneNumber->setValid(true);

        $this->assertTrue($phoneNumber->valid);
    }

    /**
     * Test the setStatus method sets the status attribute correctly.
     *
     * @return void
     */
    public function testSetStatus()
    {

        $phoneNumber = new PhoneNumber;
        $phoneNumber->number = '07805171823';

        $phoneNumber->setStatus('valid');

        $this->assertEquals('valid', $phoneNumber->status);
    }

    /**
     * Test the setCarrier method sets the carrier attribute correctly.
     *
     * @return void
     */
    public function testSetCarrier()
    {

        $phoneNumber = new PhoneNumber;
        $phoneNumber->number = '07805171823';

        $phoneNumber->setCarrier('EE');

        $this->assertEquals('EE', $phoneNumber->carrier);
    }

    /**
     * Test the buildUrl method returns the expected url.
     *
     * @return void
     */
    public function testBuildUrl()
    {

        $phoneNumber = new PhoneNumber;
        $phoneNumber->number = '07805171823';

        $url = $phoneNumber->buildUrl($phoneNumber->number);

        $expectedUrl = 'http://apilayer.net/api/validate?' .
            'access_key=' . config('services.numverify.key') .
            '&number=' . $phoneNumber->number .
            '&country_code=GB' .
            '&format=1';

        $this->assertEquals($expectedUrl, $url);
    }
}
