<thead class="thead-dark">
    <tr>
        <th scope="col">الرسالة</th>
        <th scope="col">الاسم</th>
        <th scope="col">التليفون</th>
        <th scope="col">البريد الإلكتروني</th>
        <th scope="col">وقت الإنشاء</th>
        <th scope="col">مفتوحة</th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
@foreach($records as $record)
<tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{Str::words($record->message,6,'..')}}</td>
        <td>{{$record->name}}</td>
        <td>{{$record->phone}}</td>
        <td>{{$record->email}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->status=='open') checked @endif data-type="status">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
        </td>
        <td>
          <button class="btn-sm btn btn-danger mb-1 delete"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
