<?php
namespace App\Http\Controllers\API\V1\Auth;

use App\Models\User;
use EMedia\Api\Docs\APICall;
use EMedia\Api\Docs\Param;
use EMedia\Devices\Auth\DeviceAuthenticator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends \EMedia\Oxygen\Http\Controllers\API\V1\Auth\AuthController
{

    /**
     *
     * Fillable parameters when registering a new user
     * Only add fields that must be auto-filled
     *
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     *
     * Validation rules to be enforced when registering.
     *
     * @return array
     */
    protected function getRegistrationValidationRules(): array
    {
        return [
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8',
            'device_id'   => 'required',
            'device_type' => 'required',
        ];
    }

    /**
     *
     * These are the parameters for APIDoc
     *
     * @return array
     */
    protected function getRegistrationApiDocParams(): array
    {
        return [
            'device_id|Unique ID of the device|{{$guid}}',
            'device_type|Type of the device `APPLE` or `ANDROID`|example:apple',
            'device_push_token|optional|Unique push token for the device',

            'email|Email address of user|{{$randomExampleEmail}}',
            'password|Password. Must be at least 8 characters.|{{login_user_pass}}',
        ];
    }

    public function register(Request $request)
    {
        document(function () {
            return (new APICall())
                ->setGroup('Auth')
                ->setName('Register')
                ->setParams($this->getRegistrationApiDocParams())
                ->setSuccessObject(app('oxygen')->getUserClass());
        });

        $request->validate($this->getRegistrationValidationRules());

        // create a new user
        $user = app('oxygen')->getUserClass()::create([
            'email'                      => $request->email,
            'password'                   => $request->password,
            'device_id'                  => $request->device_id,
            'device_type'                => $request->device_type,
            'confirmation_code'          => mt_rand(1000, 9999),
            'email_confirmation_sent_at' => now()->toDateTimeString(),
        ]);

        // Send Email verification code
        if ($user) {
            event(new Registered($user));

            $responseData                 = $user->toArray();
            $deviceData                   = $request->only($this->fillableDeviceParams);
            $device                       = $this->devicesRepo->createOrUpdateByIDAndType($deviceData, $user->id);
            $responseData['access_token'] = $device->access_token;

            return response()->apiSuccess($responseData, 'A verification code has been sent to your email.');
        }

        return response()->apiError('An error occurred while registering the user. Please try again later.');
    }

    // Add your logic here
    public function verifyEmail(Request $request)
    {
        document(function () {
            return (new APICall())
                ->setGroup('Auth')
                ->setName('Email Verification')
                ->setParams([
                    (new Param('code', Param::TYPE_STRING, 'Verification Code'))->setDefaultValue('1234'),
                ])
                ->setSuccessObject(app('oxygen')->getUserClass())
                ->setSuccessExample('{
					"payload": {
						"uuid": "a3bcf5f0-3b7c-4a0d-8c63-1ba604a76f8f",
						"last_name": null,
						"email": "alokadevapriya@gmail.com",
						"dob": null,
						"address": null,
						"avatar_url": null,
						"first_name": null,
						"full_name": "",
						"is_verified": true,
						"role": "buyers"
					},
					"message": "",
					"result": true
				}');
        });

        try {
            $request->validate([
                'code' => 'required',
            ]);

            $user = DeviceAuthenticator::getUserByAccessToken();

            if ($user->confirmation_code == $request->code) {
                $user->email_confirmed_at = now()->toDateTimeString();
                $user->save();
            } else {
                return response()->apiError('Invalid verification code, Resend and try again');
            }
            // find user by id
            $user = User::find($user->id);
            $user->refresh();

            return response()->apiSuccess($user, 'Email verified successfully.');
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            Log::error('Error verifying email: ' . $e->getMessage());

            return response()->apiError('An error occurred while verifying the email. Please try again later.');
        }
    }

    public function resendCode()
    {
        document(function () {
            return (new APICall())
                ->setGroup('Auth')
                ->setName('Resend Verification Code');
        });

        try {
            $user = DeviceAuthenticator::getUserByAccessToken();

            $user->confirmation_code          = mt_rand(1000, 9999);
            $user->email_confirmation_sent_at = now()->toDateTimeString();
            $user->save();

            // Send Email verification code
            event(new Registered($user));

            return response()->apiSuccess(null, 'A verification code has been sent to your email.');
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            Log::error('Error resending verification code: ' . $e->getMessage());

            return response()->apiError('An error occurred while resending the verification code. Please try again later.');
        }
    }

}
