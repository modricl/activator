<?php

namespace Modricl\Activator\Http\Controllers;

use App\Http\Controllers\Controller;
use Modricl\Activator\Models\ActivationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivatorController extends Controller
{
    private const CODE_DIGITS = 'activator.code_digits';
    private const EXPIRY_MINUTES = 'activator.expiry_minutes';

    /**
     * @api {get} /activator/code/generate Get activation code
     * @apiName GenerateCode
     * @apiVersion 1.0.0
     * @apiGroup Activator
     *
     * @apiDescription
     * Method is used for generating and fetching activation code from server.
     *
     * @apiHeader {String} X-API-KEY provided API key
     *
     * @apiParam {String} action action uid
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *     "action": "user7723-purchase-sport",
     *     "code": 2516,
     *     "expiry": "2021-10-29T08:47:03.664270Z",
     *     "updated_at": "2021-10-29 08:37:03",
     *     "created_at": "2021-10-29 08:37:03",
     *     "id": 25
     * }
     */
    public function generateCode(Request $request)
    {
        // action field is required to determine user or purpose
        $request->validate([
            'action' => ['required']
        ]);

        if (ActivationCode::where('action', $request->action)->where('created_at', '>', Carbon::now()->subYear())->get()->count() >= 10000) {
            // handle error when action requests more than 10000 codes in year and consume all codes
        }

        // generate random {CODE_DIGITS} digit code not used in last year
        do {
            $code = $this->random_numbers(config(self::CODE_DIGITS));
        } while (ActivationCode::where('action', $request->action)->where('code', $code)->where('created_at', '>', Carbon::now()->subYear())->exists());

        // if code for same subscriber and purpose already exists, make it expired
        if (ActivationCode::where('action', $request->action)->where('expiry', '>', Carbon::now())->exists()) {
            $oldCode = ActivationCode::where('action', $request->action)->where('expiry', '>', Carbon::now())->first();
            $oldCode->expiry = Carbon::now();
            $oldCode->save();
        }

        // save generated code to database
        $activationCode = new ActivationCode();
        $activationCode->action = $request->action;
        $activationCode->code = $code;
        $activationCode->expiry = Carbon::now()->addMinutes(config(self::EXPIRY_MINUTES));
        $activationCode->save();

        return response()->json($activationCode);
    }

    /**
     * @api {post} /activator/code/validate Validate activation code
     * @apiName ValidateCode
     * @apiVersion 1.0.0
     * @apiGroup Activator
     *
     * @apiDescription
     * Method is used for activation code validation.
     *
     * @apiHeader {String} X-API-KEY provided API key
     *
     * @apiParam {String} action action uid
     *
     * @apiBody {Number} code activation code
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *     "action": "user7723-purchase-sport",
     *     "success": "true"
     * }
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 OK
     * {
     *     "error": {
     *         "message": "Invalid Code"
     *     }
     * }
     */
    public function validateCode(Request $request)
    {
        // action field is required to determine user or purpose and code to authorize
        $request->validate([
            'action' => ['required'],
            'code' => ['required']
        ]);

        $data =  $request->all();

        // find if there is valid code for given action and return success
        if (ActivationCode::where('action', $request->action)->where('code', $data["code"])->where('expiry', '>', Carbon::now())->exists()) {
            $activationCode = ActivationCode::where('action', $request->action)->where('code', $data["code"])->where('expiry', '>', Carbon::now())->first();
            $activationCode->expiry = Carbon::now();
            $activationCode->save();

            return response()->json([
                'action' => $request->action,
                'success' => 'true'
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'message' => 'Invalid Code'
                ]
            ], 401);
        }
    }

    // Pass number of digits to generate random number
    function random_numbers($digits)
    {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        return mt_rand($min, $max);
    }
}
