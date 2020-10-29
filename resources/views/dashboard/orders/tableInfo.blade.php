<thead class="thead-dark">
    <tr>
        <th scope="col">رقم الطلب</th>
        <th scope="col">الحالة </th>
        <th scope="col">رقم صاحب الطلب</th>
        <th scope="col">وقت الإنشاء</th>
        <th scope="col"> تفاصيل الطلب</th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->id}}</td>
        <td>{{$record->status_ar}}</td>
        <td>{{$record->user->phone}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <button class="btn-sm btn btn-success orderInfo mb-1" data-toggle="modal" data-target="#orderInfo-modal"><i class="fas fa-shopping-cart"></i></button>
        </td> 
        <td>
          <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
