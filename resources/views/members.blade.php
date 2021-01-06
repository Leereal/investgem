<x-app-layout>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>         
          <h4 class="card-title">Members</h4>          
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-nowrap">
                <thead class="">
                  <th>DATE JOINED</th>
                  <th>USERNAME</th>                  
                  <th>CELLPHONE</th>
                  <th>REFERRER</th> 
                  {{-- <th>STATUS</th> --}}
                </thead>
                <tbody> 
                  @foreach($members as $member)                  
                        <tr>
                            <td>{{$member->created_at}}</td> 
                            <td>{{$member->username}}</td>
                            <td>${{$member->cellphone}}</td>
                            <td>{{$member->referrer->username}}</td> 
                        </tr> 
                  @endforeach   
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
