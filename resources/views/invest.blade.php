<x-app-layout>            
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">         
                <div class="card ">
                  <div class="card-header ">
                    <h4 class="card-title">Payment Methods
                      <small class="description">Choose Below</small>
                    </h4>
                  </div>
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-md-4">
                        <ul class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#link4" role="tablist">
                              Bitcoin
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link5" role="tablist">
                              Perfect Money
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link6" role="tablist">
                              Neteller
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link7" role="tablist">
                              Bank Transfer
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link8" role="tablist">
                              EWallet
                            </a>
                          </li>
                        </ul>
                      </div>
                      <div class="col-md-8">
                        <div class="tab-content">
                          <div class="tab-pane active show" id="link4">
                            <div class="input-group">
                                <input type="text" id="reflink" value="1Hs61zaxSaCFhtZKsKjrgsvFbiLU4Gv9Gu" class="form-control">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="copyBTC()" type="button">COPY</button>
                                </span>
                            </div><!-- /input-group --> 
                            <div>
                                <h4>Instructions</h4>
                                <p>Make sure you have bitcoin in your wallet. We recommend you open account with Luno, BitPay, Blockchain or any of your choice</p>
                                <p><strong>Step 1:</strong> Copy the bitcoin address above as it is please do not type it in. Copy it</p>
                                <p><strong>Step 2:</strong> Send bitcoin to the bitcoin address that you copied here</p>
                                <p><strong>Step 3:</strong> Take Screeshot of your payment</p>
                                <p><strong>Step 4:</strong> Return to this attach your screenshot on the next section. Make sure you include the amount when submitting your deposit.</p>
                                <p><strong>Step 5:</strong> Amount must be in dollars ($) please use current Google rate and do not include a $ sign symbol on amount</p>
                            </div> 
                          </div>
                          <div class="tab-pane" id="link5">
                            <div><h3>Please Contact Support to get payment details.</h3></div>
                          </div> 
                          <div class="tab-pane" id="link6">
                            <div><h3>Please Contact Support to get payment details.</h3></div>
                          </div> 
                          <div class="tab-pane" id="link7">
                            <div><h3>Please Contact Support to get payment details.</h3></div>
                          </div> 
                          <div class="tab-pane" id="link8">
                            <div><h3>Please Contact Support to get payment details.</h3></div>
                          </div>                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>        
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12"> 
          @if(session()->has('message'))
              <div class="alert alert-success text-center">
                  {{ session()->get('message') }}
              </div>
          @endif
          @if (isset($errors) && count($errors) > 0)
              <div class="alert alert-danger text-center">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif          
            <div class="card card-pricing card-raised">
                <div class="card-body">
                    <form action="/bids" method="POST" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <h6 class="card-category"></h6>   
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                <img src="../../assets/img/image_placeholder.jpg" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div>
                                <span class="btn btn-rose btn-sm btn-round btn-file">
                                <span class="fileinput-new">UPLOAD POP</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="pop" />
                                </span>
                                <a href="#pablo" class="btn btn-danger btn-sm btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>                
                            <h3 class="card-title">Choose your plan</h3>
                        </div>
                        @foreach($plans as $plan)
                        <div class="form-check form-group">
                            <div class="orm-group btn btn-outline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="plan" value="{{$plan->id}}">{{$plan->name}} | {{$plan->interest}}%
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>                            
                        </div>
                        @endforeach
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" class="form-control" name="amount" placeholder="Amount (in dollar value)" aria-label="Amount (to the nearest dollar)">
                          <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                          </div>
                        </div>
                        <div class="dropdown bootstrap-select show">
                          <select class="selectpicker" name="payment_method" data-size="7" data-style="btn btn-primary btn-round" title="Single Select" tabindex="-98">
                            <option disabled="" selected="">PAYMENT METHOD</option>
                            @foreach($banks as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                            @endforeach   
                          </select> 
                        </div>
                        <div>
                          <button type="submit" class="btn btn-rose btn-round">INVEST</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="text-danger">Please contact support or admin for approval after making payment</p>
                </div>
            </div>       
        </div>        
    </div>
    <script>
        function copyBTC() {
        /* Get the text field */
        var copyText = document.querySelector("#reflink");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Copied the Address: " + copyText.value);
        };
    </script>
</x-app-layout>
