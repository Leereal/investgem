<x-app-layout>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>         
          <h4 class="card-title">All Withdrawals</h4>          
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-nowrap">
                <thead class="">
                  <th>DATE</th>
                  <th>USERNAME</th>                  
                  <th>AMOUNT</th>
                  <th>PLAN</th>                  
                  <th>BANK</th>
                  <th>BRANCH</th>
                  <th>ACOOUNT HOLDER</th>
                  <th>ACCOUNT NUMBER</th>
                  <th>INV DATE</th>
                  <th>INVESTMENT</th>
                  <th>ACTION</th>
                  {{-- <th>STATUS</th> --}}
                </thead>
                <tbody> 
                  @foreach($withdrawals as $withdrawal) 
                  <form action="/approve-withdrawal" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="withdrawal" value="{{$withdrawal->id}}">
                        <tr>
                            <td>{{$withdrawal->created_at}}</td> 
                            <td>{{$withdrawal->user->username}}</td>
                            <td>${{$withdrawal->amount}}</td>
                            <td>{{$withdrawal->investment->plan->name}}</td>  
                            <td>{{$withdrawal->payment_detail->bank->name ?? ''}}</td>                  
                           <td>{{$withdrawal->payment_detail->branch ?? ''}}</td>
                            <td>{{$withdrawal->payment_detail->account_holder ?? ''}}</td>
                            <td>{{$withdrawal->payment_detail->account_number ?? ''}}</td>
                            <td>{{$withdrawal->investment->created_at}}</td>
                            <td>{{$withdrawal->investment->amount}}</td>
                            <td>
                                @if($withdrawal->status == 2)
                                    <button type="submit" class="btn btn-success btn-sm btn-round" onclick="confirm('Are you sure you received?')"><i class="material-icons">add_task</i> Received</button>
                                
                                @else
                                    <button disabled class="btn btn-primary btn-sm btn-round"><i class="material-icons">schedule</i> Approved</button>
                                @endif 
                            </td>
                            {{-- <td>{{$investment->status}}</td>               --}}
                        </tr>
                  </form>
                  @endforeach   
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
