<?php
    headerPage($data);
?>
    <main>
        <div class="container mt-4 mb-4 text-center bg-white">
            <h2 class="fs-1 text-secondary">Thanks for your purchase!</h2>
            <p class="m-0">Your order has been approved</p>
            <p class="m-0">Order number: <?=openssl_decrypt($data['orderData']['order'],METHOD,KEY)?></p>
            <p class="m-0">Transaction: <?=openssl_decrypt($data['orderData']['transaction'],METHOD,KEY)?></p>
            <hr>
            <div class="mt-3">
                <p class="m-0 mb-3">You can see your order in your profile</p>
                <a href="<?=base_url()?>" class="btn btn-bg-1">got it</a>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>