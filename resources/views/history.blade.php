<x-app-layout>
    <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header ">
              <h4 class="card-title">Previous Transactions
                <small class="description">History</small>
              </h4>
            </div>
            <div class="card-body ">
              <ul class="nav nav-pills nav-pills-warning" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
                    Investments
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                    Deposits
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#link3" role="tablist">
                    Bonuses
                  </a>
                </li>                
              </ul>
              <div class="tab-content tab-space">
                <div class="tab-pane active" id="link1">
                    <table class="table">
                        <thead class="">
                          <th>DATE</th>
                          <th>AMOUNT</th>
                          <th>PLAN</th>
                          <th>MATURITY DATE</th>
                          <th>BANK</th>
                        </thead>
                        <tbody> 
                          @foreach($investments as $investment) 
                          <tr>
                            <td>{{$investment->created_at}}</td> 
                            <td>${{$investment->amount}}</td>
                            <td>{{$investment->plan->name}}</td>
                            <td>{{$investment->due_date}}</td>
                            <td>{{$investment->bank->name}}</td>             
                          </tr>
                          @endforeach   
                        </tbody>
                      </table>
                </div>
                <div class="tab-pane" id="link2">
                    <table class="table">
                        <thead class="">
                          <th>DATE</th>
                          <th>AMOUNT</th>
                          <th>PAYMENT METHOD</th>
                          <th>PLAN</th>
                          <th>STATUS</th>
                        </thead>
                        <tbody>                          
                          @foreach($bids as $bid) 
                          <tr>
                            <td>{{$bid->created_at}}</td> 
                            <td>${{$bid->amount}}</td>
                            <td>{{$bid->bank->name}}</td>
                            <td>{{$bid->plan->name}}</td>
                            <td>
                              @if($bid->status == 101)
                                <span class="badge badge-primary">Waiting Approval</span>
                              @else
                                <span class="badge badge-success">Approved</span>
                              @endif
                            </td>         
                          </tr>
                          @endforeach  
                        </tbody>
                      </table>
                </div>
                <div class="tab-pane" id="link3">
                    <table class="table">
                        <thead class="">
                          <th>DATE</th>
                          <th>AMOUNT</th>
                          <th>INVESTMENT</th>
                          {{-- <th>STATUS</th>           --}}
                        </thead>
                        <tbody>  
                          @foreach($bonuses as $bonus) 
                          <tr>
                            <td>{{$bonus->created_at}}</td> 
                            <td>${{$bonus->amount}}</td>
                            <td>${{$bonus->investment->amount}}</td>
                            {{-- <td>{{$bonus->status}}</td>              --}}
                          </tr>
                          @endforeach  
                        </tbody>
                      </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</x-app-layout>
