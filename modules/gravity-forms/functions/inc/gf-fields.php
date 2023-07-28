<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Gravity Forms custom functions
 */

add_filter('gform_pre_render_6', 'gf_speakers');
add_filter('gform_pre_validation_6', 'gf_speakers');
add_filter('gform_pre_submission_filter_6', 'gf_speakers');
add_filter('gform_admin_pre_render_6', 'gf_speakers');

function gf_speakers( $form ) {

    foreach ( $form['fields'] as &$field ) {

        if($field->type !== 'checkbox' || strpos( $field->cssClass, 'gf-speakers' ) === false) {
            continue;
        }

		$speakers = WVL_Speakers::get_speakers();
		if(empty($speakers)) { continue; }

		$input_id = 1;
        foreach ( $speakers as $speaker_id ) {
			
			//skipping index that are multiples of 10 (multiples of 10 create problems as the input IDs)
            if ( $input_id % 10 == 0 ) {
                $input_id++;
            }

			$_speaker = new WVL_Speaker($speaker_id);

			$speaker_img = '';
			if(is_array($_speaker->image(100, 100))) {
				$speaker_img = $_speaker->image(100, 100)['url'];
			}

            $choices[] = array(
				'text' => '<figure style="width: 48px; height: 48px; border-radius: 100%; overflow: hidden; margin-right: 8px;"><img src="'.$speaker_img.'" /></figure>'.$_speaker->name(),
				'value' => $_speaker->name()
			);
            $inputs[] = array(
				'label' => $_speaker->name(),
				'id' => $field->id.'.'.$input_id
			);

			$input_id++;
        }

        $field->placeholder = 'Select a speaker';
        $field->choices = $choices;
        $field->inputs = $inputs;

    }

    return $form;

}

/** ----------------------------------------------------
 * Event filters
 *------------------------------------------------------*/

 /**
  * Event name
  * @param  string $value
  */
function gf_event_name($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

    $event = new AEF_Event($event_id);
	$event_start = ' - '.$event->date('j M Y H:i', 'start') ?? '';

	return $event->title().$event_start;
}
add_filter('gform_field_value_event_name', 'gf_event_name');

/**
 * Event ID
 * @param  string $value
 */
function gf_event_id($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	return $event_id;
}
add_filter('gform_field_value_event_id', 'gf_event_id');

/**
 * Event URL
 * @param  string $value
 */
function gf_event_url($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$event = new AEF_Event($event_id);

	return $event->url();
}
add_filter('gform_field_value_event_url', 'gf_event_url');

/**
 * Event start date
 * @param  string $value
 */
function gf_event_start_date($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$event = new AEF_Event($event_id);

	return $event->date('j M Y H:i', 'start') ?? '';
}
add_filter('gform_field_value_event_start_date', 'gf_event_start_date');

/**
 * Event end date
 * @param  string $value
 */
function gf_event_end_date($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$event = new AEF_Event($event_id);

	return $event->date('j M Y H:i', 'end') ?? '';
}
add_filter('gform_field_value_event_end_date', 'gf_event_end_date');

/**
 * Event user ID
 * @param  string $value
 */
function gf_event_user_id($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$user_id = get_current_user_id();

	return $user_id;
}
add_filter('gform_field_value_user_id', 'gf_event_user_id');

/**
 * Event user first name
 * @param  string $value
 */
function gf_event_user_first_name($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$user_id = get_current_user_id();
	$user = new WVL_User($user_id);

	return $user->get_first_name();
}
add_filter('gform_field_value_user_first_name', 'gf_event_user_first_name');

/**
 * Event user last name
 * @param  string $value
 */
function gf_event_user_last_name($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$user_id = get_current_user_id();
	$user = new WVL_User($user_id);

	return $user->get_last_name();
}
add_filter('gform_field_value_user_last_name', 'gf_event_user_last_name');

/**
 * Event user email name
 * @param  string $value
 */
function gf_event_user_email($value) {

    $event_id = FL1_Helpers::param('event_id');
	if(!$event_id) { return $value; }

	$user_id = get_current_user_id();
	$user = new WVL_User($user_id);

	return $user->get_email();
}
add_filter('gform_field_value_user_email', 'gf_event_user_email');