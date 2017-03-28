<?php

/**
 * View for the project viewing area of the admin area.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @package     LivetimeSuite
 * @subpackage  LietimeSuite/Admin/Partials
 */
?>
<style>
/**
 * columns
 */
html {
    box-sizing: border-box;
}

*,
*:before,
*:after {
    box-sizing: inherit;
}

.column {
    float: left;
    padding: 0 16px;
}

.column-6 {
    width: 50%;
}

/**
 * project table
 */
.project-title {
    display: inline-block;
}

.project-status {
    margin-left: .5em;
}

.project-table {
    width: 100%;
    max-width: 560px;
    table-layout: fixed;
}

.project-table thead {
    text-align: left;
}

.project-table th,
.project-table td {
    padding: 4px 8px;
}

.cf:before,
.cf:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.cf:after {
    clear: both;
}

/**
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */
.cf {
    *zoom: 1;
}
</style>
<div class="project-container">
    <div>
        <div>
            <h1 class="project-title"><?php echo $project->customer->name; ?></h1>
            <form id="project-status-form" method="POST" action="<?php admin_url('admin-ajax.php'); ?>">
                <select id="project-status" name="project-status">
                <?php foreach( $statuses as $status ) : ?>
                    <option value="<?php echo esc_attr( $status->id ); ?>"><?php echo esc_html( $status->name ); ?></option>
                <?php endforeach; ?>
                </select>
                <button type="submit" class="project-status-save">Spara</button>
            </form>
        </div>
        <span class="project-status"><strong>Status:</strong> <?php echo esc_html( $project->status ); ?></span>
        <div class="cf" style="max-width: 560px;">
            <div class="column column-6">
                <h3>Meta</h3>
                <ul>
                    <li><strong>Skapad:</strong> <?php echo date('Y-m-d', strtotime( $project->created_at )); ?></li>
                </ul>
            </div>
            <div class="column column-6">
                <h3>Kontaktinformation</h3>
                <ul>
                    <li><strong>Namn:</strong> <?php echo $project->customer->contacts->first()->name . ' ' . $project->customer->contacts->first()->surname; ?></li>
                    <li><strong>Telefon:</strong> <?php echo $project->customer->contacts->first()->phone; ?></li>
                    <li><strong>Email:</strong> <?php echo $project->customer->contacts->first()->email; ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div style="padding: 0 16px; margin-top: 30px;">
        <h2>Produkter</h2>
        <table class="project-table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width: 35%;">Namn</th>
                    <th style="width: 25%;">Pris</th>
                    <th style="width: 20%;">Antal</th>
                    <th style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach( $project->products as $product ) : ?>
                <tr>
                    <td><?php echo esc_html( $product->name ); ?></td>
                    <td><?php echo esc_html( number_format($product->price, 2, ',', ' ') ); ?>SEK</td>
                    <td><?php echo esc_html( $product->qty ); ?></td>
                    <td><?php echo esc_html( number_format($product->price * $product->qty, 2, ',', ' ') ); ?>SEK</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:"
</div>