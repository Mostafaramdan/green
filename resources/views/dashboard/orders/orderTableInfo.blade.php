<thead class="thead-dark">
      <tr>
            <th scope="col"></th>
            <th scope="col">اسم </th>
            <th scope="col">السعر</th>
            <th scope="col">كمية</th>
            <th scope="col">صورة</th>
      </tr>
</thead>
<tbody>
      @foreach($records as $record)
            <tr class="bg-primary">
                  <th scope="row">#</th>
                  <td>{{$record->product->name_ar??""}}</td>
                  <td>{{$record->product->price??""}}</td>
                  <td>{{$record->quantity}}</td>
                  <td><a target="_blank"href="asset({{$record->product->mainImage}}"><img style="height:100px;width:100px" src="{{asset($record->product->images->first()->image??'')}}"></img></a></td>
                  
            </hr>
            <br>
      @endforeach
</tbody>