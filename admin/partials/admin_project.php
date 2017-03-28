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
.project-container {
    padding-top: 30px;
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

.search {
    display: inline-block;
    width: 100%;
    max-width: 250px;
    margin: 0 0 1.5em;
    padding: 8px 16px;
    border-radius: 3px;
    border: none;

    background: #fff;

    box-shadow: 0 1px 3px rgba(0,0,0,.27);

    transition: max-width .095s ease-in;
    will-change: max-width;
}

.search:focus {
    max-width: 350px;

    transition: max-width .125s ease-out;
}
</style>
<div class="project-container">
    <h3>Godkända projekt</h3>
    <table class="project-table" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 35%;">Företag</th>
                <th style="width: 25%;">Skapat</th>
                <th style="width: 25%;">Status</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $projects as $project ) : ?>
            <tr>
                <td><a href="<?php menu_page_url('livetime-suite-admin-project'); ?>&projectid=<?php echo $project->id; ?>"><?php echo $project->id; ?></a></td>
                <td><?php echo $project->customer->name; ?></td>
                <td><?php echo date('Y-m-d', strtotime( $project->created_at ) ); ?></td>
                <td><?php echo $project->status->name; ?></td>
                <td><a class="send-invoice" href="<?php echo admin_url('admin-ajax.php'); ?>" data-project-id="<?php echo esc_attr( $project->id ); ?>"><i class="dslc-icon dslc-icon-ext-envelope"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div id="projects">
        <h3>Projekt</h3>
        <input class="search" placeholder="Sök">
        <table class="project-table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 35%;">Företag</th>
                    <th style="width: 25%;">Skapat</th>
                    <th style="width: 25%;">Status</th>
                    <th style="width: 5%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody class="list">
            <?php foreach ( $unconfirmed_projects as $project ) : ?>
                <tr>
                    <td><a href="<?php menu_page_url('livetime-suite-admin-project'); ?>&projectid=<?php echo $project->id; ?>"><?php echo $project->id; ?></a></td>
                    <td class="name"><?php echo $project->customer->name; ?></td>
                    <td><?php echo date('Y-m-d', strtotime( $project->created_at ) ); ?></td>
                    <td><?php echo $project->status->name; ?></td>
                    <td><a class="send-invoice" href="<?php echo admin_url('admin-ajax.php'); ?>" data-project-id="<?php echo esc_attr( $project->id ); ?>"><i class="dslc-icon dslc-icon-ext-envelope"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
</div>

