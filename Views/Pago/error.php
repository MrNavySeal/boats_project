<?php
    headerPage($data);
?>
    <main>
        <div class="container mt-4 mb-4 text-center py-5">
            <h2 class="fs-1 text-secondary">Oops! Something went wrong :(</h2>
            <p class="m-0">Your order has beend declined</p>
            <hr>
            <div class="mt-3">
                <a href="<?=base_url()?>/checkout/" class="btn btn-bg-1">Try again</a>
            </div>
        </div>
    </main>
<?php
    footerPage($data);
?>