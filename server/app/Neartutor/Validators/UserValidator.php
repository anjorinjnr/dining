<?php

namespace Neartutor\Validators;

/**
 * Description of UserValidator
 *
 * @author kayfun
 */
class UserValidator extends Validator {

    protected $fields = array(
		'email',
		'activated',
		'activation_code',
		'activated_at',
		'last_login',
		'persist_code',
		'reset_password_code',
		'firstname',
        'lastname',
        'first_name',
		'last_name',
		'created_at',
		'updated_at',
		'user_type',
		'address',
		'phone_number',
		'longitude',
		'latitude',
		'state_id',
		'town_id',
		'area_id',
		'gender',
		'dob',
        'education',
        'major',
        'institution',
		'rate',
        'profile_picture',
    );
    public static $rules = array(
        'state_id' => 'integer',
        'town_id' => 'integer',
        'area_id' => 'integer',
        'profile_picture' => 'image',
    );

}
