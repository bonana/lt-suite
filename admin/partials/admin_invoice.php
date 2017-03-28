<?php

/**
 * View for the quote sending portion of the admin area.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @package     LivetimeSuite
 * @subpackage  LietimeSuite/Admin/Partials
 */
?>
<style>
.ltwp-email-form .form-set {
    display: block;
    margin-bottom: 8px;
}

.ltwp-email-form .form-set input,
.ltwp-email-form .form-set textarea,
.ltwp-email-form .form-set label {
    display: inline-block;
}

.ltwp-email-form .form-set input,
.ltwp-email-form .form-set textarea {
    width: 300px;
}

.ltwp-email-form .form-set label {
    padding-top: 4px;
    vertical-align: top;
}

.ltwp-email-btn {
    padding: 4px 16px;
    outline: none;
    border: 1px solid #4c8444;
    border-bottom: 3px solid #4c8444;
    border-radius: 3px;

    background: #4f8e46;
    color: #fff;

    font-size: 0.875em;
    font-weight: bold;
    text-transform: uppercase;
}
</style>
<form class="ltwp-email-form" method="POST" action="<?php echo admin_url( 'admin-post.php' ); ?>">
    <div style="margin-top: 20px;">
        <h3>Projekt ID</h3>
        <div class="form-set">
            <input type="text" name="project_id" id="project_id" placeholder="Projekt ID">
            <label for="project_id">Projekt ID</label>
        </div>
    </div>

    <input type="hidden" name="action" value="livetime_suite_invoice_create">
    <button type="submit" class="ltwp-email-btn">Skapa faktura</button>
</form>