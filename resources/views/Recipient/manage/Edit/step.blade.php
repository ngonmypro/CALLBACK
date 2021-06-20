<section class="nav-top-step py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center text-center">
                    <div class="flex-fill">
                        <button type="button" class="btn btn-link rounded-circle border border-primary py-2 px-3 text-primary step" data-url="EditRecipient" onclick="window.location.href='{{ URL::to('Recipient/Profile')}}/{{$profile->recipient_code ?? $code }}'">1</button>
                        <p class="pl-2">Edit Recipient</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
