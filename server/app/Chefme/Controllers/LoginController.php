<?php

namespace Chefme\Controllers;

class LoginController extends BaseController {

    private $sentry;

    public function __construct(\Cartalyst\Sentry\Sentry $sentry) {
        $this->sentry = $sentry;
    }

	/**
	 * @todo account throttling
	 * @return type
	 */
    public function login() {
        $error = null;
        try {
            // Login credentials
            $credentials = array(
                'email' => \Input::get('email'),
                'password' => \Input::get('password'),
            );
            // Authenticate the user
            $user = $this->sentry->authenticate($credentials, false);
            return $this->json(array("status" => "success", "user" => $user->toJson()));
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $error = 'Login field is required.';
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $error = 'Password field is required.';
        } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $error = 'Wrong password, try again.';
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $error = 'User was not found.';
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $error = 'Your account has not been confirmed.';
        }

// The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $error = 'User is suspended.';
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $error = 'User is banned.';
        }

        if (!is_null($error)) {
            return $this->json(array("status" => "error", "errors" => $error));
        }
    }

}
