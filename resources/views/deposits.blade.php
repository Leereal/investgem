<x-app-layout>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>         
          <h4 class="card-title">All Deposits</h4>          
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
                <thead class="">
                  <th>DATE</th>
                  <th>USERNAME</th>                  
                  <th>AMOUNT</th>
                  <th>PLAN</th>                  
                  <th>BANK</th>
                  <th>POP</th>
                  <th>ACTION</th>
                  {{-- <th>STATUS</th> --}}
                </thead>
                <tbody> 
                  @foreach($deposits as $deposit) 
                  <form action="/approve" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="bid" value="{{$deposit->id}}">
                        <tr>
                            <td>{{$deposit->created_at}}</td> 
                            <td>{{$deposit->user->username}}</td>
                            <td>${{$deposit->amount}}</td>
                            <td>{{$deposit->plan->name}}</td>                    
                            <td>{{$deposit->bank->name}}</td>
                            <td>{{$deposit->pop}}</td>
                            <td>
                                @if($deposit->status == 2)
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
