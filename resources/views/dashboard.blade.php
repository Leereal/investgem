<x-app-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="reflink" value="{{Request::root().'/register/'.Auth::user()->username}}" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-default" onclick="copyLink()" type="button">COPY</button>
                    </span>
                </div><!-- /input-group -->   
            </div>            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">copyright</i>
                    </div>
                    <p class="card-category">Balance</p>
                    <h5 class="card-title">${{$balance}}</h5>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger">equalizer</i>
                        <a href="#pablo">Current Balance</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">card_giftcard</i>
                    </div>
                    <p class="card-category">Investment</p>
                    <h5 class="card-title">${{$mature}}</h5>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">local_offer</i> Your Deposits
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">exit_to_app</i>
                    </div>
                    <p class="card-category">Referral Bonus</p>
                    <h5 class="card-title">${{$bonus}}</h5>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i> From your referrals
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <p class="card-category">Affiliates</p>
                    <h5 class="card-title">{{$referrals}}</h5>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Investors you introduced
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyLink() {
        /* Get the text field */
        var copyText = document.querySelector("#reflink");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Copied the Link: " + copyText.value);
        };
    </script>
</x-app-layout>
