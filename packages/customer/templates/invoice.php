<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <style>
    html {
        box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
        box-sizing: inherit;
    }

    html,
    body {
        height: auto;
        padding: 0;
        margin: 0;
    }

    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Open Sans', Helvetica, Arial, sans-serif;
    }

    html {
        padding: 40px 0;
    }

    body {
        position: relative;

        color: #3b3b3b;

        background-color: #fff;
        -webkit-font-smoothing: subpixel-antialiased;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: #2b2b2b;
    }

    .no-margin {
        margin: 0;
    }

    .color-brand {
        color: #4fba71;
    }

    .background-brand {
        background-color: #4fba71;
    }

    .text-upper {
        text-transform: uppercase;
    }

    .text-bold {
        font-weight: 600;
    }

    .text-huge {
        font-size:3em;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .container {
        width: 100%;
        padding: 0 20px;
    }

    .container.padded {
        padding: 0 10%;
    }

    .container.service-container {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .container.meta-container {
        padding: 0 6% 0 10%;
        color: #fff;

        page-break-inside: avoid;
    }

    .container.footer-container {
        position: relative;
        left: 60%;

        padding-top: 16px;
        padding-bottom: 4px;

        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        -o-transform: translateX(-50%);
        transform: translateX(-50%);
    }

    .container.no-padding {
        padding: 0;
    }

    .row {
        position: relative;
    }

    .row:before,
    .row:after {
        content: " "; /* 1 */
        display: table; /* 2 */
    }

    .row:after {
        clear: both;
    }

    .header-item {
        position: relative;

        float: left;
        width: 33%;
        min-height: 132px;
        padding: 0 16px;
    }

    .header-item:not(:last-child):after {
        content: "";
        position: absolute;
        top: 50%;
        right: 0;

        width: 1px;
        height: 40px;

        background: #ccc;

        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .header-padding-right {
        padding-right: 40px;
    }

    .header-padding-left {
        padding-left: 40px;
    }

    .company-name {
        margin: 40px 0 0;
    }

    .company-address {
        margin: 0;
    }

    .company-owner {
        margin: 40px 0 6px;
    }

    .column {
        position: relative;

        float: left;
        padding: 24px 16px;
    }

    .column.padded {
        padding: 0 16px 16px;
    }

    .column.small {
        padding: 4px 16px;
    }

    .column.service {
        width: 24%;
    }

    .column.description {
        width: 38%;
    }

    .column.qty {
        width: 10%;
    }

    .column.price,
    .column.total {
        width: 14%;
    }

    .column.meta-description {
        position: relative;

        width: 60%;
        height: 200px;
        padding: 0 16px;
    }

    .column.meta-description p {
        position: absolute;
        top: 50%;

        padding-right: 16px;

        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .column.meta-price {
        width: 40%;
        padding: 40px 16px;

        background: #409e5f;
    }

    .meta-set {
        width: 100%;
        padding: 8px 0;
    }

    .meta-header,
    .meta-value {
        float: left;
        width: 50%;

        line-height: 1;
    }

    .meta-header {
        padding-right: 14px;

        font-weight: 600;

        text-align: right;
    }

    .meta-value {
        padding-left: 14px;

        text-align: left;
    }

    .meta-big {
        font-size: 20px;
    }

    .meta-seperator {
        width: 276px;
        height: 2px;
        margin-top: 4px;
        margin-bottom: 4px;
        margin-left: 116px;

        background: #fff;
    }

    .invoice-info-big {
        width: 60%;
    }

    .invoice-info-small {
        width: 40%;
    }

    .invoice-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .pull-left {
        margin-left: -16px;
    }

    .invoice-info {
        padding-top: 20px !important;
    }
    </style>
</head>
<body>
<center><img src="http://livetime.nu/wp-content/uploads/2016/07/lt_butt.png"></center>
<div class="container" style="margin-top:120px;">
    <div class="row">
        <div class="header-item header-padding-right">
            <h1 class="text-upper color-brand text-huge text-right">Faktura</h1>
        </div>
        <div class="header-item header-padding-left">
            <h3 class="company-name"><?php echo $customer->name; ?></h3>
            <p class="company-address"><?php echo $customer->address; ?></p>
        </div>
        <div class="header-item header-padding-left">
            <p class="text-upper company-owner"><?php echo $customer->contacts()->first()->name . ' ' . $customer->contacts()->first()->surname; ?></p>
            <p class="company-address"><?php echo $customer->contacts()->first()->email; ?></p>
        </div>
    </div>
</div>
<div class="container padded" style="background:#f3f3f3;margin-top:120px;">
    <div class="row">
        <div class="column service">
            <h4 class="text-upper">Tjänst</h4>
        </div>
        <div class="column description">
            <h4 class="text-upper">Beskrivning</h4>
        </div>
        <div class="column price">
            <h4 class="text-upper">Pris</h4>
        </div>
        <div class="column qty">
            <h4 class="text-upper">Qty</h4>
        </div>
        <div class="column total">
            <h4 class="text-upper">Total</h4>
        </div>
    </div>
</div>
<div class="container padded service-container">
<?php
    $product_sum = 0;
    foreach ($project->products as $product) {
        $product_sum += $product->price * $product->qty;
    ?>
        <div class="row">
            <div class="column service small">
                <p><?php echo $product->name; ?></p>
            </div>
            <div class="column description small">
                <p><?php echo wp_kses(nl2br($product->description), array(
                    //formatting
                    'strong' => array(),
                    'em'     => array(),
                    'b'      => array(),
                    'i'      => array(),
                    'br'     => array(),

                    //links
                    'a'     => array(
                        'href' => array()
                    )
        )); ?></p>
            </div>
            <div class="column price small">
                <p><?php echo number_format($product->price, 2, ',', ' '); ?>SEK</p>
            </div>
            <div class="column qty small">
                <p><?php echo $product->qty; ?></p>
            </div>
            <div class="column total small">
                <p><?php echo number_format($product->price * $product->qty, 2, ',', ' '); ?>SEK</p>
            </div>
        </div>
    <?php } ?>
</div>
<div class="container padded background-brand meta-container">
    <div class="row">
        <div class="column meta-description pull-left invoice-info">
            <div class="column invoice-info-big">
                <ul class="invoice-list">
                    <li><strong>Skapad</strong>: <?php echo $invoice->created_at; ?></li>
                    <li><strong>Förfallo</strong>: <?php echo date("Y-m-d", strtotime("+2 weeks")); ?></li>
                    <li><strong>Delbetalning</strong>: <?php if ( $project->percentage === 100 ) { echo '2/2'; } else { echo '1/2'; } ?></li>
                    <li><strong>Betalas till Plus-giro</strong>: 79 94 12-2</li>
                    <li><strong>Ange OCR-nummer</strong>: <?php echo $invoice->ocr; ?></li>
                </ul>
            </div>
            <div class="column invoice-info-small">
                <ul class="invoice-list">
                    <li><strong>Kundnr</strong>: <?php echo str_pad( $customer->id, 5, '0', STR_PAD_LEFT ); ?></li>
                    <li><strong>Referens</strong>: <?php echo $customer->contacts()->first()->name . ' ' . $customer->contacts()->first()->surname; ?></li>
                    <li>Innehar F-Skatt</li>
                </ul>
            </div>
        </div>
        <div class="column meta-price">
            <div class="row meta-set">
                <div class="meta-header">Summa</div>
                <div class="meta-value"><?php echo number_format($product_sum, 2, ',', ' '); ?>SEK</div>
            </div>
            <div class="row meta-set">
                <div class="meta-header">MOMS (VAT 25%)</div>
                <div class="meta-value"><?php echo number_format($product_sum * 0.25, 2, ',', ' '); ?>SEK</div>
            </div>
            <div class="meta-seperator"></div>
            <div class="row meta-set">
                <div class="meta-header meta-big text-upper">Att Betala</div>
                <div class="meta-value meta-big"><?php echo number_format($product_sum + ($product_sum * 0.25), 2, ',', ' '); ?>SEK</div>
            </div>
            <div class="meta-seperator"></div>
        </div>
    </div>
</div>
<div class="container footer-container padded" style="padding-left: 20%;">
    <div class="row">
        <div class="column project-leader-name">
            <p class="no-margin"><span class="color-brand text-bold">Projektledare:</span>&nbsp;<?php echo $staff->display_name ; ?></p>
        </div>
        <div class="column project-leader-number">
            <p class="no-margin"><?php echo $staff->phone; ?></p>
        </div>
        <div class="column project-leader-website">
            <p class="no-margin">www.livetime.nu</p>
        </div>
        <div class="column project-leader-email">
            <p class="no-margin"><?php echo $staff->user_email; ?></p>
        </div>
    </div>
</div>
</body>
</html>