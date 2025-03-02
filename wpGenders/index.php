<?php
/**
 * Plugin Name: User Gender Preselection
 * Description: Adds a preselected gender field to the WordPress registration form.
 * Version: 1.2
 * Author: Ionut Baldazar
* Text Domain: user-gender-preselect
 * Domain Path: /languages
 */
// Load plugin text domain for translations
function usp_load_textdomain() {
    load_plugin_textdomain('user-gender-preselect', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'usp_load_textdomain');

// Add the gender field to the registration form
function usp_add_gender_field() {
    ?>
    <p>
        <label for="gender"><?php _e('Gender', 'user-gender-preselect'); ?><br/>
            <select name="gender" id="gender">
                <option value="male" selected><?php _e('Male', 'user-gender-preselect'); ?></option>
                <option value="female"><?php _e('Female', 'user-gender-preselect'); ?></option>
                <option value="non_binary"><?php _e('Non-binary', 'user-gender-preselect'); ?></option>
                <option value="transgender"><?php _e('Transgender', 'user-gender-preselect'); ?></option>
                <option value="genderqueer"><?php _e('Genderqueer', 'user-gender-preselect'); ?></option>
                <option value="agender"><?php _e('Agender', 'user-gender-preselect'); ?></option>
                <option value="genderfluid"><?php _e('Genderfluid', 'user-gender-preselect'); ?></option>
                <option value="hijra"><?php _e('Hijra', 'user-gender-preselect'); ?></option>
                <option value="neutrois"><?php _e('Neutrois', 'user-gender-preselect'); ?></option>
                <option value="bigender"><?php _e('Bigender', 'user-gender-preselect'); ?></option>
                <option value="demiboy"><?php _e('Demiboy', 'user-gender-preselect'); ?></option>
                <option value="demigirl"><?php _e('Demigirl', 'user-gender-preselect'); ?></option>
                <option value="androgyne"><?php _e('Androgyne', 'user-gender-preselect'); ?></option>
                <option value="two_spirit"><?php _e('Two-Spirit', 'user-gender-preselect'); ?></option>
                <option value="pangender"><?php _e('Pangender', 'user-gender-preselect'); ?></option>
                <option value="other"><?php _e('Other', 'user-gender-preselect'); ?></option>
                <option value="prefer_not_to_say"><?php _e('Prefer not to say', 'user-gender-preselect'); ?></option>
            </select>
        </label>
    </p>
    <?php
}
add_action('register_form', 'usp_add_gender_field');

// Validate the gender field
function usp_validate_gender_field($errors, $sanitized_user_login, $user_email) {
    $valid_genders = ['male', 'female', 'non_binary', 'transgender', 'genderqueer', 'agender', 'genderfluid', 'hijra', 'neutrois', 'bigender', 'demiboy', 'demigirl', 'androgyne', 'two_spirit', 'pangender', 'other', 'prefer_not_to_say'];
    if (!isset($_POST['gender']) || !in_array($_POST['gender'], $valid_genders)) {
        $errors->add('gender_error', '<strong>' . __('ERROR', 'user-gender-preselect') . '</strong>: ' . __('Please select a valid gender.', 'user-gender-preselect'));
    }
    return $errors;
}
add_filter('registration_errors', 'usp_validate_gender_field', 10, 3);

// Save the gender field data
function usp_save_gender_field($user_id) {
    if (isset($_POST['gender'])) {
        update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gender']));
    }
}
add_action('user_register', 'usp_save_gender_field');

// Display the gender field in the user profile
function usp_show_gender_field($user) {
    ?>
    <h3><?php _e('Additional Information', 'user-gender-preselect'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="gender"><?php _e('Gender', 'user-gender-preselect'); ?></label></th>
            <td>
                <select name="gender" id="gender">
                    <?php
                    $genders = ['male', 'female', 'non_binary', 'transgender', 'genderqueer', 'agender', 'genderfluid', 'hijra', 'neutrois', 'bigender', 'demiboy', 'demigirl', 'androgyne', 'two_spirit', 'pangender', 'other', 'prefer_not_to_say'];
                    foreach ($genders as $gender) {
                        echo '<option value="' . esc_attr($gender) . '" ' . selected(get_user_meta($user->ID, 'gender', true), $gender, false) . '>' . esc_html__($gender, 'user-gender-preselect') . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'usp_show_gender_field');
add_action('edit_user_profile', 'usp_show_gender_field');

// Save the gender field in the user profile
function usp_save_gender_profile($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gender']));
    }
}
add_action('personal_options_update', 'usp_save_gender_profile');
add_action('edit_user_profile_update', 'usp_save_gender_profile');