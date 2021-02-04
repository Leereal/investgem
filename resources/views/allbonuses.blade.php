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
            <table class="table text-nowrap">
                <thead class="">
                  <th>USER ID</th>
                  <th>USERNAME</th>                  
                  <th>TOTAL AMOUNT</th>
                  <th>BALANCE</th>
                  <th>AFFILIATES</th>                  
                  <th>ACTION</th>
                  {{-- <th>STATUS</th> --}}
                </thead>
                <tbody> 
                  @foreach($bonuses as $bonus) 
                  <form action="/bonus-action" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="bonus" value="{{$bonus->id}}">
                        <tr>
                            <td>{{$bonus->id}}</td> 
                            <td>{{$bonus->username}}</td>
                            <td>${{$bonus->total_amount}}</td>
                                                       
                            <td>
                                @if($bonus->status == 101 && $bonus->due_date < (date('Y-m-d H:i:s')))
                                    <button type="submit" class="btn btn-success btn-sm btn-round" onclick="confirm('Are you sure you want to mature this?')"><i class="material-icons">add_task</i> MATURE?</button>

                                @elseif($bonus->status == 1)
                                <button type="submit" class="btn btn-info btn-sm btn-round" onclick="confirm('Are you sure you want to reinvest?')"><i class="material-icons">add_task</i> REINVEST</button>
                                
                                @else
                                    <button disabled class="btn btn-primary btn-sm btn-round"><i class="material-icons">schedule</i> RUNNING...</button>
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
