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
        <h3>Företagsinformation</h3>
        <div class="form-set">
            <input type="text" name="email_company_name" id="email_company_name" placeholder="Företagsnamn">
            <label for="email_company_name">Företagsnamn</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_company_org_nr" id="email_company_org_nr" placeholder="Organisationsnummer">
            <label for="email_company_org_nr">Organisationsnummer</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_company_address" id="email_company_address" placeholder="Adress">
            <label for="email_company_address">Adress</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_company_post_code" id="email_company_post_code" placeholder="Postkod">
            <label for="email_company_post_code">Postkod</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_company_town" id="email_company_town" placeholder="Stad">
            <label for="email_company_town">Stad</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_company_county" id="email_company_county" placeholder="Län">
            <label for="email_company_county">Län</label>
        </div>
    </div>
    <div style="margin-top: 20px;">
        <h3>Kontaktperson</h3>
        <div class="form-set">
            <input type="text" name="email_customer_firstname" id="email_customer_firstname" placeholder="Kontaktpersonens namn">
            <label for="email_customer_firstname">Kontaktpersonens namn</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_customer_lastname" id="email_customer_lastname" placeholder="Kontaktpersonens efternamn">
            <label for="email_customer_lastname">Kontaktpersonens efternamn</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_customer_email" id="email_customer_email" placeholder="Kontaktpersonens e-post">
            <label for="email_customer_email">Kontaktpersonens e-post</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_customer_phone" id="email_customer_phone" placeholder="Kontaktpersonens telefonnummer">
            <label for="email_customer_phone">Kontaktpersonens telefonnummer</label>
        </div>
    </div>
    <div style="margin-top: 20px;">
        <h3>Föreslaget tema</h3>
        <div class="form-set">
            <input type="text" name="email_envato_url" id="email_envato_url" placeholder="Envato länk">
            <label for="email_envato_url">Envato länk</label>
        </div>
        <div class="form-set">
            <input type="text" name="email_theme_url" id="email_theme_url" placeholder="Tema länk">
            <label for="email_theme_url">Tema länk</label>
        </div>
    </div>
    <div style="margin-top: 20px;">
        <h3 style="display: inline-block;">Lägg till produkt</h3><button type="button" class="ltwp-email-btn" id="email_product_add" style="display: inline-block; margin-left: 16px;"><i class="fa fa-plus"></i></button>
        <div id="email_product_container"></div>
    </div>

    <input type="hidden" name="action" value="livetime_suite_quote_send">
    <button type="submit" class="ltwp-email-btn">Skicka mail</button>
</form>