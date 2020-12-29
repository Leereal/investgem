<x-app-layout>
  @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
  @endif
  @if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">compare_arrows</i>
              </div>
              <h4 class="card-title">Withdraw</h4>
            </div>
            <form method="POST" action="/withdraw">
              {{ csrf_field() }}
              <input type="hidden" name="investment" value="{{$investment ?? ""}}">
            <div class="card-body ">   
                <div class="dropdown bootstrap-select show">
                    <select class="selectpicker" name="payment_method" data-size="7" data-style="btn btn-primary btn-round" title="Single Select" tabindex="-98">
                      <option disabled="" selected="">PAYMENT METHOD</option>
                      @if(!$bank_details->isEmpty())
                        @foreach($bank_details as $bank_detail)
                        <option value="{{$bank_detail->id}}">{{$bank_detail->bank->name ."-". $bank_detail->account_number}}</option>
                        @endforeach   
                      @endif
                    </select> 
                </div>                           
                <div class="form-group">
                  <label for="amount" class="bmd-label-floating">Amount</label>
                  <input type="text" class="form-control"name="amount"  id="amount">
                </div>
            </div>
            <div class="card-footer ">
              <button type="submit" class="btn btn-fill btn-rose">Submit</button>
            </div>
          </form>
          </div>
        </div>
      </div>
</x-app-layout>
