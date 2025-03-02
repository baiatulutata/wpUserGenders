<?php
/**
 * Plugin Name: User Gender Preselection
 * Description: Adds a preselected gender field to the WordPress registration form.
 * Version: 1.2
 * Author: Ionut Baldazar
 */

// Add the gender field to the registration form
function usp_add_gender_field() {
    ?>
    <p>
        <label for="gender">Gender<br/>
            <select name="gender" id="gender">
                <option value="male" selected>Male</option>
                <option value="female">Female</option>
                <option value="non_binary">Non-binary</option>
                <option value="transgender">Transgender</option>
                <option value="genderqueer">Genderqueer</option>
                <option value="agender">Agender</option>
                <option value="genderfluid">Genderfluid</option>
                <option value="hijra">Hijra</option>
                <option value="neutrois">Neutrois</option>
                <option value="bigender">Bigender</option>
                <option value="demiboy">Demiboy</option>
                <option value="demigirl">Demigirl</option>
                <option value="androgyne">Androgyne</option>
                <option value="two_spirit">Two-Spirit</option>
                <option value="pangender">Pangender</option>
                <option value="other">Other</option>
                <option value="prefer_not_to_say">Prefer not to say</option>
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
        $errors->add('gender_error', '<strong>ERROR</strong>: Please select a valid gender.');
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
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="gender">Gender</label></th>
            <td>
                <select name="gender" id="gender">
                    <option value="male" <?php selected(get_user_meta($user->ID, 'gender', true), 'male'); ?>>Male</option>
                    <option value="female" <?php selected(get_user_meta($user->ID, 'gender', true), 'female'); ?>>Female</option>
                    <option value="non_binary" <?php selected(get_user_meta($user->ID, 'gender', true), 'non_binary'); ?>>Non-binary</option>
                    <option value="transgender" <?php selected(get_user_meta($user->ID, 'gender', true), 'transgender'); ?>>Transgender</option>
                    <option value="genderqueer" <?php selected(get_user_meta($user->ID, 'gender', true), 'genderqueer'); ?>>Genderqueer</option>
                    <option value="agender" <?php selected(get_user_meta($user->ID, 'gender', true), 'agender'); ?>>Agender</option>
                    <option value="genderfluid" <?php selected(get_user_meta($user->ID, 'gender', true), 'genderfluid'); ?>>Genderfluid</option>
                    <option value="hijra" <?php selected(get_user_meta($user->ID, 'gender', true), 'hijra'); ?>>Hijra</option>
                    <option value="neutrois" <?php selected(get_user_meta($user->ID, 'gender', true), 'neutrois'); ?>>Neutrois</option>
                    <option value="bigender" <?php selected(get_user_meta($user->ID, 'gender', true), 'bigender'); ?>>Bigender</option>
                    <option value="demiboy" <?php selected(get_user_meta($user->ID, 'gender', true), 'demiboy'); ?>>Demiboy</option>
                    <option value="demigirl" <?php selected(get_user_meta($user->ID, 'gender', true), 'demigirl'); ?>>Demigirl</option>
                    <option value="androgyne" <?php selected(get_user_meta($user->ID, 'gender', true), 'androgyne'); ?>>Androgyne</option>
                    <option value="two_spirit" <?php selected(get_user_meta($user->ID, 'gender', true), 'two_spirit'); ?>>Two-Spirit</option>
                    <option value="pangender" <?php selected(get_user_meta($user->ID, 'gender', true), 'pangender'); ?>>Pangender</option>
                    <option value="other" <?php selected(get_user_meta($user->ID, 'gender', true), 'other'); ?>>Other</option>
                    <option value="prefer_not_to_say" <?php selected(get_user_meta($user->ID, 'gender', true), 'prefer_not_to_say'); ?>>Prefer not to say</option>
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
